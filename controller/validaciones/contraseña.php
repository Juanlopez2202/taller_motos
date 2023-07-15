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
        $documento = $_SESSION['documento'];
        $insertsql=$conexion->prepare("UPDATE usuarios SET password ='$clave_procesada' where documento='$documento'");
        $insertsql->execute();
        
          echo '<script>alert ("cambio de contraseña exitoso");</script>';
          echo '<script>window.location="../../index.html"</script>';
    }
    
}
?>

<?php

 if($_POST['enviar']){
 
    $documento = $_POST["documento"];
    
    $sql=$conexion->prepare("SELECT * FROM usuarios WHERE documento= '$documento'");
    $sql->execute();
    $fila=$sql->fetch();
    
    if($fila){
        $_SESSION['documento']=$fila['documento'];
    



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
                <label for="contra">contraseña</label>
                <input type="password" oninput="multipletext(this);" minlength="6" maxlength="12" placeholder="nueva contraseña" id="contra" name="contra" >
            </div>
            <div class="campo">
                <label for="documento">confirme contraseña</label>
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
<?php
   }  

   else{
    echo '<script>alert ("El documento no existe en la base de  datos");</script>';
    echo '<script>window.location="../../contraseña.html"</script>';
   }

}
?>
