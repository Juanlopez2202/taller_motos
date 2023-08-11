<?php
session_start();
require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();
date_default_timezone_set('America/Bogota');
if (!isset( $_POST["placa"])) {
    echo '<script>alert("NO HAS COLOCADO LA PLACA DEL VEHICULO");</script>';
    echo '<script>window.location="vender.php"</script>';
}
if (( empty($_SESSION["carrito_servicios"]) )) {
    echo '<script>alert("NO HAS AGREGADO NADA AL CARRITO ");</script>';
    echo '<script>window.location="vender.php"</script>';
    exit();
}
if (!isset($_POST["vendedor"])) {
    echo '<script>alert("NO HAS SELECCIONADO LA CEDULA DEL VENDEDOR");</script>';
    echo '<script>window.location="vender.php"</script>';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST["placa"];
    $granTotal = $_POST['gran_total'];
    $total = $granTotal;
    $fechaVenta = date('y-m-d');
    $vendedor= $_SESSION['documento'];
  
    
    // Validar si se vende el servicio con ID 25 (Cambio de Aceite)
    $ventaCambioAceite = false;
    foreach ($_SESSION["carrito_servicios"] as $servicio) {
        $nombre = $servicio["nombre"];
        if ($nombre === "cambio aceite") {
            $ventaCambioAceite = true;
            break;
        }
    }

   

      
    

    $insertVenta = $conectar->prepare("INSERT INTO factura_venta (placa, fecha,documento, total) VALUES (?, ?, ?, ?)");

    // Establecer las fechas de vigencia según el tipo de documento vendido
    $insertVenta->execute([$placa, $fechaVenta, $vendedor, $total]);
    
    // Obtener el ID de la venta recién insertada
    $id_venta = $conectar->lastInsertId();
    
    
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

   
    // Limpia el carrito de compras
    

    header("Location: vender.php?status=10") ;

} else {
    echo "Error al procesar la venta.";
}
