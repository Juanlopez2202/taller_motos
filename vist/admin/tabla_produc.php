<?php 


    require_once("../../bd/conexion.php");
    $db = new Database();
    $conectar= $db->conectar();
     

    $consul=$conectar->prepare("SELECT * From productos INNER JOIN estado ON productos.id_estado=estado.id_estado ");
    $consul->execute();
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
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>productos</label></caption>
	<tr>
        <td>Referencia</td>
		<td>Nombre</td>
		<td>Precio</td>
		<td>Descripcion</td>
		<td>Cantidad actual</td>
        <td>Cantidad anterior</td>

		
		<td>Estado</td>
		<td>Editar</td>
		<td>Eliminar</td>
	</tr>

	<?php foreach($consul as $produ) {
        ?>

	<tr>
		<td><?php echo $produ['id_productos']; ?></td>
		<td><?php echo $produ['nom_producto']; ?></td>
		<td><?php echo $produ['precio']; ?></td>
		<td><?php echo $produ['descripcion']; ?></td>
        <td><?php echo $produ['cantidad_ini']; ?></td>
        <td><?php echo $produ['cantidad_ant']; ?></td>
        <td><?php echo $produ['estados']; ?></td>
        
		<td>
        <form method="get" action="actualizarp.php"> 
           
        <button type="submit" data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-success btn-s">
		<input type="hidden" name="actu" value="<?php echo $produ['id_productos']?>">
				<span class="glyphicon glyphicon-pencil"></span>
        </button>
        
        </form>
		</td>
    
        
		<td>
        <form method="post"  action="eliminarp.php" > 
			<button type="submit" class="btn btn-danger btn-s" onclick="return ConfirmDelete()" >
              <input type="hidden" name="elimi" value="<?=$produ["id_productos"]?>">
				<span class="glyphicon glyphicon-remove"></span>
            </button>
			</form>
		</td>
        
	</tr>
    
<?php } ?>
</table>
