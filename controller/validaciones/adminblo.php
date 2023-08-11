<?php  
require_once("../../bd/conexion.php");
$db = new database();
$conectar = $db->conectar();


if(isset($_POST["codigo"])){
    $token = $_POST["token"];
    $consul = $conectar->prepare("UPDATE usuarios SET id_estado = 1, token = null WHERE token = '$token'");
    $consul->execute(); 
   
    if($consul->rowCount() > 0) {
        echo '<script>alert("Su cuenta ha sido activada correctamente");</script>';
        echo '<script>window.location="../../index.html"</script>';
    } else {
        echo '<script>alert("No se pudo activar la cuenta. Verifique el código.");</script>';
        echo '<script>window.location="../../index.html"</script>';
    }
} else {
    echo '<script>alert("El código no coincide");</script>';
    echo '<script>window.location="../../index.html"</script>';
}
?>