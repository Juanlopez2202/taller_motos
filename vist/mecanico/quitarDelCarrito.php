
<?php
if (!isset($_GET["indice"])) return;
$indice = $_GET["indice"];

session_start();

// Verificar si el índice es válido y existe en el carrito
if (is_numeric($indice)) {
    $indice = intval($indice);

    // Verificar si el índice pertenece al carrito de productos
    

    // Verificar si el índice pertenece al carrito de servicios
    if (isset($_SESSION["carrito_servicios"][$indice])) {
        unset($_SESSION["carrito_servicios"][$indice]);
        header("Location: vender.php?status=12"); // Servicio eliminado correctamente
        exit();
    }


}

// Redireccionar a la página "vender.php" con el mensaje de error
header("Location: vender.php?status=2"); // Error al eliminar el elemento
exit();
?>