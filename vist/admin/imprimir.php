<?php
if (!isset($_GET["id"])) {
    exit("No hay id");
}

$id = $_GET["id"];
require_once("../../bd/conexion.php");
$db = new database();
$conectar = $db->conectar();
$sentencia = $conectar->prepare("SELECT id_venta, fecha, total FROM factura_venta WHERE id_venta = ?");
$sentencia->execute([$id]);
$venta = $sentencia->fetchObject();
if (!$venta) {
    exit("No existe venta con el id proporcionado");
}

$sentenciaProductos = $conectar->prepare("SELECT productos.id_productos, productos.nom_producto, productos.precio, detalle_venta.cantidad, factura_venta.total
FROM productos
INNER JOIN detalle_venta
ON productos.id_productos = detalle_venta.id_producto
INNER JOIN factura_venta on
factura_venta.id_venta= detalle_venta.id_venta
WHERE detalle_venta.id_venta = ?");
$sentenciaProductos->execute([$id]);
$productos = $sentenciaProductos->fetchAll(PDO::FETCH_OBJ);

$sentenciaServicios = $conectar->prepare("SELECT servicio.id_servicios, servicio.servicio, servicio.precio, detalle_vservi.cantidad, factura_venta.total
FROM servicio
INNER JOIN detalle_vservi
ON servicio.id_servicios = detalle_vservi.id_servicio
INNER JOIN factura_venta on
factura_venta.id_venta= detalle_vservi.id_venta
WHERE detalle_vservi.id_venta = ?");
$sentenciaServicios->execute([$id]);
$servicios = $sentenciaServicios->fetchAll(PDO::FETCH_OBJ);

$sentenciaDocumentos = $conectar->prepare("SELECT documentos.id_documentos, documentos.documentos, documentos.precio,  factura_venta.total
FROM documentos
INNER JOIN detalle_vdocu
ON documentos.id_documentos = detalle_vdocu.id_documentos
INNER JOIN factura_venta on
factura_venta.id_venta= detalle_vdocu.id_venta
WHERE detalle_vdocu.id_venta = ?");
$sentenciaDocumentos->execute([$id]);
$documentos = $sentenciaDocumentos->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Venta</title>
 
<style>
    * {
        font-size: 12px;
        font-family: 'Times New Roman';
    }

    
    table {
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    td.producto,
    th.producto {
        width: 75px;
        max-width: 75px;
    }

    td.cantidad,
    th.cantidad {
        width: 50px;
        max-width: 50px;
        word-break: break-all;
    }

    td.precio,
    th.precio {
        width: 60px;
        max-width: 60px;
        word-break: break-all;
        text-align: right;
    }

    .centrado {
        text-align: center;
        align-content: center;
    }

    .ticket {
        width: 175px;
        max-width: 175px;
    }

    img {
        max-width: inherit;
        width: inherit;
    }

    @media print {

        .oculto-impresion,
        .oculto-impresion * {
            display: none !important;
        }
    }
</style>

<body>
</head>

<body>
    <div class="ticket">
        <img src="../../controller/img/27520215_7323981.jpg" alt="Logotipo">
        <p class="centrado">FACTURA DE VENTA
            <br><?php echo $venta->fecha; ?>
        </p>

        <h3>Productos</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto->cantidad; ?></td>
                        <td><?php echo $producto->nom_producto; ?></td>
                        <td>$<?php echo $producto->precio; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Servicios</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Servicio</th>
                    <th>Precio Unitario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicios as $servicio) { ?>
                    <tr>
                        <td><?php echo $servicio->cantidad; ?></td>
                        <td><?php echo $servicio->servicio; ?></td>
                        <td>$<?php echo $servicio->precio; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Documentos</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Documento</th>
                    <th>Precio Unitario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentos as $documento) { ?>
                    <tr>
                        <td><?php echo $documento->id_documentos; ?></td>
                        <td><?php echo $documento->documentos; ?></td>
                        <td>$<?php echo $documento->precio; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <p class="centrado">TOTAL: $<?php echo $venta->total; ?></p>
        <p class="centrado">¡GRACIAS POR SU COMPRA!</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para imprimir la factura y redirigir a la página de ventas después de la impresión
        document.addEventListener("DOMContentLoaded", () => {
            window.print();
            setTimeout(() => {
                window.location.href = "./ventas.php";
            }, 1000);
        });
    </script>
</body>

</html>