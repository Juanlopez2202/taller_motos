<?php
require_once "navbar.php";

require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();
// Asegúrate de incluir tu archivo de conexión a la base de datos

// ...

// Página de Devoluciones
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_venta"])) {
    $id_venta = $_GET["id_venta"];

    // Consultar detalles de la factura y los productos vendidos
    $consultaFactura = $conectar->prepare("SELECT * FROM factura_venta WHERE id_venta = ?");
    $consultaFactura->execute([$id_venta]);
    $factura = $consultaFactura->fetch(PDO::FETCH_ASSOC);

    if ($factura) {
        $consultaProductosVendidos = $conectar->prepare("
            SELECT dv.*, p.nom_producto, p.precio
            FROM detalle_venta dv
            INNER JOIN productos p ON dv.id_producto = p.id_productos
            WHERE dv.id_venta = ?
        ");
        $consultaProductosVendidos->execute([$id_venta]);
        $productosVendidos = $consultaProductosVendidos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolución de Productos</title>
    <!-- Bootstrap CSS -->
   
</head>

<body>
    <div class="container mt-5">
        <h2>Detalles de la Factura</h2>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Placa del Vehículo:</strong> <?php echo $factura["placa"]; ?></p>
                <p><strong>Fecha de Venta:</strong> <?php echo $factura["fecha"]; ?></p>
                <p><strong>Fecha de Vigencia SOAT:</strong> <?php echo $factura["fecha_vigencia_soat"]; ?></p>
                <p><strong>Fecha de Vigencia Tecnomecánica:</strong> <?php echo $factura["fecha_vigencia_tecnomecanica"]; ?></p>
                <p><strong>Aseguradora:</strong> <?php echo $factura["aseguradora"]; ?></p>
                <p><strong>Documento:</strong> <?php echo $factura["documento"]; ?></p>
                <p><strong>Total:</strong> <?php echo $factura["total"]; ?></p>
            </div>
        </div>

        <h2>Productos Vendidos</h2>
        <?php foreach ($productosVendidos as $producto) { ?>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Producto:</strong> <?php echo $producto["nom_producto"]; ?></p>
                    <p><strong>Cantidad Vendida:</strong> <?php echo $producto["cantidad"]; ?></p>
                    <p><strong>Precio Unitario:</strong> <?php echo $producto["precio"]; ?></p>
                    <p><strong>Subtotal:</strong> <?php echo ($producto["cantidad"] * $producto["precio"]); ?></p>
                </div>
            </div>
        <?php } ?>

        <form method="post" action="procesar_devolucion.php">
            <div class="row">
                <div class="col-md-6">
                    <h2>Realizar Devolución</h2>
                    <select name="producto_devuelto" class="form-control">
                        <?php foreach ($productosVendidos as $producto) { ?>
                            <option value="<?php echo $producto["id_producto"]; ?>"><?php echo $producto["nom_producto"]; ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="id_venta" value="<?php echo $id_venta; ?>">
                    <button type="submit" class="btn btn-warning mt-3">Realizar Devolución</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->

</body>

</html>

<?php
    } else {
         echo '<script>alert ("Factura no encontrada");</script>';
            
    }
}
?>

