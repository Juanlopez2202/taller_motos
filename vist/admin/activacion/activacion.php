<?php
    require_once("../../../bd/conexion.php");
    $sql = new database();
    $con = $sql ->conectar();
?>

<?php
        $update = $con -> prepare("UPDATE usuarios SET id_estado = 1 WHERE documento = ".$_POST['activo']."");
        $actualizar = $update ->execute();
        echo '<script>alert ("Estado actualizado correctamente");</script>';
        echo '<script> window.location="../usuarios.php"</script>'
?>