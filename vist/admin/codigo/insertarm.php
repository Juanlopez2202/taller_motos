<?php
    require_once("../../../bd/conexion.php");

    $conectar = new database;
    $db = $conectar -> conectar();

    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];

    $insert = $db -> prepare("INSERT INTO barcodem (nombre,barcode) VALUE (?,?)");
    $insert -> execute([$nombre,$codigo]);

    header("location: ../barcodem.php");
?>