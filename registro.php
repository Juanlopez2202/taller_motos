<?php  
require_once("bd/conexion.php");
$db = new database();
$conectar= $db->conectar();
?>



<?php






$sql=$conectar->prepare("SELECT * from estado where id_estado=2");
$sql->execute();
$esta=$sql->fetch();

$sqlt=$conectar->prepare("SELECT * from tipo_usuarios where id_tip_usu=2");
$sqlt->execute();
$tipo=$sqlt->fetch();






if ((isset($_POST["agregar"]))&&($_POST["agregar"]=="formu"))
    {
        $id = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $email = $_POST['correo'];
        $fecha = $_POST['fecha'];
        $usuario = $_POST['usuario'];
        $estado = $_POST['estado'];
        $tipo1 = $_POST['tip'];
        $pass = $_POST['password'];

        $clave_procesada=password_hash($pass,PASSWORD_BCRYPT,["cost"=>15]);

		$campos = array();

        $validar="SELECT * FROM usuarios WHERE documento='$id' AND usuario='$usuario' ";
        $queryi=$conectar->prepare($validar);
        $queryi->execute();
        $fila1=$queryi->fetchAll(PDO::FETCH_ASSOC);
        
        if ($id=="" || $nombre=="" || $telefono=="" || $email=="" || $usuario=="" || $estado==""||$tipo1==""||$pass="" )
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location="index.html"</script>';
        }
        
        else if ($fila1){
            echo '<script> alert ("EL USUARIO YA EXISTE");</script>';
            echo '<script> windows.location= "index.htmñ"</script>';

        }

        
        
        else
        {
            $insertsql=$conectar->prepare("INSERT INTO usuarios(documento,nombre_completo,telefono,email,fecha_usu,usuario,password,id_tip_usu,id_estado) VALUES (?,?,?, ?,?, ?,?,?,?);");
            $insertsql->execute([$id,$nombre,$telefono,$email,$fecha,$usuario,$clave_procesada,$tipo1,$estado]);
            echo '<script>alert ("Registro Exitoso, Gracias");</script>';
            echo '<script> window.location="index.html"</script>';
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="controller/styles/estilo.css">
    <link rel="shortcut icon" href="controller/img/icono.png" type="image/x-icon">
	<title>Registro</title>
</head>
<body>
	<main>
        
		<form method="POST" autocomplete="off" class="formulario" id="formulario">
        <h1>Registro de usuario</h1>
			<!-- Grupo: Documento -->
			<div class="formulario__grupo" id="grupo__documento">
				<label for="documento" class="formulario__label">Documento</label>
				<div class="formulario__grupo-input">
					<input type="number" oninput="(maxlengthNumber(this));" maxlength="10" class="formulario__input" name="documento" id="usuario">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">El documento tiene que ser de 6 a 10 dígitos.</p>
			</div>

			<!-- Grupo: Nombre -->
			<div class="formulario__grupo" id="grupo__nombre">
				<label for="nombre" class="formulario__label">Nombre</label>
				<div class="formulario__grupo-input">
					<input type="text" oninput="multipletext(this);" maxlength="32" class="formulario__input" name="nombre" id="nombre">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">El nombre tiene que ser de 4 a 32 caracteres y solo puede contener letras.</p>
			</div>

			<!-- Grupo: Teléfono -->
			<div class="formulario__grupo" id="grupo__telefono">
				<label for="telefono" class="formulario__label">Teléfono</label>
				<div class="formulario__grupo-input">
					<input type="number" oninput="maxlengthNumber(this);" maxlength="10" class="formulario__input" name="telefono" id="telefono">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">El telefono solo puede contener numeros y el maximo son 10 dígitos.</p>
			</div>

			<!-- Grupo: Correo Electronico -->
			<div class="formulario__grupo" id="grupo__correo">
				<label for="correo" class="formulario__label">Correo Electrónico</label>
				<div class="formulario__grupo-input">
					<input type="email" oninput="multipletext(this);" maxlength="32"  class="formulario__input" name="correo" id="correo">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">El correo solo puede contener letras, numeros, puntos, guiones y guion bajo.</p>
			</div>

            <!-- Grupo: Fecha nacimiento -->
            <div class="formulario__grupo" id="grupo__fecha">
				<label for="fecha" class="formulario__label">Fecha de nacimiento</label>
				<div class="formulario__grupo-input">
					<input type="date"   class="formulario__input" name="fecha" id="correo">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
			</div>

			<!-- Grupo: Usuario -->
			<div class="formulario__grupo" id="grupo__usuario">
				<label for="usuario" class="formulario__label">Usuario</label>
				<div class="formulario__grupo-input">
					<input type="text" oninput="multipletext(this);" maxlength="16" class="formulario__input" name="usuario" id="usuario">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">El usuario tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
			</div>

			<!-- Grupo: Contraseña -->
			<div class="formulario__grupo" id="grupo__password">
				<label for="password" class="formulario__label">Contraseña</label>
				<div class="formulario__grupo-input">
					<input type="password" oninput="multipletext(this);" maxlength="12" class="formulario__input" name="password" id="password">
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				</div>
				<p class="formulario__input-error">La contraseña tiene que ser de 10 a 12 dígitos.</p>
			</div>

            <div class="formulario__grupo" id="grupo__tipusu">
                <input type="hidden" name="estado" value="<?php echo $esta['id_estado'] ?>" >
                <div class="formulario__grupo-input">
                
                    <label class="formulario__label" for="opciones"> Selecciona un tipo de usuarios:</label>
                    <select name="tip" class="formulario__input" >
                
                        <option class="formulario__input" value="" >--selecione--</option>

            
                        <?php
                            do{
                        ?>

                            <option value="<?php echo($tipo['id_tip_usu'])?>"><?php echo($tipo['tip_usu'])?></option>
                
                        <?php
                            }while ($tipo=$sqlt->fetch());
                        ?>
                
                    </select>
                </div>
            </div>

			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<button class="btn" type="submit">Registrate</button>
				<input type="hidden" name="agregar" value="formu">
			</div>

            
            <div class="enlaces">
                <a href="index.html">Volver</a>
            </div>
		</form>
	</main>
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
					alert("Debe ingresar solo el formato solicitado");
                    break;
                }
            }

            if(letras.indexOf(teclado)==-1 && !teclado_especial){
                return false;
                a
				alert("Debe ingresar solo el formato solicitado");
            }
        }
    </script>
	<script src="controller/validaciones/validacion.js"></script>
	<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>
