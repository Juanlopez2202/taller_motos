<?php
require_once("bd/conexion.php");
session_start();

;

$db = new database();
$conectar = $db->conectar();
   if (isset($_GET['token'])) {
    $cedula = $_GET['token'];
    $verificacion = $conectar->prepare("SELECT * FROM usuarios where documento = '$cedula' AND id_tip_usu = 1 ");
    $verificacion->execute();

    if ($verificacion->rowCount() > 0 ) {
        $usuario = $verificacion->fetch(PDO::FETCH_ASSOC);
        $token = $usuario['token'];
        $correo = $usuario['email'];
        $paracorreo = $correo;
        $titulo ="Usuario bloqueo";
        $msj = "Administrador se acaba de inavilitar su usuario por exceder el numero establecido de intentos, por favor revise que usuario y habilitelo con el siguiente codigo 
        el codigo es : $token y el link http://localhost/taller/controller/validaciones/habilitar.php
        ";
        $tucorreo="From:juan.lopez@misena.edu.co";
        if(mail($paracorreo, $titulo, $msj, $tucorreo))
        {
            echo'<script>alert("Correo enviado con exito");</script>';
            echo '<script> window.location="index.html"</script>';
            exit();
        }else{
            echo'<script>alert("ERROR, intentelo nuevamente");</script>';
            echo '<script> window.location="index.html"</script>';
            exit();
        } 
    
    }else{
        $verificacion = $conectar->prepare("SELECT email FROM usuarios where id_tip_usu = 1 ");
        $verificacion->execute();
        $usuario = $verificacion->fetch(PDO::FETCH_ASSOC);
        $correo = $usuario['email'] ;
        $paracorreo = $correo;
        $titulo ="Usuario bloqueo";
        $msj = "Administrador se acaba de inavilitar un usuario por exceder el numero establecido de intentos, por favor revise que usuario es y habilitelo nuevamente";
        $tucorreo="From:juan.lopez@misena.edu.co";
        if(mail($paracorreo, $titulo, $msj, $tucorreo))
        {
            echo'<script>alert("Correo enviado con exito");</script>';
            echo '<script> window.location="index.html"</script>';
            exit();
        }
        else{
            echo'<script>alert("ERROR, intentelo nuevamente");</script>';
            echo '<script> window.location="index.html"</script>';
            exit();
    }
    

    }
}
   
?>