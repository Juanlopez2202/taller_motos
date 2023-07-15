<?php
session_start();

    if(!isset($_SESSION['usuario']) || !isset($_SESSION['tipo']))
    {
        header("location: ../../../../taller/index.html");
        exit();
    }

?>