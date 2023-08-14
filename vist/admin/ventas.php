<?php
require_once("../../bd/conexion.php");
include_once "navbar.php";

$db = new database();
$conectar = $db->conectar();

$sentencia = $conectar->prepare("
    SELECT
        fv.id_venta,
        fv.placa,
        fv.fecha,
        fv.fecha_vigencia_soat,
        fv.fecha_vigencia_tecnomecanica,
        fv.documento,
        fv.total,
        ase.aseguradora,
        GROUP_CONCAT(
            DISTINCT p.nom_producto,
            ' (Cantidad: ', dv.cantidad, ', Subtotal: ', p.precio * dv.cantidad, ')' 
            ORDER BY p.id_productos ASC
            SEPARATOR '<br>'
        ) AS productos,
        GROUP_CONCAT(
            DISTINCT s.servicio,
            ' (Cantidad: ', dvs.cantidad, ', Subtotal: ', dvs.subtotal, ')'
            ORDER BY s.id_servicios ASC
            SEPARATOR '<br>'
        ) AS servicios,
        GROUP_CONCAT(
            DISTINCT d.documentos,
            ' (Subtotal: ', dvdocu.subtotal, ')'
            ORDER BY d.id_documentos ASC
            SEPARATOR '<br>'
        ) AS documentos
    FROM factura_venta fv
    LEFT JOIN detalle_venta dv ON fv.id_venta = dv.id_venta
    LEFT JOIN productos p ON dv.id_producto = p.id_productos
    LEFT JOIN detalle_vservi dvs ON fv.id_venta = dvs.id_venta
    LEFT JOIN servicio s ON dvs.id_servicio = s.id_servicios
    LEFT JOIN detalle_vdocu dvdocu ON fv.id_venta = dvdocu.id_venta
    LEFT JOIN documentos d ON dvdocu.id_documentos = d.id_documentos
    LEFT JOIN aseguradora ase ON fv.aseguradora = ase.id_aseguradora
    GROUP BY fv.id_venta
    ORDER BY fv.id_venta;
");

$sentencia->execute();
$ventas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas de Ventas</title>
    
    <style>
        /* Estilos personalizados */
        .inner-table th,
        .inner-table td {
            padding: 0.25rem 0.5rem;
        }

        .subtable {
            width: 100%;
            border-collapse: collapse;
        }

        .subtable-row {
            border-bottom: 1px solid #dee2e6;
        }

        .subtable-cell {
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Facturas de Ventas</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Placa del Vehículo</th>
                        <th>Fecha de Venta</th>
                        <th>Total</th>
                        <th>Detalles</th>
                        <th>Imprimir</th>
                        <th>Devolución</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $factura) { ?>
                        <tr>
                            <td><?php echo $factura["placa"]; ?></td>
                            <td><?php echo $factura["fecha"]; ?></td>
                            <td><?php echo $factura["total"]; ?></td>
                            <td class="subtable-column">
                                <table class="subtable">
                                    <?php if (!empty($factura["productos"])) { ?>
                                        <tr class="subtable-row">
                                            <td class="subtable-cell">Detalles de Productos:</td>
                                            <td class="subtable-cell">
                                                <?php echo str_replace('<br>', '<br>', $factura["productos"]); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (!empty($factura["servicios"])) { ?>
                                        <tr class="subtable-row">
                                            <td class="subtable-cell">Detalles de Servicios:</td>
                                            <td class="subtable-cell">
                                                <?php echo str_replace('<br>', '<br>', $factura["servicios"]); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (!empty($factura["documentos"])) { ?>
                                        <tr class="subtable-row">
                                            <td class="subtable-cell">Detalles de Documentos:</td>
                                            <td class="subtable-cell">
                                                <?php echo str_replace('<br>', '<br>', $factura["documentos"]); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td>
                                <a href="imprimir.php?id=<?php echo $factura['id_venta']; ?>" class="btn btn-primary">
                                    <i class="fas fa-print me-2"></i>Imprimir
                                </a>
                            </td>
                            <td>
                                <a href="devolucion.php?id_venta=<?php echo $factura['id_venta']; ?>" class="btn btn-warning">
                                    <i class="fas fa-exchange-alt me-2"></i>Devolución
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

</body>

</html>