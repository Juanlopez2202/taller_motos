<?php 


    require_once("../../bd/conexion.php");
    $db = new Database();
    $conectar= $db->conectar();
     

    $consul=$conectar->prepare("SELECT * From estado");
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
	<caption><label>Estados</label></caption>
	<tr>
        <td>Referencia</td>
		<td>Nombre</td>

	
		<td>Editar</td>
		<td>Eliminar</td>
	</tr>

	<?php foreach($consul as $produ) {
        ?>

	<tr>
		<td><?php echo $produ['id_estado']; ?></td>
		<td><?php echo $produ['estados']; ?></td>
		
		<td>
        <form method="get" action="actuaestado.php"> 
           
        <button type="submit" data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-success btn-s">
		<input type="hidden" name="actu" value="<?php echo $produ['id_estado']?>">
				<span class="glyphicon glyphicon-pencil"></span>
        </button>
        
        </form>
		</td>
    
        
		<td>
        <form method="post" action="eliminare.php" > 
			<button type="submit" class="btn btn-danger btn-s" onclick="return ConfirmDelete()" >
              <input type="hidden" name="elimi" value="<?=$produ["id_estado"]?>">
				<span class="glyphicon glyphicon-remove"></span>
            </button>
			</form>
		</td>
        
	</tr>
    
<?php } ?>
</table>