<?php
    require_once("../../bd/conexion.php");
    $conectar = new database;
    $db = $conectar -> conectar();

    $mostrar = $db -> prepare("SELECT * FROM barcode");
    $mostrar -> execute();
    $print = $mostrar -> fetch();
?>

<table class="table">
    <tr>
        <td>Nombre</td>
        <td>Codigo de barra</td>
    </tr>
    <?php 
        while($print = $mostrar -> fetch()): 
    ?>

    <tr>
        <td><?php echo $print['nombre'];?></td>
        <td>
            <img src="codigo/barcode.php?text=<?php echo $print['barcode']?>&size=40&codetype=Code128&print=true" />
        </td>
    <?php
        endwhile; 
    ?>
</table>

