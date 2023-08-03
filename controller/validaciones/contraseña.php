<?php
require_once("../../bd/conexion.php");
$db = new Database();
$conexion = $db->conectar();
session_start();

?>
<?php
if((isset($_POST['actualizar'])))
   {
     $contra=$_POST['contra'];
     $documento =$_POST['docu'];
     $sqli = $conexion->prepare("SELECT password FROM usuarios WHERE documento = :documento");
     $sqli->bindParam(':documento', $documento);
     $sqli->execute();
     $fila1 = $sqli->fetch();
    
     if(!$fila1){
        echo '<script>alert("El usuario no existe ");</script>';
        echo '<script>window.location="contraseña.php"</script>';
        exit();
     }
    $clave_procesada=password_hash($contra,PASSWORD_BCRYPT,["cost"=>15]);
    

    if($_POST["contra"]=="" || $_POST["contraseña"]=="")
    {
        echo '<script>alert("datos vacios no ingreso la contraseña");</script>';
        echo '<script>window.location="../../contraseña.html"</script>';
    }

    if($_POST["contra"] !==  $_POST ["contraseña"] ){  
        echo '<script>alert("las contraseñas no coinciden");</script>';
        echo '<script>window.location="../../contraseña.html"</script>';

    } 
    
    else
    {
        
        $insertsql=$conexion->prepare("UPDATE usuarios SET password ='$clave_procesada' where documento='$documento'");
        $insertsql->execute();
        
          echo '<script>alert ("cambio de contraseña exitoso");</script>';
          echo '<script>window.location="../../index.html"</script>';
    }
    
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="shortcut icon" href="../img/icono.png" type="image/x-icon">
    <title>Cambio de contraseña</title>
</head>
<body>
 
 <div class=" contenido-centrado">
   
    <div class=" degradado sombra ">


    <div class="contenedor-img registo-img">
         <img class="imagen-registro" src="../img/27520215_7323981.jpg" alt="imagen logo">
    </div>
        <form class="formulario" method="POST">
            <h1>recuperar contraseña</h1>
            <p>completa la informacion</p>
            <div class="campo">
                <label for="documento">Documento</label>
                <input type="number" oninput="multipletext(this);" minlength="6" maxlength="11" placeholder="Documento" id="contra" name="docu" >
            </div>
            <div class="campo">
                <label for="contraseña">contraseña</label>
                <input type="password" oninput="multipletext(this);" minlength="6" maxlength="12" placeholder="nueva contraseña" id="contra" name="contra" >
            </div>
            <div class="campo">
                <label for="confirme contraseña">confirme contraseña</label>
                <input type="password" oninput="multipletext(this);" minlength="6" maxlength="12" placeholder="confirme contraseña" id="contraseña" name="contraseña" >
            </div>
            

            <input class="boton azul registro-btn" type="submit" value="inicio" name="actualizar" >
            <div class="enlaces">
                <a href="../../index.html"> volver</a>
                
            </div>
            

        </form>

        
    </div>
    </div>
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
</body>
</html>



