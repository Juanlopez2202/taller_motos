<?php 


    require_once("../../bd/conexion.php");
    $db = new Database();
    $conectar= $db->conectar();
     

    $consul=$conectar->prepare("SELECT * From usuarios INNER JOIN estado ON usuarios.id_estado=estado.id_estado INNER join tipo_usuarios on usuarios.id_tip_usu=tipo_usuarios.id_tip_usu");
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
	<caption><label>Usuarios</label></caption>
	<tr>
        <td>Documento</td>
		<td>Nombre Completo</td>
		<td>Telefono</td>
		<td>Email</td>
        <td>Tipo de Usuarios</td>
		<td>Estado</td>
		<td>Editar</td>
		<td>Eliminar</td>
		<td>Activar</td>
		<td>Desactivar</td>
	</tr>

	<?php foreach($consul as $produ) {
        ?>

	<tr>
		<td><?php echo $produ['documento']; ?></td>
		<td><?php echo $produ['nombre_completo']; ?></td>
		<td><?php echo $produ['telefono']; ?></td>
		<td><?php echo $produ['email']; ?></td>
        <td><?php echo $produ['tip_usu']; ?></td>
        <td><?php echo $produ['estados']; ?></td>
        
		<td>
        <form method="get" action="actualizarusu.php"> 
           
        <button type="submit" data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-success btn-s">
		<input type="hidden" name="actu" value="<?php echo $produ['documento']?>">
				<span class="glyphicon glyphicon-pencil"></span>
        </button>
        
        </form>
		</td>
    
        
		<td>
        <form method="post"  action="eliminarusu.php" > 
			<button type="submit" class="btn btn-danger btn-s" onclick="return ConfirmDelete()" >
              <input type="hidden" name="elimi" value="<?=$produ["documento"]?>">
				<span class="glyphicon glyphicon-remove"></span>
            </button>
			</form>
		</td>
		<td>
        <form method="post"  action="activacion/activacion.php" > 
			<button type="submit" class="btn btn-info btn-s">
              <input type="hidden" name="activo" value="<?=$produ["documento"]?>">
				<span class="glyphicon glyphicon-thumbs-up"></span>
            </button>
			</form>
		</td>
		<td>
        <form method="post"  action="activacion/inactivacion.php" > 
			<button type="submit" class="btn btn-warning btn-s">
              <input type="hidden" name="inactivo" value="<?=$produ["documento"]?>">
				<span class="glyphicon glyphicon-thumbs-down"></span>
            </button>
			</form>
		</td>
        
	</tr>
    
<?php } ?>
</table>
