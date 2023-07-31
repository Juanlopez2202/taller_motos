<?php

    require_once("../../bd/conexion.php");
    $db = new Database();
    $conectar= $db->conectar();
    require_once "../../controller/styles/dependencias.php";

?>
   <?php
    
        $consulta=$conectar->prepare("SELECT * from combustible where id_combustible ='".$_GET['actu']."' ");
             $consulta->execute();
             $query=$consulta->fetch(PDO::FETCH_ASSOC);
           
       

       if ((isset($_POST["actualizar"]))&&($_POST["actualizar"]=="form"))
       {
        $nombre = $_POST['nombreu'];
        
        
   
   
    

         if ($nombre=="")
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location="index.php"</script>';
        }
       
        else
        {
          $actusql=$conectar->prepare("UPDATE combustible SET combustible ='$nombre' WHERE id_combustible ='".$_GET['actu']."'");
          $actusql->execute();
          echo '<script>alert ("Actualizacion exitosa");</script>';
        echo '<script> window.location="combustible.php"</script>';
            
    
        }
   
       }
  
   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once "navbar.php"  ?>
</head>
<body>
     
		<div class="container">
			<h1>combustible</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmArticulos"  name="formu" method="post" >
						
                        <label>Referencia</label>
						<input type="number" disabled class="form-control input-sm" id="id" name="idu"   value="<?php echo $query['id_combustible'] ?>">

						<label>combustible</label>
						<input type="text" class="form-control input-sm" id="nombre" name="nombreu"  value="<?php echo $query['combustible'] ?>">
			
						<br>
						<button name="validar" type="submit" id="btnAgregaArticulo" class="btn btn-primary"  >Actualizar</button>
                        <input type="hidden" name="actualizar" value="form">
					</form>
				</div>
				
			</div>
		</div>
        
</body>
</html>