<?php
session_start();
require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST["codigo"];

    // Verificar si es un producto
    $consultaProducto = $conectar->prepare("SELECT * FROM productos WHERE id_productos = ?");
    $consultaProducto->execute([$codigo]);
    $producto = $consultaProducto->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $cantidadExistencias = $producto["cantidad_ini"];

        // Verificar la cantidad de existencias
        if ($cantidadExistencias > 0) {
            $carritoProductos = isset($_SESSION["carrito_productos"]) ? $_SESSION["carrito_productos"] : [];

            // Verificar si el producto ya está en el carrito
            $productoEnCarrito = false;
            foreach ($carritoProductos as &$item) {
                if ($item["id"] == $producto["id_productos"]) {
                    if ($item["cantidad"] >= $cantidadExistencias) {
                        header("Location: vender.php?status=3"); // Producto agotado
                        exit();
                    }
                    $item["cantidad"]++;
                    $item["subtotal"] = $item["cantidad"] * $item["precio"];
                    $productoEnCarrito = true;
                    break;
                }
            }

            // Si el producto no está en el carrito, agregarlo
            if (!$productoEnCarrito) {
                $nuevoProducto = [
                    "id" => $producto["id_productos"],
                    "nombre" => $producto["nom_producto"],
                    "descripcion" => $producto["descripcion"],
                    "precio" => $producto["precio"],
                    "cantidad" => 1,
                    "subtotal" => $producto["precio"]
                ];

                $carritoProductos[] = $nuevoProducto;
            }

            $_SESSION["carrito_productos"] = $carritoProductos;
            header("Location: vender.php?status=1"); // Producto agregado correctamente
            exit();
        } else {
            header("Location: vender.php?status=3"); // Producto agotado
            exit();
        }
    } else {
        // Verificar si es un servicio
        $consultaServicio = $conectar->prepare("SELECT * FROM servicio WHERE id_servicios = ?");
        $consultaServicio->execute([$codigo]);
        $servicio = $consultaServicio->fetch(PDO::FETCH_ASSOC);

        if ($servicio) {
            // Check if the service already exists in the cart
            $carritoServicios = isset($_SESSION["carrito_servicios"]) ? $_SESSION["carrito_servicios"] : [];
            foreach ($carritoServicios as &$item) {
                if ($item["id"] == $servicio["id_servicios"]) {
                    header("Location: vender.php?status=6"); // Servicio ya agregado
                    exit();
                }
            }

            $nuevoServicio = [
                "id" => $servicio["id_servicios"],
                "nombre" => $servicio["servicio"],
                "descripcion" => $servicio["descripcion"],
                "precio" => $servicio["precio"],
                "cantidad" => 1,
                "subtotal" => $servicio["precio"]
            ];

            $carritoServicios[] = $nuevoServicio;
            $_SESSION["carrito_servicios"] = $carritoServicios;
            header("Location: vender.php?status=1"); // Servicio agregado correctamente
            exit();
        } else {
            // Verificar si es un documento
            $consultaDocumento = $conectar->prepare("SELECT * FROM documentos WHERE id_documentos = ?");
            $consultaDocumento->execute([$codigo]);
            $documento = $consultaDocumento->fetch(PDO::FETCH_ASSOC);

            if ($documento) {
                // Check if the document already exists in the cart
                $carritoDocumentos = isset($_SESSION["carrito_documentos"]) ? $_SESSION["carrito_documentos"] : [];
                foreach ($carritoDocumentos as &$item) {
                    if ($item["id"] == $documento["id_documentos"]) {
                        header("Location: vender.php?status=7"); // Documento ya agregado
                        exit();
                    }
                }

                $nuevoDocumento = [
                    "id" => $documento["id_documentos"],
                    "nombre" => $documento["documentos"],
                    "descripcion" => $documento["descripcion"],
                    "precio" => $documento["precio"],
                    "cantidad" => 1,
                    "subtotal" => $documento["precio"]
                ];

                $carritoDocumentos[] = $nuevoDocumento;
                $_SESSION["carrito_documentos"] = $carritoDocumentos;
                header("Location: vender.php?status=1"); // Documento agregado correctamente
                exit();
            } else {
                header("Location: vender.php?status=2"); // Producto, servicio o documento no existe
                exit();
            }
        }
    }
}

header("Location: vender.php");
exit();
?>
