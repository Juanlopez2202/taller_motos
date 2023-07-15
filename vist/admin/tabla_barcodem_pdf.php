<?php
    require_once("../../bd/conexion.php");
    $conectar = new database;
    $db = $conectar -> conectar();

    $mostrar = $db -> prepare("SELECT * FROM barcodem WHERE id_barcode ='".$_POST['pdf']."' ");
    $mostrar -> execute();


?>

<script type="text/javascript">
    function ConfirmDelete()
    {
        var respuesta = confirm("Estas seguro de eliminar el registro");

        if (respuesta == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/styles/barcode.css">
    <title>PDF</title>
</head>
<body>
    <table class="tabla">
        <tr>
            <td>Nombre</td>
            <td>Codigo de barra</td>
        </tr>
        <?php 
            foreach($mostrar as $code){ 
        ?>
        <tr>
            <td><?php echo $code['nombre'];?></td>
            <td>
                <img src="codigo/barcode.php?text=<?php echo $code['barcode']?>&size=40&codetype=Code128&print=true" />
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
</body>
</html>