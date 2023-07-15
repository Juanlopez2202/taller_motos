<?php 


    require_once("../../bd/conexion.php");
    $db = new Database();
    $conectar= $db->conectar();
     

    $consul=$conectar->prepare("SELECT * From moto INNER JOIN usuarios ON moto.documento=usuarios.documento INNER JOIN marca on moto.id_marca=marca.id_marca");
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
	<caption><label>Motos</label></caption>
	<tr>
        <td>Placa</td>
		<td>Propietario</td>
		<td>km</td>
		<td>marca</td>
		<td>Descripcion</td>

		
		
		<td>Editar</td>
		<td>Eliminar</td>
	</tr>

	<?php foreach($consul as $produ) {
        ?>

	<tr>
		<td><?php echo $produ['placa']; ?></td>
		<td><?php echo $produ['nombre_completo']; ?></td>
		<td><?php echo $produ['km']; ?></td>
		<td><?php echo $produ['marca']; ?></td>
        <td><?php echo $produ['descripcion']; ?></td>
        
        
		<td>
        <form method="get" action="actualizarmotos.php"> 
           
        <button type="submit" data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-success btn-s">
		<input type="hidden" name="actu" value="<?php echo $produ['placa']?>">
				<span class="glyphicon glyphicon-pencil"></span>
        </button>
        
        </form>
		</td>
    
        
		<td>
        <form method="post"  action="eliminarmotos.php" > 
			<button type="submit" class="btn btn-danger btn-s" onclick="return ConfirmDelete()" >
              <input type="hidden" name="elimi" value="<?=$produ["placa"]?>">
				<span class="glyphicon glyphicon-remove"></span>
            </button>
			</form>
		</td>
        
	</tr>
    
<?php } ?>
</table>
