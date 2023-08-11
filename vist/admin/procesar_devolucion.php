<?php
session_start();
require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_devuelto"], $_POST["id_venta"])) {
    $id_producto_devuelto = $_POST["producto_devuelto"];
    $id_venta = $_POST["id_venta"];

    // Obtener la cantidad vendida y el precio unitario del producto a devolver
    $consultaProducto = $conectar->prepare("SELECT cantidad, subtotal FROM detalle_venta WHERE id_venta = ? AND id_producto = ?");
    $consultaProducto->execute([$id_venta, $id_producto_devuelto]);
    $producto = $consultaProducto->fetch(PDO::FETCH_ASSOC);

    $cantidad_vendida = $producto["cantidad"];
    $precio_unitario = $producto["subtotal"];

  // ...

if ($cantidad_vendida > 0) {
    // Actualizar el total de la factura restando el precio del producto devuelto
    $consultaTotalFactura = $conectar->prepare("SELECT total FROM factura_venta WHERE id_venta = ?");
    $consultaTotalFactura->execute([$id_venta]);
    $total_factura = $consultaTotalFactura->fetchColumn();

    $nuevo_total = $total_factura - ($cantidad_vendida * $precio_unitario);

    // Eliminar el producto del detalle_venta
    $eliminarProducto = $conectar->prepare("DELETE FROM detalle_venta WHERE id_venta = ? AND id_producto = ?");
    $eliminarProducto->execute([$id_venta, $id_producto_devuelto]);

    // Actualizar el total de la factura después de la eliminación
    $actualizarTotalFactura = $conectar->prepare("UPDATE factura_venta SET total = ? WHERE id_venta = ?");
    $actualizarTotalFactura->execute([$nuevo_total, $id_venta]);

    // Sumar la cantidad devuelta a la existencia del producto
    $consultaExistenciaProducto = $conectar->prepare("SELECT cantidad_ini FROM productos WHERE id_productos = ?");
    $consultaExistenciaProducto->execute([$id_producto_devuelto]);
    $existencia_actual = $consultaExistenciaProducto->fetchColumn();

    $nueva_existencia = $existencia_actual + $cantidad_vendida;

    // Actualizar la existencia del producto
    $actualizarExistenciaProducto = $conectar->prepare("UPDATE productos SET cantidad_ini = ? WHERE id_productos = ?");
    $actualizarExistenciaProducto->execute([$nueva_existencia, $id_producto_devuelto]);

    echo "Devolución procesada correctamente.";
} else {
    echo "No se puede realizar la devolución. La cantidad vendida es cero.";
}

// ...
}
?>
