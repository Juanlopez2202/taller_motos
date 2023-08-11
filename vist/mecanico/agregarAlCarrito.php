<?php
session_start();
require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST["codigo"];

   
   
   
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
        } 
            } else {
                header("Location: vender.php?status=2"); // Producto, servicio o documento no existe
                exit();
            }
            


header("Location: vender.php");
exit();
?>
