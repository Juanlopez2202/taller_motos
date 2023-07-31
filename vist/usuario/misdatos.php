<?php 
   
    include("../../controller/validar.php");
    require_once("../../bd/conexion.php");
    require_once ("../../controller/styles/dependencias.php");

    $db = new Database();
    $conectar = $db->conectar();

    $consul = $conectar -> prepare("SELECT * FROM usuarios WHERE documento = '".$_SESSION["documento"]."' ");
    $consul -> execute();
    $cons = $consul -> fetch(PDO::FETCH_ASSOC);

?>
<?php
    if ((isset($_POST["actu"]))&&($_POST["actu"]=="form"))
    {
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];

        if ($telefono == "" || $email == "" || $usuario == ""){  
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location="misdatos.php"</script>';
        }
    else{

        $actusql=$conectar->prepare("UPDATE usuarios SET telefono = '$telefono', email = '$email', usuario = '$usuario'  WHERE documento ='".$_SESSION["documento"]."'");
        $actusql->execute();
        echo '<script>alert ("Actualizacion exitosa");</script>';
        echo '<script> window.location="misdatos.php"</script>';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="../../controller/img/icono.png" type="image/x-icon">
    <title>Mis datos</title>
    <?php include_once("navar.php");?>
</head>
<body>
<div class="container">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
        <h2>Mis datos</h2>
        <br>
        <tr>
            <td>Documento</td>
            <td>Nombre Completo</td>
            <td>Telefono</td>
            <td>Email</td>
            <td>F. Nacimiento</td>
            <td>Usuario</td>
        </tr>
        <tr>
            <td><?php echo $cons['documento']; ?></td>
            <td><?php echo $cons['nombre_completo']; ?></td>
            <td><?php echo $cons['telefono']; ?></td>
            <td><?php echo $cons['email']; ?></td>
            <td><?php echo $cons['fecha_usu']; ?></td>
            <td><?php echo $cons['usuario']; ?></td>
        </tr>
    </table>
    <br>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <form method="POST" class="row justify-content-center" name="formactu">
                <caption><h2>Actualizar mis datos</h2></caption>
                <br>
                <div class="col-5">
                    <label for="formGroupExampleInput" class="form-label">Telefono</label>
                    <input type="number" oninput="maxlengthNumber(this)" minLength="6" maxLength="10" name="telefono" class="form-control" value="<?php echo $cons["telefono"];?>">
                </div>
                <br>
                <div class="col-5">
                    <label for="formGroupExampleInput" class="form-label">E-mail</label>
                    <input type="e-mail" oninput="multipletext(this)" maxlength="32" name="email" class="form-control" value="<?php echo $cons["email"];?>">
                </div>
                <br>
                <div class="col-5">
                    <label for="formGroupExampleInput" class="form-label">Usuario</label>
                    <input type="text" oninput="multipletext(this)" maxlength="16" name="usuario" class="form-control" value="<?php echo $cons["usuario"];?>">
                </div>
                <br>
                <button type="submit" class="btn btn-success">Actualizar</button>
                <input type="hidden" name="actu" value="form">
            </form>
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
</body>