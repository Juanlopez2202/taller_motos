<?php 


    require_once("../../bd/conexion.php");
    $db = new Database();
    $conectar= $db->conectar();
     

    $consul=$conectar->prepare("SELECT * From servicio");
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
	<caption><label>Servicios</label></caption>
	<tr>
        <td>Referencia</td>
		<td>Servicio</td>
        <td>Precio</td>
        <td>Descripcion</td>

	
		<td>Editar</td>
		<td>Eliminar</td>
	</tr>

	<?php foreach($consul as $produ) {
        ?>

	<tr>
		<td><?php echo $produ['id_servicios']; ?></td>
		<td><?php echo $produ['servicio']; ?></td>
        <td><?php echo $produ['precio']; ?></td>
        <td><?php echo $produ['descripcion']; ?></td>
		
		<td>
        <form method="get" action="actuservicio.php"> 
           
            <button  data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-success btn-s">
            <input type="hidden" name="actu" value="<?php echo $produ['id_servicios']?>">
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
            
            </form>
		</td>
    
        
		<td>
        <form method="post" action="eliminarservicio.php" > 
			<button type="submit" class="btn btn-danger btn-s" onclick="return ConfirmDelete()" >
              <input type="hidden" name="elimi" value="<?=$produ["id_servicios"]?>">
				<span class="glyphicon glyphicon-remove"></span>
            </button>
			</form>
		</td>
        
	</tr>
    
<?php } ?>
</table>