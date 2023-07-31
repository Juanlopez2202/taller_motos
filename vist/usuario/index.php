<?php 
    session_start();

    require_once("../../bd/conexion.php");
    
    $db = new Database();
    $conectar = $db->conectar();
    require_once ("../../controller/styles/dependencias.php");

    // Obtener información de las motos del cliente logueado y sus detalles relacionados
    $documento_id = $_SESSION['documento'];
    $consultaMotos = $conectar->prepare("
        SELECT 
            m.placa, 
            m.ultimo_cambio,
            m.proximo_cambio_km,
            m.proximo_cambio_fecha,
            mo.modelo,
            ma.marca,
            ci.cilindraje,
            co.color,
            fv.fecha_vigencia_soat, 
            fv.fecha_vigencia_tecnomecanica, 
            u.nombre_completo AS nombre_cliente, 
            u.email AS email_cliente
        FROM moto m
        INNER JOIN usuarios u ON m.documento = u.documento
        INNER JOIN modelo mo ON m.id_modelo = mo.id_modelo
        INNER JOIN marca ma ON m.id_marca = ma.id_marca
        INNER JOIN cilindraje ci ON m.id_cilindraje = ci.id_cilindraje
        INNER JOIN color co ON m.id_color = co.id_color
        LEFT JOIN factura_venta fv ON m.placa = fv.placa
        WHERE m.documento = ?
        GROUP BY m.placa
    ");
    $consultaMotos->execute([$documento_id]);
    $motos = $consultaMotos->fetchAll(PDO::FETCH_ASSOC);
    
    // Paginación
    $motosPorPagina = 1; // Número de motos a mostrar por página
    $totalMotos = count($motos);
    $totalPaginas = ceil($totalMotos / $motosPorPagina);

    if (!isset($_GET['pagina'])) {
        $paginaActual = 1;
    } else {
        $paginaActual = $_GET['pagina'];
    }

    $inicioMoto = ($paginaActual - 1) * $motosPorPagina;
    $motosPaginadas = array_slice($motos, $inicioMoto, $motosPorPagina);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>
    <!-- Bootstrap CSS -->
</head>

<body>
    <?php require_once("navar.php");?>

    <div class="container mt-5">
        <h1>Bienvenido a tu cuenta</h1>

        <?php foreach ($motosPaginadas as $moto) { ?>
            <div class="accordion mb-3" id="accordion-<?php echo $moto['placa']; ?>">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-<?php echo $moto['placa']; ?>">

                            Información de tu moto (Placa: <?php echo $moto['placa']; ?>)
                       
                    </h2>
                    <div id="collapse-<?php echo $moto['placa']; ?>" class="accordion-collapse collapse show" aria-labelledby="heading-<?php echo $moto['placa']; ?>" data-bs-parent="#accordion-<?php echo $moto['placa']; ?>">
                        <div class="accordion-body">
                            <p><strong>Cliente:</strong> <?php echo $moto['nombre_cliente']; ?></p>
                            <p><strong>Email:</strong> <?php echo $moto['email_cliente']; ?></p>
                            <p><strong>Modelo:</strong> <?php echo $moto['modelo']; ?></p>
                            <p><strong>Marca:</strong> <?php echo $moto['marca']; ?></p>
                            <p><strong>Cilindraje:</strong> <?php echo $moto['cilindraje']; ?></p>
                            <p><strong>Color:</strong> <?php echo $moto['color']; ?></p>
                            
                            <!-- Información de cambio de aceite -->
                            <h2>Información de Cambio de Aceite</h2>
                            <?php
                                // Obtener información de cambio de aceite de la tabla "moto"
                                $ultimocambio = $moto["ultimo_cambio"];
                                $proximoCambioAceiteFecha = $moto["proximo_cambio_fecha"];
                                $kmPorCambioAceite = $moto["proximo_cambio_km"];

                                if ($proximoCambioAceiteFecha !== null && $kmPorCambioAceite !== null) {
                                    // Calcular la cantidad de días restantes para el próximo cambio de aceite
                                    $fecha_hoy = date("Y-m-d");
                                    $dias_restantes_cambio_aceite = (strtotime($proximoCambioAceiteFecha) - strtotime($fecha_hoy)) / (60 * 60 * 24);
                            ?>
                                    <p><strong>Su último cambio de aceite fue:</strong> <?php echo $ultimocambio; ?></p>
                                    <p><strong>Próximo Cambio de Aceite:</strong> <?php echo $proximoCambioAceiteFecha; ?></p>
                                    <p><strong>Kilómetros Recomendados:</strong> <?php echo $kmPorCambioAceite; ?></p>
                                    <p><strong>Días Restantes para el Cambio de Aceite:</strong> <?php echo $dias_restantes_cambio_aceite; ?></p>
                            <?php } else {
                                    // Mostrar un mensaje cuando no hay información de cambio de aceite
                                    echo "<p>No hay información de cambio de aceite para esta moto.</p>";
                                }
                            ?>

                            <!-- Tabla de Facturas de Venta para esta moto -->
                            <h2>Facturas de Venta</h2>
                            <?php
                                $consultaFacturas = $conectar->prepare("
                                    SELECT
                                        fv.id_venta,
                                        fv.fecha,
                                        fv.total,
                                        p.nom_producto,
                                        dv.cantidad AS cantidad_producto,
                                        p.precio AS precio_producto,
                                        s.servicio,
                                        dvs.cantidad AS cantidad_servicio,
                                        s.precio AS precio_servicio,
                                        d.documentos,
                                        dvdocu.id_documentos as docu,
                                        d.precio AS precio_documento
                                    FROM factura_venta fv
                                    LEFT JOIN detalle_venta dv ON fv.id_venta = dv.id_venta
                                    LEFT JOIN productos p ON dv.id_producto = p.id_productos
                                    LEFT JOIN detalle_vservi dvs ON fv.id_venta = dvs.id_venta
                                    LEFT JOIN servicio s ON dvs.id_servicio = s.id_servicios
                                    LEFT JOIN detalle_vdocu dvdocu ON fv.id_venta = dvdocu.id_venta
                                    LEFT JOIN documentos d ON dvdocu.id_documentos = d.id_documentos
                                    WHERE fv.placa = ?
                                ");
                                $consultaFacturas->execute([$moto['placa']]);
                                $facturas = $consultaFacturas->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="table-responsive">
                                <table id="tablaFacturas" class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID Venta</th>
                                            <th>Fecha de Venta</th>
                                            <th>Total</th>
                                            <th>Productos</th>
                                            <th>Servicios</th>
                                            <th>Documentos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($facturas as $factura) { ?>
                                            <tr>
                                                <td><?php echo $factura["id_venta"]; ?></td>
                                                <td><?php echo $factura["fecha"]; ?></td>
                                                <td><?php echo $factura["total"]; ?></td>
                                                <td>
                                                    <?php
                                                        if ($factura["cantidad_producto"] !== null) {
                                                            echo "<strong>Producto:</strong> " . $factura["nom_producto"] . "<br><strong>Cantidad:</strong> " . $factura["cantidad_producto"] . "<br><strong>Precio:</strong> $" . $factura["precio_producto"] . "<br><strong>Subtotal:</strong> $" . $factura["cantidad_producto"] * $factura["precio_producto"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ($factura["cantidad_servicio"] !== null) {
                                                            echo "<strong>Servicio:</strong> " . $factura["servicio"] . "<br><strong>Cantidad:</strong> " . $factura["cantidad_servicio"] . "<br><strong>Precio:</strong> $" . $factura["precio_servicio"] . "<br><strong>Subtotal:</strong> $" . $factura["cantidad_servicio"] * $factura["precio_servicio"];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ($factura["docu"] !== null) {
                                                            echo "<strong>Documento:</strong> " . $factura["documentos"] .  "<br><strong>Precio:</strong> $" . $factura["precio_documento"] . "<br><strong>Subtotal:</strong> $" . $factura["precio_documento"];
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <li class="page-item <?php if ($i === $paginaActual) echo 'active'; ?>"><a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS -->
   
    <script>
    // Inicializar DataTables
    $(document).ready(function() {
        $('#tablaFacturas').DataTable();
    });
    </script>

</body>

</html>
