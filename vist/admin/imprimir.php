<?php
if (!isset($_GET["id"])) {
    exit("No hay id");
}
$id = $_GET["id"];
require_once("../../bd/conexion.php");
$db = new database();
$conectar= $db->conectar();
$sentencia = $conectar->prepare("SELECT id_venta, fecha, total FROM factura_venta WHERE id_venta = ?");
$sentencia->execute([$id]);
$venta = $sentencia->fetchObject();
if (!$venta) {
    exit("No existe venta con el id proporcionado");
}

$sentenciaProductos = $conectar->prepare("SELECT productos.id_productos, productos.nom_producto,productos.precio, detalle_venta.cantidad,factura_venta.total
FROM productos 
INNER JOIN detalle_venta 
ON productos.id_productos = detalle_venta.id_producto
INNER JOIN factura_venta on
factura_venta.id_venta= detalle_venta.id_venta
WHERE detalle_venta.id_venta = ?");
$sentenciaProductos->execute([$id]);
$productos = $sentenciaProductos->fetchAll(PDO::FETCH_OBJ);
if (!$productos) {
    exit("No hay productos");
}

?>
<style>
    * {
        font-size: 12px;
        font-family: 'Times New Roman';
    }

    td,
    th,
    tr,
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
    <div class="ticket">
        <img src="../../controller/img/27520215_7323981.jpg" alt="Logotipo">
        <p class="centrado">TICKET DE VENTA
            <br><?php echo $venta->fecha; ?>
        </p>
        <table>
            <thead>
                <tr>
                    <th class="cantidad">CANT</th>
                    <th class="producto">PRODUCTO</th>
                    <th class="precio">PRECIO_UNI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($productos as $producto) {
                  
                ?>
                    <tr>
                        <td class="cantidad"><?php echo $producto->cantidad;  ?></td>
                        <td class="producto"><?php echo $producto->nom_producto;  ?></td>
                        <td class="precio">$<?php echo $producto->precio  ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2" style="text-align: right;">TOTAL</td>
                    <td class="precio">
                        <strong>$<?php echo $producto->total ?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="centrado">¡GRACIAS POR SU COMPRA!
        </p>
    </div>
</body>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.print();
        setTimeout(() => {
            window.location.href = "./ventas.php";
        }, 1000);
    });
</script>