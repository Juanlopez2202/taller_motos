<?php
session_start();
require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();
date_default_timezone_set('America/Bogota');
if (!isset($_POST["placa"])) {
    echo '<script>alert("NO HAS COLOCADO LA PLACA DEL VEHICULO");</script>';
    echo '<script>window.location="vender.php"</script>';
}
if ((empty($_SESSION["carrito_productos"])) && empty($_SESSION["carrito_servicios"]) && empty($_SESSION["carrito_documentos"])) {
    echo '<script>alert("NO HAS AGREGADO NADA AL CARRITO ");</script>';
    echo '<script>window.location="vender.php"</script>';
    exit();
}
if (!isset($_POST["vendedor"])) {
    echo '<script>alert("NO HAS SELECCIONADO LA CEDULA DEL VENDEDOR");</script>';
    echo '<script>window.location="vender.php"</script>';
}
if (!isset($_SESSION["carrito_documentos"])) {
    $_SESSION["carrito_documentos"] = []; // Inicializar como un arreglo vacío si no existe
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST["placa"];
    $granTotal = $_POST['gran_total'];
    $total = $granTotal;
    $documentos = $_SESSION["carrito_documentos"];

    $fechaVenta = date("Y-m-d"); // Fecha actual
    $fechaVigenciaSoat = null; // Inicializar la fecha de vigencia de SOAT como nula
    $fechaVigenciaTecnomecanica = null;
    $vendedor = $_POST['vendedor']; // Obtener el nombre del vendedor

    // Validar si se vende el servicio con ID 25 (Cambio de Aceite)
    $ventaCambioAceite = false;
    foreach ($_SESSION["carrito_servicios"] as $servicio) {
        $nombre = $servicio["nombre"];
        if ($nombre === "cambio aceite") {
            $ventaCambioAceite = true;
            break;
        }
    }

    // Obtener el tipo de documento vendido (SOAT o Tecnomecánica) según el contenido del carrito de documentos
    if (isset($_SESSION["carrito_documentos"])) {
        $documentos = $_SESSION["carrito_documentos"];
        $ventaSOAT = false;
        $ventaTecnomecanica = false;

        foreach ($documentos as $documento) {
            $id_documento = $documento["id"];

            // Verificar si el carrito contiene SOAT (id_documentos = 10) o Tecnomecánica (id_documentos = 20)
            if ($id_documento === "10") {
                $ventaSOAT = true;
            } elseif ($id_documento === "20") {
                $ventaTecnomecanica = true;
            }
        }

        // Verificar si la moto ya tiene vigente el SOAT o la Tecnomecánica
        $consultaVigenciaSoat = $conectar->prepare("SELECT MAX(fecha_vigencia_soat) AS fecha_vigencia_soat FROM factura_venta WHERE placa = ? AND fecha_vigencia_soat >= CURDATE()");
        $consultaVigenciaSoat->execute([$placa]);
        $resultadoVigenciaSoat = $consultaVigenciaSoat->fetch(PDO::FETCH_ASSOC);

        $consultaVigenciaTecnomecanica = $conectar->prepare("SELECT MAX(fecha_vigencia_tecnomecanica) AS fecha_vigencia_tecnomecanica FROM factura_venta WHERE placa = ? AND fecha_vigencia_tecnomecanica >= CURDATE()");
        $consultaVigenciaTecnomecanica->execute([$placa]);
        $resultadoVigenciaTecnomecanica = $consultaVigenciaTecnomecanica->fetch(PDO::FETCH_ASSOC);

        // Ajustar las fechas de vigencia para SOAT y Tecnomecánica según el tipo de documento vendido
        if ($ventaSOAT && $resultadoVigenciaSoat["fecha_vigencia_soat"] !== null) {
            header("Location: vender.php?status=8"); // El vehículo ya tiene vigente el SOAT
            exit();
        }

        if ($ventaTecnomecanica && $resultadoVigenciaTecnomecanica["fecha_vigencia_tecnomecanica"] !== null) {
            header("Location: vender.php?status=9"); // El vehículo ya tiene vigente la Tecnomecánica
            exit();
        }

        if ($ventaSOAT) {
            if (!isset($_POST["aseguradora"])) {
                echo '<script>alert("Agregue la Aseguradora");</script>';
                echo '<script>window.location="vender.php"</script>';
                exit();
            }
            $fechaVigenciaSoat = date("Y-m-d", strtotime("+1 year"));
            $empresa = $_POST['aseguradora'];
        }

        if ($ventaTecnomecanica) {
            if (!isset($_POST["aseguradora"])) {
                echo '<script>alert("Agregue la Aseguradora");</script>';
                echo '<script>window.location="vender.php"</script>';
                exit();
            }
            $fechaVigenciaTecnomecanica = date("Y-m-d", strtotime("+1 year"));

            $empresa = $_POST['aseguradora'];
        }
    }

    $insertVenta = $conectar->prepare("INSERT INTO factura_venta (placa, fecha, fecha_vigencia_soat, fecha_vigencia_tecnomecanica, aseguradora, documento, total, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Establecer las fechas de vigencia según el tipo de documento vendido
    $insertVenta->execute([$placa, $fechaVenta, $fechaVigenciaSoat, $fechaVigenciaTecnomecanica, $empresa, $vendedor, $total, 'vigente']); // Por defecto, se establece como "nueva"

    // Obtener el ID de la venta recién insertada
    $id_venta = $conectar->lastInsertId();

    // Si la fecha de vigencia SOAT o Tecnomecánica es menor a la fecha actual, actualizamos el estado a "vencida"
   
    // Actualizar existencias de los productos vendidos
    if (isset($_SESSION["carrito_productos"])) {
        foreach ($_SESSION["carrito_productos"] as $producto) {
            $id_producto = $producto["id"];
            $cantidad = $producto["cantidad"];
            $subtotal = $producto["subtotal"];

            // Restar la cantidad vendida a las existencias del producto
            $actualizarExistencias = $conectar->prepare("UPDATE productos SET cantidad_ini = cantidad_ini - ? WHERE id_productos = ?");
            $actualizarExistencias->execute([$cantidad, $id_producto]);

            $insertVentaProducto = $conectar->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)");
            $insertVentaProducto->execute([$id_venta, $id_producto, $cantidad, $subtotal]);
        }
    }

    // Guardar los servicios de la venta en la tabla "detalle_vservi"
    if (isset($_SESSION["carrito_servicios"])) {
        foreach ($_SESSION["carrito_servicios"] as $servicio) {
            $id_servicio = $servicio["id"];
            $cantidad = $servicio["cantidad"];
            $subtotal = $servicio["subtotal"];

            $insertVentaServicio = $conectar->prepare("INSERT INTO detalle_vservi (id_venta, id_servicio, cantidad, subtotal) VALUES (?, ?, ?, ?)");
            $insertVentaServicio->execute([$id_venta, $id_servicio, $cantidad, $subtotal]);

            // Si se vende el servicio de cambio de aceite (ID 25), calcular la cantidad de días estimados para el próximo cambio de aceite
            if ( $ventaCambioAceite === true) {

                $fecha_cambio = date('y-m-d');
                // Calcular la cantidad de kilómetros recomendados para el cambio de aceite (por ejemplo, cada 5000 km)
                $kmPorCambioAceite = 3000;

                // Calcular la cantidad de kilómetros que una persona puede recorrer en una moto por día
                $kmPorDia = 100; // Puedes ajustar esta cantidad según tus requerimientos

                // Calcular la cantidad de días estimados para el próximo cambio de aceite
                $diasEstimadosCambioAceite = ceil($kmPorCambioAceite / $kmPorDia);

                // Calcular la fecha estimada para el próximo cambio de aceite
                $proximoCambioAceiteFecha = date("Y-m-d", strtotime("+$diasEstimadosCambioAceite days"));

                // Actualizar la próxima fecha estimada para el cambio de aceite en la tabla "moto"
                $actualizarProximoCambioAceite = $conectar->prepare("UPDATE moto SET ultimo_cambio = ?, proximo_cambio_km = ?, proximo_cambio_fecha = ? WHERE placa = ?");
                $actualizarProximoCambioAceite->execute([$fecha_cambio,$kmPorCambioAceite, $proximoCambioAceiteFecha, $placa]);
            }
        }
    }

    // Guardar los documentos de la venta en la tabla "detalle_vdocu"
    if (isset($_SESSION["carrito_documentos"])) {
        foreach ($_SESSION["carrito_documentos"] as $documento) {
            $id_documento = $documento["id"];
            $cantidad = $documento["cantidad"];
            $subtotal = $documento["subtotal"];

            $insertVentaDocumento = $conectar->prepare("INSERT INTO detalle_vdocu (id_venta, id_documentos,  subtotal) VALUES (?, ?, ?)");
            $insertVentaDocumento->execute([$id_venta, $id_documento, $subtotal]);
        }
        $actualizarEstadoVencidas = $conectar->prepare("UPDATE factura_venta SET estado = 'vencida' WHERE placa = ? AND ((fecha_vigencia_soat < CURDATE() AND fecha_vigencia_soat IS NOT NULL) AND (fecha_vigencia_tecnomecanica < CURDATE() AND fecha_vigencia_tecnomecanica IS NOT NULL))");
        $actualizarEstadoVencidas->execute([$placa]);
    }
    
    // Limpia el carrito de compras
        // ... Resto de tu código existente ...

    // Limpia el carrito de compras
    unset($_SESSION["carrito_productos"]);
    unset($_SESSION["carrito_servicios"]);
    unset($_SESSION["carrito_documentos"]);

    header("Location: vender.php?status=10");
} else {
    echo "Error al procesar la venta.";
}

// ... Resto de tu código ...
?>
