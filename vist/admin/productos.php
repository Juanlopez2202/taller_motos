<?php



require_once("../../bd/conexion.php");
include "../../controller/styles/dependencias.php";
$db = new database();

$conectar= $db->conectar();

$sql=$conectar->prepare("SELECT * from estado WHERE id_estado = 3");
$sql->execute();
$estado = $sql -> fetch();



if ((isset($_POST["agregar"]))&&($_POST["agregar"]=="formu"))
    {
        $id=$_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $cantidad= $_POST['cantidad'];
        $estado=$_POST['estado'];
        $barcode = $_POST['barcode'];
        

        $validar="SELECT * FROM productos WHERE id_productos='$id' or nom_producto='$nombre'";
        $queryi=$conectar->prepare($validar);
        $queryi->execute();
        $fila1=$queryi->fetchAll(PDO::FETCH_ASSOC);

        if ($fila1){
            echo '<script> alert ("EL PRODUCTO YA EXISTE");</script>';
            echo '<script> windows.location= "index.php"</script>';

        }

        else if ($id=="" || $nombre=="" || $precio=="" || $descripcion=="" || $cantidad=="" || $estado=="" || $barcode == "")
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location="index.php"</script>';
        }
        
        else
        {
            $insertsql=$conectar->prepare("INSERT INTO productos(id_productos,nom_producto,precio,descripcion,cantidad_ini,id_estado, barcode) VALUES (?,?,?,?, ?,?, ?);");
            $insertsql->execute([$id,$nombre,$precio,$descripcion,$cantidad,$estado, $barcode]);
            echo '<script>alert ("Registro Exitoso, Gracias");</script>';
            echo '<script> window.location="productos.php"</script>';
        }

    }


?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>productos</title>
       <?php require_once "index.php"; ?>
       
       
</head>
<body>



		<div class="container">
			<h1>Productos</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmArticulos"  name="formu" method="post" >
                        <input type="hidden" name="estado" value="<?php echo $estado['id_estado'] ?>">
                        <label>Referencia</label>
						<input type="number" oninput="maxlengthNumber(this)" maxlength="3" min="0" class="form-control input-sm" id="id" name="id">
						<label>Nombre</label>
						<input type="text" oninput="multipletext(this)" maxlength="25" class="form-control input-sm" id="nombre" name="nombre">
						<label>Precio</label>
						<input type="number" oninput="maxlengthNumber(this)" maxlength="10" class="form-control input-sm" id="precio"  min="1" name="precio">
						<label>Descripcion</label>
						<input type="text" oninput="multipltext(this)" maxlength="32" class="form-control input-sm" id="descripcion" name="descripcion">
						<label>Cantidad</label>
						<input type="number" oninput="maxlengthNumber(this)" maxlength="4" min="0" class="form-control input-sm" id="cantidad" name="cantidad">
                        <label>Codigo</label>
                        <input type="TEXT" oninput="multipletext(this)" maxlength="6" min="0" class="form-control input-sm" id="barcode" name="barcode">
						<br>
						<button name="validar" type="submit" id="btnAgregaArticulo" class="btn btn-primary"  >Agregar</button>
                        <input type="hidden" name="agregar" value="formu">
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tablaArticulosLoad">
                    <?php require_once "tabla_produc.php";?>
                    </div>
				</div>
			</div>
		</div>
    <script>
        function maxlengthNumber(obj){
            if(obj.value.length > obj.maxLength){
                obj.value = obj.value.slice(0, obj.maxLength);
                alert("Debe ingresar solo el numero de digitos establecidos");

            }
        }
    </script>

    <script>
        function multipletext(e) {
            key=e.keyCode || e.which;

            teclado=String.fromCharCode(key).toLowerCase();

            letras="qwertyuiopasdfghjklñzxcvbnm";

            especiales="8-37-38-46-164-46";

            teclado_especial=false;

            for(var i in especiales){
                if(key==especiales[i]){
                    teclado_especial=true;
                    break;
                }
            }

            if(letras.indexOf(teclado)==-1 && !teclado_especial){
                return false;
                a
            }
        }
    </script>
<body>
    
<head>
</html>