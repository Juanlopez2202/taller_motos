<?php
    require_once("../../bd/conexion.php");
    $barcode = new database();
    $con = $barcode -> conectar();

    $consul = $con -> prepare("SELECT nom_producto FROM productos");
    $consul -> execute();

    $consu = $con -> prepare("SELECT barcode FROM productos");
    $consu -> execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="codigo/JsBarcode.all.min.js"></script>
    <title>Codigo de barras</title>
    <?php require_once "navbar.php"; ?>
</head>
<body>
    <div class="container">
        <h1>Codigo de barras productos</h1>
        <div class="row">
            <div class="col-sm-4">
                <form action="codigo/insertar.php" method="post">
                    <label for="">Nombre</label>
                    <select class="form-control input-sm" name="nombre">
							<option disabled selected value="">Selecciona el nombre del producto</option>
							<?php foreach($consul as $result){
                            ?>
							<option value="<?php echo($result['nom_producto'])?>"><?php echo($result['nom_producto'])?> </option>
							<?php  
                                };

                            ?>
					</select>
                    <br>
                    <label for="">Codigo</label>
                    <select class="form-control input-sm" name="codigo">
							<option disabled selected value="">Selecciona el codigo</option>
							<?php foreach($consu as $resul){
                            ?>
							<option value="<?php echo($resul['barcode'])?>"><?php echo($resul['barcode'])?> </option>
							<?php  
                                };

                            ?>
					</select>
                    <br>
                    <button type="submit" class="btn btn-primary">Generar codigo</button>
                    <br>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <?php
                    require_once("tabla_barcode.php");
                ?>
            </div>
        </div>
    </div>
</body>
</html>