<?php
    require_once("../../bd/conexion.php");
    $barcode = new database();
    $con = $barcode -> conectar();

    $consul = $con -> prepare("SELECT * FROM moto");
    $consul -> execute();

    $consu = $con -> prepare("SELECT * FROM marca");
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
        <h1>Codigo de barras motos</h1>
        <div class="row">
            <div class="col-sm-4">
                <form action="codigo/insertarm.php" method="post">
                    <label for="">Nombre</label>
                    <select class="form-control input-sm" name="nombre">
							<option disabled selected value="">Selecciona la marca de la moto</option>
							<?php foreach($consu as $resulm){
                            ?>
							<option value="<?php echo($resulm['marca'])?>"><?php echo($resulm['marca'])?> </option>
							<?php  
                                };

                            ?>
					</select>
                    <br>
                    <label for="">Codigo</label>
                    <select class="form-control input-sm" name="codigo">
							<option disabled selected value="">Selecciona el codigo</option>
							<?php foreach($consul as $resul){
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
                    require_once("tabla_barcodem.php");
                ?>
            </div>
        </div>
    </div>
</body>
</html>