<?php



require_once("../../bd/conexion.php");
include "../../controller/styles/dependencias.php";
$db = new database();

$conectar= $db->conectar();

$marca=$conectar->prepare("SELECT * from marca");
$marca->execute();

$usuario=$conectar->prepare("SELECT * from usuarios");
$usuario->execute();

$linea=$conectar->prepare("SELECT * from linea");
$linea->execute();

$modelo=$conectar->prepare("SELECT * from modelo");
$modelo->execute();

$cilindraje=$conectar->prepare("SELECT * FROM cilindraje");
$cilindraje->execute();

$color=$conectar->prepare("SELECT * FROM color");
$color->execute();

$tip_ser=$conectar->prepare("SELECT * FROM tipo_servicio");
$tip_ser->execute();

$tip_veh=$conectar->prepare("SELECT * FROM tipo_vehiculo");
$tip_veh->execute();

$carroceria=$conectar->prepare("SELECT * FROM tipo_carroceria");
$carroceria->execute();

$combustible=$conectar->prepare("SELECT * FROM combustible");
$combustible->execute();



 if ((isset($_POST["agregar"]))&&($_POST["agregar"]=="formu"))
    {
        $id=$_POST['id'];
        $descripcion = $_POST['descripcion'];
        $cantidad= $_POST['cantidad'];
        $marca=$_POST['marca'];
        $propietario=$_POST['propietario'];
        $id_linea=$_POST['linea'];
        $id_modelo=$_POST['modelo'];
        $id_cilindraje=$_POST['cilindraje'];
        $id_color=$_POST['color'];
        $id_tip_servicio=$_POST['tipser'];
        $id_clase=$_POST['tipveh'];
        $id_carroceria=$_POST['carroceria'];
        $capacidad=$_POST['capacidad'];
        $id_combustible=$_POST['combustible'];
        $numero_motor=$_POST['num_motor'];
        $vin=$_POST['vin'];
        $numero_chasis=$_POST['num_chasis'];

        $barcode = $_POST['id'];
        

        $validar="SELECT * FROM moto WHERE placa='$id'";
        $queryi=$conectar->prepare($validar);
        $queryi->execute();
        $fila1=$queryi->fetchAll(PDO::FETCH_ASSOC);

        if ($fila1){
            echo '<script> alert ("EL PRODUCTO YA EXISTE");</script>';
            echo '<script> windows.location= "index.php"</script>';

        }

        else if ($id==""  || $descripcion=="" || $cantidad=="" ||$marca==""||$propietario==""||$id_linea==""||$id_modelo==""||$id_cilindraje==""||$id_color==""||$id_tip_servicio==""||$id_clase==""||$id_carroceria==""||$capacidad==""||$id_combustible==""||$numero_motor==""||$vin==""||$numero_chasis=="")
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location="index.php"</script>';
        }
        
        else
        {
            $insertsql=$conectar->prepare("INSERT INTO moto(placa,id_marca,descripcion,documento,km,id_linea,id_modelo,id_cilindraje,id_color,id_tip_servicio,id_clase,id_carroceria,capacidad,id_combustible,numero_motor,vin,numero_chasis, barcode) VALUES (?,?,?, ?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?);");
            $insertsql->execute([$id,$marca,$descripcion,$propietario,$cantidad,$id_linea,$id_modelo,$id_cilindraje,$id_color,$id_tip_servicio,$id_clase,$id_carroceria,$capacidad,$id_combustible,$numero_motor,$vin,$numero_chasis, $barcode]);
            echo '<script>alert ("Registro Exitoso, Gracias");</script>';
            echo '<script> window.location="motos.php"</script>';
        }

    }


?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motos</title>
       <?php require_once "index.php"; ?>
       
       
