<?php
session_start();
require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();

if (!isset($_POST["cantidad"]) || !isset($_POST["indice"])) {
    exit("Error: Datos incompletos");
}

$cantidad = intval($_POST["cantidad"]);
$indice = intval($_POST["indice"]);

// Verificar si el índice pertenece a productos, servicios o documentos
if (isset($_SESSION["carrito_productos"][$indice])) {
    $producto = $_SESSION["carrito_productos"][$indice];
    $consultaProducto = $conectar->prepare("SELECT cantidad_ini FROM productos WHERE id_productos = ?");
    $consultaProducto->execute([$producto["id"]]);
    $productoBD = $consultaProducto->fetch(PDO::FETCH_ASSOC);

    if ($cantidad <= 0 || $cantidad > $productoBD["cantidad_ini"]) {
        header("Location: vender.php?status=3"); // Cantidad inválida o excede las existencias disponibles
        exit();
    }

    $_SESSION["carrito_productos"][$indice]["cantidad"] = $cantidad;
    $_SESSION["carrito_productos"][$indice]["subtotal"] = $cantidad * $producto["precio"];
    header("Location: vender.php?status=5"); // Cantidad actualizada correctamente
    exit();
        } elseif (isset($_SESSION["carrito_servicios"][$indice])) {
            // Obtener el servicio del carrito de servicios
            $item = $_SESSION["carrito_servicios"][$indice];

            // Verificar si la cantidad solicitada es válida
            if ($cantidad <= 0) {
                header("Location: vender.php?status=4"); // Cantidad inválida
                exit();
            }

            // Actualizar la cantidad del servicio en el carrito
            $_SESSION["carrito_servicios"][$indice]["cantidad"] = $cantidad;
            $_SESSION["carrito_servicios"][$indice]["subtotal"] = $item["precio"] * $cantidad;

            header("Location: vender.php?status=2"); // Cantidad actualizada correctamente
            exit();
        } elseif (isset($_SESSION["carrito_documentos"][$indice])) {
            // Obtener el documento del carrito de documentos
            $item = $_SESSION["carrito_documentos"][$indice];

            // Verificar si la cantidad solicitada es válida
            if ($cantidad <= 0) {
                header("Location: vender.php?status=4"); // Cantidad inválida
                exit();
            }

            // Actualizar la cantidad del documento en el carrito
            $_SESSION["carrito_documentos"][$indice]["cantidad"] = $cantidad;
            $_SESSION["carrito_documentos"][$indice]["subtotal"] = $item["precio"] * $cantidad;

            header("Location: vender.php?status=2"); // Cantidad actualizada correctamente
            exit();
        }
    


// Si no se envió la cantidad o el índice, o el índice no existe en el carrito
header("Location: vender.php?status=4"); // Error al actualizar la cantidad
exit();
?>
