<?php
require_once("navbar.php");

$db = new database();
$conectar = $db->conectar();

// Consulta para obtener las facturas de ventas y sus detalles de productos, servicios y documentos
$consultaFacturas = $conectar->prepare("
    SELECT
        fv.id_venta,
        fv.placa,
        fv.fecha,
        fv.fecha_vigencia_soat,
        fv.fecha_vigencia_tecnomecanica,
        fv.documento,
        fv.total,
        p.nom_producto,
        dv.cantidad AS cantidad_producto,
        p.precio AS subtotal_producto,
        s.servicio,
        dvs.cantidad AS cantidad_servicio,
        dvs.subtotal AS subtotal_servicio,
        d.documentos,
        dvdocu.subtotal AS subtotal_documento
    FROM factura_venta fv
    LEFT JOIN detalle_venta dv ON fv.id_venta = dv.id_venta
    LEFT JOIN productos p ON dv.id_producto = p.id_productos
    LEFT JOIN detalle_vservi dvs ON fv.id_venta = dvs.id_venta
    LEFT JOIN servicio s ON dvs.id_servicio = s.id_servicios
    LEFT JOIN detalle_vdocu dvdocu ON fv.id_venta = dvdocu.id_venta
    LEFT JOIN documentos d ON dvdocu.id_documentos = d.id_documentos
");

$consultaFacturas->execute();
$facturas = $consultaFacturas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas de Ventas</title>
    <!-- Bootstrap CSS -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Facturas de Ventas</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID Venta</th>
                        <th>Placa del Vehículo</th>
                        <th>Fecha de Venta</th>
                        <th>Fecha de Vigencia SOAT</th>
                        <th>Fecha de Vigencia Tecnomecánica</th>
                        <th>Documento</th>
                        <th>Total</th>
                        <th>Productos</th>
                        <th>Servicios</th>
                        <th>Documentos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($facturas as $factura) { ?>
                        <tr>
                            <td><?php echo $factura["id_venta"]; ?></td>
                            <td><?php echo $factura["placa"]; ?></td>
                            <td><?php echo $factura["fecha"]; ?></td>
                            <td><?php echo $factura["fecha_vigencia_soat"]; ?></td>
                            <td><?php echo $factura["fecha_vigencia_tecnomecanica"]; ?></td>
                            <td><?php echo $factura["documento"]; ?></td>
                            <td><?php echo $factura["total"]; ?></td>
                            <td>
                                <?php
                                if ($factura["cantidad_producto"] !== null) {
                                    echo "<strong>Nombre:</strong> " . $factura["nom_producto"] . "<br><strong>Cantidad:</strong> " . $factura["cantidad_producto"] . "<br><strong>Subtotal:</strong> " . $factura["subtotal_producto"];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($factura["cantidad_servicio"] !== null) {
                                    echo "<strong>Servicio:</strong> " . $factura["servicio"] . "<br><strong>Cantidad:</strong> " . $factura["cantidad_servicio"] . "<br><strong>Subtotal:</strong> " . $factura["subtotal_servicio"];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($factura["subtotal_documento"] !== null) {
                                    echo "<strong>Documento:</strong> " . $factura["documentos"] . "<br><strong>Subtotal:</strong> " . $factura["subtotal_documento"];
                                }
                                ?>
                            </td>
                            <td>
                                <a href="imprimir.php?id=<?php echo $factura['id_venta']; ?>" class="btn btn-primary">
                                    <i class="fas fa-print me-2"></i>Imprimir
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Imprimir Facturas
            </button>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>

</html>