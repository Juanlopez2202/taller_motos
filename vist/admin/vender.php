<?php
require_once "navbar.php";

$db = new database();
$conectar = $db->conectar();

$consul = $conectar->prepare("SELECT * FROM usuarios WHERE id_tip_usu = 1 ");
$consul->execute();

$consu = $conectar->prepare("SELECT * FROM moto ");
$consu->execute();

// Obtener el valor de "status" si está presente en la URL
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Mostrar el mensaje correspondiente según el valor de "status"
if (isset($_GET["status"])) {
    if ($_GET["status"] === "1") {
        echo '<div class="alert alert-success" role="alert">
                <strong>¡Correcto!</strong> El producto se ha agregado al carrito correctamente.
              </div>';
    } else if ($_GET["status"] === "2") {
        echo '<div class="alert alert-danger" role="alert">
                <strong>Error:</strong> El producto, servicio o documento no existe.
              </div>';
    } else if ($_GET["status"] === "3") {
        echo '<div class="alert alert-warning" role="alert">
                <strong>Advertencia:</strong> El producto no tiene existencias disponibles.
              </div>';
    } else if ($_GET["status"] === "4") {
        echo '<div class="alert alert-warning" role="alert">
                <strong>Advertencia:</strong> Venta cancelada.
              </div>';
    }else if ($_GET["status"] === "5") {
        echo '<div class="alert alert-success" role="alert">
                <strong>Advertencia:</strong> La cantidad del producto ha sido actualizada correctamente.
              </div>';
    
    }else if ($_GET["status"] === "6") {
        echo '<div class="alert alert-warning" role="alert">
                <strong>Advertencia:</strong> El servicio ya fue agregado al carrito.
              </div>';
    }else if ($_GET["status"] === "7") {
        echo '<div class="alert alert-warning" role="alert">
                <strong>Advertencia:</strong> El documento ya fue agregado al carrito.
              </div>';

    }else if ($_GET["status"] === "8") {
        echo '<div class="alert alert-warning" role="alert">
                <strong>Advertencia:</strong> La moto tiene soat vigente .
              </div>';

    }else if ($_GET["status"] === "9") {
        echo '<div class="alert alert-warning" role="alert">
                <strong>Advertencia:</strong> La moto tiene tecnomecanica vigente  .
              </div>';

    }
    else if ($_GET["status"] === "10") {
        echo '<div class="alert alert-success" role="alert">
                <strong>Advertencia:</strong> venta realizada con exito  .
              </div>';

    }
    else if ($_GET["status"] === "11") {
        echo '<div class="alert alert-success" role="alert">
                <strong>Advertencia:</strong> Producto eliminado del carrito  .
              </div>';

    }
    else if ($_GET["status"] === "12") {
        echo '<div class="alert alert-success" role="alert">
                <strong>Advertencia:</strong> Serivicio eliminado del carrito  .
              </div>';

    } else if ($_GET["status"] === "13") {
        echo '<div class="alert alert-success" role="alert">
                <strong>Advertencia:</strong> Documento eliminado del carrito  .
              </div>';

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

$granTotal = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
   
    <!-- Bootstrap CSS -->

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 20px;
        }

        .btn-primary,
        .btn-success,
        .btn-danger {
            margin-top: 10px;
        }

        .total {
            font-size: 24px;
            font-weight: bold;
        }
        .oculto{
            visibility: hidden;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ventas</h1>
        <br>
        <form method="post" action="agregarAlCarrito.php">
            <label for="servicio">Servicio</label>
            <select class="form-control" name="codigo" id="servicio" required>
                <option value="">Seleccione un servicio, producto o documento</option>
                <?php
                $consultaServicios = $conectar->prepare("SELECT id_servicios AS id, servicio AS nombre FROM servicio");
                $consultaServicios->execute();

                $consultaProductos = $conectar->prepare("SELECT  id_productos AS id, nom_producto AS nombre FROM productos");
                $consultaProductos->execute();

                $consultaDocumentos = $conectar->prepare("SELECT  id_documentos AS id, documentos AS nombre FROM documentos");
                $consultaDocumentos->execute();

                $resultados = array_merge($consultaServicios->fetchAll(), $consultaProductos->fetchAll(), $consultaDocumentos->fetchAll());

                foreach ($resultados as $resultado) {
                    echo "<option value='" . $resultado["id"] . "'>" . $resultado["nombre"] . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary">Agregar al carrito</button>
        </form>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Valor unitario</th>
                        <th>Quitar</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Combinar los datos de los carritos en una sola variable
                    $carrito = array_merge($_SESSION["carrito_productos"], $_SESSION["carrito_servicios"], $_SESSION["carrito_documentos"]);

                    foreach ($carrito as $indice => $item) {
                        $granTotal += $item["subtotal"];
                    ?>
                        <tr>
                            
                            <td><?php echo $item["nombre"]; ?></td>
                            <td><?php echo $item["descripcion"]; ?></td>
                            <td><?php echo $item["precio"]; ?></td>
                         
                            <td><a class="btn btn-danger" href="<?php echo "quitarDelCarrito.php?indice=" . $indice; ?>">Quitar</a></td>
                            <td>
                                <form action="cambiar_cantidad.php" method="post">
                                    <input name="indice" type="hidden" value="<?php echo $indice; ?>">
                                    <input min="1" name="cantidad" class="form-control" required type="number" value="<?php echo $item["cantidad"]; ?>">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </form>
                            </td>
                            <td class="oculto"><?php echo $item["id"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h3 class="total">Total: <?php echo $granTotal; ?></h3>

        <form action="terminarVenta.php" method="POST">
            <label class="label1">Vehiculo</label>
            <select class="form-control select-box" id="placa" name="placa">
                <option disabled selected value="">Elige vehiculo por placa</option>
                <?php foreach ($consu as $moto) { ?>
                    <option value="<?php echo ($moto['placa']) ?>"><?php echo ($moto["placa"]) ?> </option>
                <?php } ?>
            </select>

            <label class="label1">Vendedor</label>
            <select class="form-control select-box" id="vendedor" name="vendedor">
                <option disabled selected value="">Elige un vendedor</option>
                <?php foreach ($consul as $vendedor) { ?>
                    <option value="<?php echo ($vendedor['documento']) ?>"><?php echo ($vendedor['nombre_completo']) ?> </option>
                <?php } ?>
            </select>

            <input name="gran_total" type="hidden" value="<?php echo $granTotal; ?>">
            <button type="submit" class="btn btn-success">Terminar venta</button>
            <a href="cancelarVenta.php" class="btn btn-danger">Cancelar venta</a>
        </form>
    </div>

    <!-- jQuery -->
   

    <script>
        $(document).ready(function() {
            $('#vendedor').select2();
            $('#placa').select2();
            $('#servicio').select2();
        });
    </script>
</body>

</html>
