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


        if (isset($_SESSION["carrito_servicios"][$indice])) {
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
        } 
    


// Si no se envió la cantidad o el índice, o el índice no existe en el carrito
header("Location: vender.php?status=4"); // Error al actualizar la cantidad
exit();
?>
