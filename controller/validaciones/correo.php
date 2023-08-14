<?php
 
require_once("../../bd/conexion.php");
$db = new database();
$conectar= $db->conectar();


 if (isset($_POST['cedula'])) {
    $documento = $_POST['cedula'];
    $sqli = $conectar->prepare("SELECT email FROM usuarios WHERE documento = '$documento'");
    $sqli->execute();
    $correo = $sqli->fetch();
    
     $email=$correo['email'];
    


    $paracorreo = $email;
    $titulo ="Recuperacion de contraseña";
    $msj = "Para cambiar tu contraseña da click en el siguiente link: http://localhost/taller/controller/validaciones/contraseña.php";
    $tucorreo="From:lopezcerquerajuanfrancisco@gmail.com";
    if(mail($paracorreo, $titulo, $msj, $tucorreo))
    {
        echo'<script>alert("Correo enviado con exito");</script>';
        echo '<script> window.location="../../index.html"</script>';
        exit();
    }
    
    else{
        echo'<script>alert("ERROR, intentelo nuevamente");</script>';
     
        echo '<script> window.location="../../index.html"</script>';
        exit();
    }
 }
?>