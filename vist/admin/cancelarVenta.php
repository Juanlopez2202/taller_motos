<?php

session_start();

unset($_SESSION["carrito_productos"] );
$_SESSION["carrito_productos"] = [];
unset($_SESSION["carrito_servicios"] );
$_SESSION["carrito_servicios"] = [];
unset($_SESSION["carrito_documentos"] );
$_SESSION["carrito_documentos"] = [];


header("Location: ./vender.php?status=4");
?>