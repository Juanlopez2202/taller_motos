<?php

session_start();

unset($_SESSION["carrito_servicios"] );
$_SESSION["carrito_servicios"] = [];



header("Location: ./vender.php?status=4");
?>