<?php

require_once("../../bd/conexion.php");
$db = new database();
$conectar = $db->conectar();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Primero verificamos si el token existe en la base de datos y si no ha sido usado antes
    $verificacion = $conectar->prepare("SELECT * FROM usuarios WHERE token = '$token' AND id_estado = 2");
    $verificacion->execute();
    
    if ($verificacion->rowCount() > 0) {
        // El token es válido y no ha sido usado antes, entonces actualizamos el estado del usuario
        $sqli = $conectar->prepare("UPDATE usuarios SET id_estado = 1, token = NULL WHERE token = '$token'");
        
        if ($sqli->execute()) {
            echo '<script>alert("Su correo ha sido verificado correctamente.");</script>';
            echo '<script>window.location="../../index.html"</script>';
        } else {
            echo '<script>alert("Error al verificar el correo. Por favor, intenta nuevamente.");</script>';
            echo '<script>window.location="../../index.html"</script>';
        }
    } else {
        echo '<script>alert("El enlace ya ha sido utilizado o no es válido.");</script>';
        echo '<script>window.location="../../index.html"</script>';
    }
} else {
    echo '<script>alert("No se ha proporcionado un token de verificación.");</script>';
    echo '<script>window.location="../../index.html"</script>';
}
?>
