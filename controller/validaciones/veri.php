<?php  
require_once("../../bd/conexion.php");
$db = new database();
$conectar= $db->conectar();
?>

<?php
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    $sqli = $conectar->prepare("SELECT token FROM usuarios WHERE email = '$email'");
    $sqli->execute();
    $token = $sqli->fetchColumn();
    
    
    $titulo ="Verificacion de su cuenta ";
    $msj = "Para verificar tu cuenta pulsa el siguiente link: http://localhost/taller/controller/validaciones/verificacion.php?token=" . $token;
    $tucorreo="From:juan.lopez7196@misena.edu.co";
    if(mail($email, $titulo, $msj, $tucorreo))
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
}else{
    echo'<script>alert("ERROR, intentelo nuevamente");</script>';
        echo '<script> window.location="../../index.html"</script>';
        exit();
}
?>