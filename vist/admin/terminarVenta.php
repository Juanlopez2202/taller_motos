<?php
if($_POST["total"] <= 0){
	echo '<script> alert ("NO HA INGRESADO PRODUCTOS");</script>';
	echo '<script> window.location="vender.php"</script>';
}


if(!isset($_POST["placa"])){
	echo '<script> alert ("ELIJA UN VEHICULO");</script>';
	echo '<script> window.location="vender.php"</script>';
}

session_start();
$_SESSION["productota"]= $_POST["total"];
$total = $_POST["total"];
$documento=$_SESSION["documento"];
$placa=$_POST["placa"];
require_once("../../bd/conexion.php");
$db = new database();
$conectar= $db->conectar();


$ahora = date("Y-m-d H:i:s");

$con=$conectar->prepare("SELECT * from estado where id_estado=4");
$con->execute();
$estado=$con->fetch(PDO::FETCH_OBJ);

$sentencia = $conectar->prepare("INSERT INTO factura_venta(fecha,documento, total,placa) VALUES (?, ?,?,?);");
$sentencia->execute([$ahora, $documento,$total,$placa]);

$sentencia = $conectar->prepare("SELECT id_venta FROM factura_venta ORDER BY id_venta DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idventa = $resultado === false ? 1 : $resultado->id_venta;


$conectar->beginTransaction();
$sentencia = $conectar->prepare("INSERT INTO detalle_venta(id_producto, cantidad, id_venta,subtotal) VALUES (?, ?, ?,?);");
$sentenciaExistencia = $conectar->prepare("UPDATE productos SET cantidad_ini = cantidad_ini - ? WHERE id_productos = ?;");

foreach ($_SESSION["carrito"] as $producto) {
	$total += $producto->total;
	$sentencia->execute([$producto->id_productos, $producto->cantidad ,$idventa, $producto->precio]);
	$sentenciaExistencia->execute([$producto->cantidad, $producto->id_productos]);
	
}


$actusql=$conectar->prepare("UPDATE productos SET  id_estado=4 where cantidad_ini < 10");
$actusql->execute();
    
          

	

$conectar->commit();
unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: ./vender.php?status=1");
?>

<?php
