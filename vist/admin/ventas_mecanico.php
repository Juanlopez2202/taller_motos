<?php
require_once("navbar.php");

$db = new database();
$conectar = $db->conectar();
date_default_timezone_set('America/Bogota');
$consultaFacturas = $conectar->prepare("
    SELECT
        fv.id_venta,
        fv.placa,
        fv.fecha,
        fv.fecha_vigencia_soat,
        fv.fecha_vigencia_tecnomecanica,
        fv.documento,
        fv.total,
        ase.aseguradora,
        p.nom_producto,
        dv.cantidad AS cantidad_producto,
        p.precio AS subtotal_producto,
        s.servicio,
        dvs.cantidad AS cantidad_servicio,
        dvs.subtotal AS subtotal_servicio,
        d.documentos,
        usu.id_tip_usu,
        dvdocu.subtotal AS subtotal_documento
    FROM factura_venta fv
    LEFT JOIN detalle_venta dv ON fv.id_venta = dv.id_venta
    LEFT JOIN productos p ON dv.id_producto = p.id_productos
    LEFT JOIN detalle_vservi dvs ON fv.id_venta = dvs.id_venta
    LEFT JOIN servicio s ON dvs.id_servicio = s.id_servicios
    LEFT JOIN detalle_vdocu dvdocu ON fv.id_venta = dvdocu.id_venta
    LEFT JOIN documentos d ON dvdocu.id_documentos = d.id_documentos
    LEFT JOIN aseguradora ase ON fv.aseguradora = ase.id_aseguradora
    LEFT JOIN usuarios usu ON fv.documento = usu.documento
    WHERE id_tip_usu = 3 
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
    <title>Ventas y Alertas de Vencimiento</title>
</head>
<body>
    <?php require_once("navbar.php"); ?>

    <div class="container mt-5">
        <h1 class="mb-4">Ventas del Día (mecánicos)</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Placa del Vehículo</th>
                        <th>Fecha de Venta</th>
                        <th>Documento</th>
                        <th>Total</th>
                        <th>Servicios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($facturas as $factura) { ?>
                        <tr>
                            <td><?php echo $factura["placa"]; ?></td>
                            <td><?php echo $factura["fecha"]; ?></td>
                            <td><?php echo $factura["documento"]; ?></td>
                            <td><?php echo $factura["total"]; ?></td>
                            <td>
                                <?php if ($factura["cantidad_servicio"] !== null) { ?>
                                    <strong>Servicio:</strong> <?php echo $factura["servicio"]; ?><br>
                                    <strong>Cantidad:</strong> <?php echo $factura["cantidad_servicio"]; ?><br>
                                    <strong>Subtotal:</strong> <?php echo $factura["subtotal_servicio"]; ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
 </body>
</html>