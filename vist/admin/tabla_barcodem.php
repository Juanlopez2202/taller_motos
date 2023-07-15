<?php
    require_once("../../bd/conexion.php");
    $conectar = new database;
    $db = $conectar -> conectar();

    $mostrar = $db -> prepare("SELECT * FROM barcodem");
    $mostrar -> execute();
    $print = $mostrar -> fetch();
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
<table class="table">
    <tr>
        <td>Nombre</td>
        <td>Codigo de barra</td>
		<td>Eliminar</td>
        <td>PDF</td>
    </tr>
    <?php 
        while($print = $mostrar -> fetch()): 
    ?>

    <tr>
        <td><?php echo $print['nombre'];?></td>
        <td>
            <img src="codigo/barcode.php?text=<?php echo $print['barcode']?>&size=40&codetype=Code128&print=true" />
        </td>
        <td>
            <form method="post" action="eliminarbarcode.php" > 
                <button type="submit" class="btn btn-danger btn-s" onclick="return ConfirmDelete()" >
                    <input type="hidden" name="elimi" value="<?=$print["id_barcode"]?>">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </form>
        </td>
        <td>
            <form method="post" action="tabla_barcodem_pdf.php" > 
                <button type="submit" class="btn btn-info btn-s" >
                    <input type="hidden" name="pdf" value="<?=$print["id_barcode"]?>">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </button>
            </form>
        </td>
    </tr>
    <?php
        endwhile; 
    ?>
</table>