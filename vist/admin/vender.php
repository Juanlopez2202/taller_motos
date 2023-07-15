<?php

require_once "index.php";

$db = new database();
$conectar = $db->conectar();

$consul = $conectar->prepare("SELECT * FROM usuarios WHERE id_tip_usu = 1 ");
$consul->execute();

$consu = $conectar->prepare("SELECT * FROM moto ");
$consu->execute();


if (isset($_GET['status'])) {
    $status = $_GET['status'];

    // Mostrar mensaje de alerta según el valor de 'status'
    if ($status == 1) {
        echo '<script>alert("El producto ya no tiene existencias disponibles.");</script>';
    } elseif ($status == 2) {
        echo '<script>alert("Venta finalizada correctamente.");</script>';
    }
   elseif ($status == 3) {
	echo '<script>alert("El producto, el servicio o el documento no existe.");</script>';
   }
}


if (!isset($_SESSION["carrito_productos"])) {
    $_SESSION["carrito_productos"] = [];
}

if (!isset($_SESSION["carrito_servicios"])) {
    $_SESSION["carrito_servicios"] = [];
}

if (!isset($_SESSION["carrito_documentos"])) {
    $_SESSION["carrito_documentos"] = [];
}

$granTotal_productos = 0;
$granTotal_servicios = 0;
$granTotal_documentos = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/styles/menu.css">
    <title>Ventas</title>
    
</head>

<body>
    <h1>Ventas</h1>
    <br>
    <div class="col-xs-12">
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#productos">Productos</a></li>
            <li><a data-toggle="pill" href="#servicios">Servicios</a></li>
            <li><a data-toggle="pill" href="#documentos">Documentos</a></li>
        </ul>
        <div class="tab-content">
            <div id="productos" class="tab-pane fade in active">
                <br>
                <form method="post" action="agregarAlCarrito.php">
                    <label for="codigo">Referencia de producto</label>
                    <input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe la Referencia">
                    <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Valor unitario</th>
                            <th>Quitar</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION["carrito_productos"] as $indice => $producto) {
                            $granTotal_productos += $producto["subtotal"];
                        ?>
                            <tr>
                                <td><?php echo $producto["id_productos"]; ?></td>
                                <td><?php echo $producto["nom_producto"]; ?></td>
                                <td><?php echo $producto["descripcion"]; ?></td>
                                <td><?php echo $producto["precio"]; ?></td>
                                <td><a class="glyphicon glyphicon-remove" class="btn btn-danger" href="<?php echo "quitar_del_carrito_productos.php?indice=" . $indice; ?>"><i></i></a></td>
                                <td>
                                    <form action="cambiar_cantidad_productos.php" method="post">
                                        <input name="indice" type="hidden" value="<?php echo $indice; ?>">
                                        <input min="1" name="cantidad" class="form-control" required type="number" value="<?php echo $producto["cantidad"]; ?>">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h3 class="total">Total: <?php echo $granTotal_productos; ?></h3>
            </div>
            <div id="servicios" class="tab-pane fade">
                <br>
                <form method="post" action="agregarAlCarrito.php">
                    <label for="servicio">Servicio</label>
                    <select class="form-control" name="codigo" id="servicio" required>
                        <option value="">Seleccione un servicio</option>
                        <?php
                        $consultaServicios = $conectar->prepare("SELECT * FROM servicio");
                        $consultaServicios->execute();
                        while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $servicio["id_servicios"] . "'>" . $servicio["servicio"] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Valor unitario</th>
                            <th>Quitar</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION["carrito_servicios"] as $indice => $servicio) {
                            $granTotal_servicios += $servicio["subtotal"];
                        ?>
                            <tr>
                                <td><?php echo $servicio["id_servicio"]; ?></td>
                                <td><?php echo $servicio["servicio"]; ?></td>
                                <td><?php echo $servicio["descripcion"]; ?></td>
                                <td><?php echo $servicio["precio"]; ?></td>
                                <td><a class="glyphicon glyphicon-remove" class="btn btn-danger" href="<?php echo "quitar_del_carrito_servicios.php?indice=" . $indice; ?>"><i></i></a></td>
                                <td>
                                    <form action="cambiar_cantidad_servicios.php" method="post">
                                        <input name="indice" type="hidden" value="<?php echo $indice; ?>">
                                        <input min="1" name="cantidad" class="form-control" required type="number" value="<?php echo $servicio["cantidad"]; ?>">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h3 class="total">Total: <?php echo $granTotal_servicios; ?></h3>
            </div>
            <div id="documentos" class="tab-pane fade">
                <br>
                <form method="post" action="agregarAlCarrito.php">
                    <label for="documento">Documento</label>
                    <select class="form-control" name="documento" id="documento" required>
                        <option value="">Seleccione un documento</option>
                        <?php
                        $consultaDocumentos = $conectar->prepare("SELECT * FROM documentos");
                        $consultaDocumentos->execute();
                        while ($documento = $consultaDocumentos->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $documento["id_documento"] . "'>" . $documento["nombre_documento"] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Valor unitario</th>
                            <th>Quitar</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION["carrito_documentos"] as $indice => $documento) {
                            $granTotal_documentos += $documento["subtotal"];
                        ?>
                            <tr>
                                <td><?php echo $documento["id_documento"]; ?></td>
                                <td><?php echo $documento["nombre_documento"]; ?></td>
                                <td><?php echo $documento["descripcion"]; ?></td>
                                <td><?php echo $documento["precio"]; ?></td>
                                <td><a class="glyphicon glyphicon-remove" class="btn btn-danger" href="<?php echo "quitar_del_carrito_documentos.php?indice=" . $indice; ?>"><i></i></a></td>
                                <td>
                                    <form action="cambiar_cantidad_documentos.php" method="post">
                                        <input name="indice" type="hidden" value="<?php echo $indice; ?>">
                                        <input min="1" name="cantidad" class="form-control" required type="number" value="<?php echo $documento["cantidad"]; ?>">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h3 class="total">Total: <?php echo $granTotal_documentos; ?></h3>
            </div>
        </div>
    </div>

    <br>
    <br>
    <form action="terminar_venta.php" method="POST">
        <br>
        <br>
        <br>
        <label class="label1">Vehiculo</label>
        <select class="select-box selec" id="placa" name="placa">
            <option disabled selected value="">Elige vehiculo por placa</option>
            <?php foreach ($consu as $moto) { ?>
                <option value="<?php echo ($moto['placa']) ?>"><?php echo ($moto["placa"]) ?> </option>
            <?php } ?>
        </select>

		<label class="labe1" >vendedor</label>
            	<select class="select-box selec" id="vendedor" name="vendedor">
					<option disabled selected value="">Elige vehiculo por placa</option>
						<?php foreach($consul as $vendedor){
                             ?>
								<option value="<?php echo($vendedor['documento'])?>"><?php echo($vendedor['nombre_completo'])?> </option>
							<?php
					
};

                             ?>
						</select>
        <br>
        <br>
        <br>
        <input name="total_productos" type="hidden" value="<?php echo $granTotal_productos; ?>">
        <input name="total_servicios" type="hidden" value="<?php echo $granTotal_servicios; ?>">
        <input name="total_documentos" type="hidden" value="<?php echo $granTotal_documentos; ?>">
        <button type="submit" class="btn btn-success">Terminar venta</button>
        <a href="cancelarVenta.php" class="btn btn-danger">Cancelar venta</a>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#vendedor').select2();
            $('#placa').select2();
        });
    </script>
</body>

</html>