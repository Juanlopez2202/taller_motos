<?php
    require_once("../../../bd/conexion.php");
    $con = new database();
    $sqli = $con ->conectar();
?>

<?php
        $update = $sqli -> prepare("UPDATE usuarios SET id_estado = 2 WHERE documento = ".$_POST['inactivo']."");
        $actu = $update -> execute();
        echo '<script>alert ("Estado actualizado correctamente");</script>';
        echo '<script> window.location="../usuarios.php"</script>'
?>