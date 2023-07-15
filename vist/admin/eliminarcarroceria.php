<?php


require_once("../../bd/conexion.php");
$db = new Database();
$conectar= $db->conectar();


?>
<?php

  if ((isset($_POST["elimi"]))){

  $eliminar=$conectar->prepare("DELETE  FROM tipo_carroceria where id_carroceria ='".$_POST['elimi']."'");
  $eliminar->execute();
 echo '<script>alert ("Registro Eliminado");</script>';
 echo '<script> window.location="tip_carroceria.php"</script>';
}  

?>