</head>
<body>



		<div class="container">
			<h1>Motos</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmArticulos"  name="formu" method="post" >
						<label>Marca</label>
						<select class="form-control input-sm" name="marca">
							<option disabled selected value="">Selecciona marca</option>
							<?php foreach($marca as $resulm){
                             ?>
								<option value="<?php echo($resulm['id_marca'])?>"><?php echo($resulm['marca'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label >Propietario</label>
                        <select class="form-control input-sm" name="propietario">
							<option disabled selected value="">Selecione propietario</option>
							<?php foreach($usuario as $resulu){
                             ?>
								<option value="<?php echo($resulu['documento'])?>"><?php echo($resulu['nombre_completo'])?> </option>
							<?php  
                             };

                             ?>
						</select>    
                        <label>Placa</label>
						<input type="text" oninput="multipletext(this)" maxlength="6" class="form-control input-sm" id="id" name="id">
						<label>Descripcion</label>
						<input type="text" oninput="multipletext(this)" maxlength="25" class="form-control input-sm" id="descripcion" name="descripcion">
						<label>kilometraje</label>
						<input type="number" oninput="maxlengthNumber(this)" maxlength="3" min="0" class="form-control input-sm" id="cantidad" name="cantidad">
                        <label>Linea</label>
						<select class="form-control input-sm" name="linea">
							<option disabled selected value="">Selecciona linea</option>
							<?php foreach($linea as $resull){
                             ?>
								<option value="<?php echo($resull['id_linea'])?>"><?php echo($resull['linea'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Modelo</label>
						<select class="form-control input-sm" name="modelo">
							<option disabled selected value="">Selecciona modelo</option>
							<?php foreach($modelo as $resulmo){
                             ?>
								<option value="<?php echo($resulmo['id_modelo'])?>"><?php echo($resulmo['modelo'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Cilindraje</label>
						<select class="form-control input-sm" name="cilindraje">
							<option disabled selected value="">Selecciona cilindraje</option>
							<?php foreach($cilindraje as $resulci){
                             ?>
								<option value="<?php echo($resulci['id_cilindraje'])?>"><?php echo($resulci['cilindraje'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Color</label>
						<select class="form-control input-sm" name="color">
							<option disabled selected value="">Selecciona color</option>
							<?php foreach($color as $resulcol){
                             ?>
								<option value="<?php echo($resulcol['id_color'])?>"><?php echo($resulcol['color'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Tipo de servcio</label>
						<select class="form-control input-sm" name="tipser">
							<option disabled selected value="">Selecciona servicio</option>
							<?php foreach($tip_ser as $resulser){
                             ?>
								<option value="<?php echo($resulser['id_tip_servicio'])?>"><?php echo($resulser['tip_servicio'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Tipo de vehiculo</label>
						<select class="form-control input-sm" name="tipveh">
							<option disabled selected value="">Selecciona tipo de vehiculo</option>
							<?php foreach($tip_veh as $resulveh){
                             ?>
								<option value="<?php echo($resulveh['id_clase'])?>"><?php echo($resulveh['tip_vehiculo'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Carroceria</label>
						<select class="form-control input-sm" name="carroceria">
							<option disabled selected value="">Selecciona carroceria</option>
							<?php foreach($carroceria as $resulcar){
                             ?>
								<option value="<?php echo($resulcar['id_carroceria'])?>"><?php echo($resulcar['carroceria'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Capacidad</label>
                        <input type="number" oninput="maxlengthNumber(this)" maxlength="2" class="form-control input-sm" id="capacidad" name="capacidad">
                        <label>Combustible</label>
						<select class="form-control input-sm" name="combustible">
							<option disabled selected value="">Selecciona combustible</option>
							<?php foreach($combustible as $resulcom){
                             ?>
								<option value="<?php echo($resulcom['id_combustible'])?>"><?php echo($resulcom['combustible'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Numero de motor</label>
                        <input type="number" oninput="maxlengthNumber(this)" maxlength="10" class="form-control input-sm" id="num_motor" name="num_motor">
                        <label>VIN</label>
                        <input type="number" oninput="maxlengthNumber(this)" maxlength="10" class="form-control input-sm" id="vin" name="vin">
                        <label>Numero de chasis</label>
                        <input type="number" oninput="maxlengthNumber(this)" maxlength="10" class="form-control input-sm" id="num_chasis" name="num_chasis">
                        <br>
						<button name="validar" type="submit" id="btnAgregaArticulo" class="btn btn-primary"  >Agregar</button>
                        <input type="hidden" name="agregar" value="formu">
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tablaArticulosLoad">
                    <?php require_once "tabla_motos.php";
                           ?>
                    </div>
				</div>
			</div>
		</div>
<body>
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
<head>
</html>