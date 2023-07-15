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
                if ($item["id_productos"] == $producto["id_productos"]) {
                    if ($item["cantidad"] >= $cantidadExistencias) {
                         header("Location: vender.php?status=1");
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
                    "id_productos" => $producto["id_productos"],
                    "nom_producto" => $producto["nom_producto"],
                    "descripcion" => $producto["descripcion"],
                    "precio" => $producto["precio"],
                    "cantidad" => 1,
                    "subtotal" => $producto["precio"]
                ];

                $carritoProductos[] = $nuevoProducto;
            }

            $_SESSION["carrito_productos"] = $carritoProductos;
        }else {
            header("Location: vender.php?status=1");
            exit();
        }
    } else {
        // Verificar si es un servicio
        $consultaServicio = $conectar->prepare("SELECT * FROM servicio WHERE id_servicios = ?");
        $consultaServicio->execute([$codigo]);
        $servicio = $consultaServicio->fetch(PDO::FETCH_ASSOC);

        if ($servicio) {
            $nuevoServicio = [
                "id_servicio" => $servicio["id_servicios"],
                "servicio" => $servicio["servicio"],
                "descripcion" => $servicio["descripcion"],
                "precio" => $servicio["precio"],
                "cantidad" => 1,
                "subtotal" => $servicio["precio"]
            ];

            $_SESSION["carrito_servicios"][] = $nuevoServicio;
        } else {
            // Verificar si es un documento
            $consultaDocumento = $conectar->prepare("SELECT * FROM documentos WHERE id_documentos = ?");
            $consultaDocumento->execute([$codigo]);
            $documento = $consultaDocumento->fetch(PDO::FETCH_ASSOC);

            if ($documento) {
                $nuevoDocumento = [
                    "id_documento" => $documento["id_documentos"],
                    "nombre_documento" => $documento["nombre_documento"],
                    "descripcion" => $documento["descripcion"],
                    "precio" => $documento["precio"],
                    "cantidad" => 1,
                    "subtotal" => $documento["precio"]
                ];

                $_SESSION["carrito_documentos"][] = $nuevoDocumento;
            } else {
                header("Location: vender.php?status=3");
                exit ();
            }
        }
    }
}

header("Location: vender.php");
exit();