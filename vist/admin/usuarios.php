<?php



require_once("../../bd/conexion.php");
include "../../controller/styles/dependencias.php";
$db = new database();

$conectar= $db->conectar();

$sql=$conectar->prepare("SELECT * from estado WHERE id_estado <3");
$sql->execute();

$sqlt=$conectar->prepare("SELECT * from tipo_usuarios");
$sqlt->execute();





 if ((isset($_POST["agregar"]))&&($_POST["agregar"]=="formu"))
    {
        $id=$_POST['id'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $fecha = $_POST['fecha'];
        $usuario= $_POST['usuario'];
        $estado=$_POST['estado'];
        $tipo=$_POST['tipo'];
        $pass=$_POST['password'];

        $clave_procesada=password_hash($pass,PASSWORD_BCRYPT,["cost"=>15]);

        $validar="SELECT * FROM usuarios WHERE documento='$id'or usuario='$usuario' ";
        $queryi=$conectar->prepare($validar);
        $queryi->execute();
        $fila1=$queryi->fetchAll(PDO::FETCH_ASSOC);
        
        if ($id=="" || $nombre=="" || $telefono=="" || $email=="" || $usuario=="" ||$estado==""||$tipo==""||$pass="")
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location="index.php"</script>';
        }
        
        else if ($fila1){
            echo '<script> alert ("EL USUARIO YA EXISTE");</script>';
            echo '<script> windows.location= "index.php"</script>';

        }

        
        
        else
        {
            $insertsql=$conectar->prepare("INSERT INTO usuarios(documento,nombre_completo,telefono,email,fecha_usu,usuario,password,id_tip_usu,id_estado) VALUES (?,?,?,?,?, ?,?,?,?);");
            $insertsql->execute([$id,$nombre,$telefono,$email,$fecha,$usuario,$clave_procesada,$tipo,$estado]);
            echo '<script>alert ("Registro Exitoso, Gracias");</script>';
            echo '<script> window.location="usuarios.php"</script>';
        }

    }


?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>usuarios</title>
       <?php require_once "index.php"; ?>
       
       
</head>
<body>



		<div class="container">
			<h1>Usuarios</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmArticulos"  name="formu" method="post" >
						<label>Estado</label>
						<select class="form-control input-sm" name="estado">
							<option disabled selected value="">Selecciona Estado</option>
							<?php foreach($sql as $resul){
                             ?>
								<option value="<?php echo($resul['id_estado'])?>"><?php echo($resul['estados'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Tipo de usuario</label>
                        <select class="form-control input-sm" name="tipo">
							<option disabled selected value="">Selecciona Tipo de usuario</option>
							<?php foreach($sqlt as $result){
                             ?>
								<option value="<?php echo($result['id_tip_usu'])?>"><?php echo($result['tip_usu'])?> </option>
							<?php  
                             };

                             ?>
						</select>
                        <label>Documento</label>
						<input type="number" oninput="maxlengthNumber(this)" maxlength="10" min="0" class="form-control input-sm" id="id" name="id">
						<label>Nombre Completo</label>
						<input type="text" oninput="multipletext(this)" maxlength="32" class="form-control input-sm" id="nombre" name="nombre">
						<label>Telefono</label>
						<input type="number" oninput="maxlengthNumber(this)" maxlength="10" class="form-control input-sm" id="telefono"  min="1" name="telefono">
						<label>Email</label>
						<input type="email" oninput="multipletext(this)" maxlength="32" class="form-control input-sm" id="email" name="email">
                        <label>Fecha de nacimiento</label>
						<input type="date" class="form-control input-sm" id="fecha" name="fecha">
						<label>usuario</label>
						<input type="text" oninput="multipletext(this)" maxlength="16" class="form-control input-sm" id="usuario" name="usuario">
						<label>Password</label>
						<input type="password" oninput="multipletext(this)" maxlength="12" class="form-control input-sm" id="password" name="password">
						<br>
						<button name="validar" type="submit" id="btnAgregaArticulo" class="btn btn-primary"  >Agregar</button>
                        <input type="hidden" name="agregar" value="formu">
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tablaArticulosLoad">
                    <?php require_once "tabla_usuarios.php"?>
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