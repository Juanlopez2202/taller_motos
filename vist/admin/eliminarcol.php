<?php


require_once("../../bd/conexion.php");
$db = new Database();
$conectar= $db->conectar();


?>
<?php

  if ((isset($_POST["elimi"]))){

  $eliminar=$conectar->prepare("DELETE  FROM color where id_color ='".$_POST['elimi']."'");
  $eliminar->execute();
 echo '<script>alert ("Registro Eliminado");</script>';
 echo '<script> window.location="color.php"</script>';
}  

?>