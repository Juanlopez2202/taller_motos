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
            fv.fecha,
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
        <h1 class="mb-4">Bienvenido a tu cuenta</h1>

        <?php foreach ($motosPaginadas as $moto) { ?>
            <div class="card mb-3">
                <div class="card-header">
                  <h2>  Información de tu moto (Placa: <?php echo $moto['placa']; ?>)</h2>
                </div>
                <div class="card-body">
                    <p><strong>Cliente:</strong> <?php echo $moto['nombre_cliente']; ?></p>
                    <p><strong>Email:</strong> <?php echo $moto['email_cliente']; ?></p>
                    <p><strong>Modelo:</strong> <?php echo $moto['modelo']; ?></p>
                    <p><strong>Marca:</strong> <?php echo $moto['marca']; ?></p>
                    <p><strong>Cilindraje:</strong> <?php echo $moto['cilindraje']; ?></p>
                    <p><strong>Color:</strong> <?php echo $moto['color']; ?></p>
                    <p><strong>Fecha de Compra:</strong> <?php echo $moto['fecha']; ?></p>

                    <!-- Información del SOAT -->
                    <?php
                    $consultaSoat = $conectar->prepare("
                        SELECT GROUP_CONCAT(fv.fecha_vigencia_soat) AS fechas_soat
                        FROM factura_venta fv
                        WHERE fv.placa = ? AND fv.fecha_vigencia_soat IS NOT NULL
                    ");
                    $consultaSoat->execute([$moto['placa']]);
                    $fechas_soat = $consultaSoat->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <?php if ($fechas_soat['fechas_soat'] !== null) { ?>
                        <h3>Información del SOAT</h3>
                        <?php
                        $array_fechas_soat = explode(',', $fechas_soat['fechas_soat']);
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fechas de Vencimiento del SOAT</th>
                                    <th>Días Restantes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($array_fechas_soat as $fecha_soat) {
                                    $dias_restantes_soat = (strtotime($fecha_soat) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
                                    ?>
                                    <tr>
                                        <td><?php echo $fecha_soat; ?></td>
                                        <td><?php echo $dias_restantes_soat; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <!-- Información de la Tecnomecánica -->
                    <?php
                    $consultaTecno = $conectar->prepare("
                        SELECT GROUP_CONCAT(fv.fecha_vigencia_tecnomecanica) AS fechas_tecnomecanica
                        FROM factura_venta fv
                        WHERE fv.placa = ? AND fv.fecha_vigencia_tecnomecanica IS NOT NULL
                    ");
                    $consultaTecno->execute([$moto['placa']]);
                    $fechas_tecnomecanica = $consultaTecno->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <?php if ($fechas_tecnomecanica['fechas_tecnomecanica'] !== null) { ?>
                        <h3>Información de la Tecnomecánica</h3>
                        <?php
                        $array_fechas_tecnomecanica = explode(',', $fechas_tecnomecanica['fechas_tecnomecanica']);
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fechas de Vencimiento de la Tecnomecánica</th>
                                    <th>Días Restantes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($array_fechas_tecnomecanica as $fecha_tecnomecanica) {
                                    $dias_restantes_tecnomecanica = (strtotime($fecha_tecnomecanica) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
                                    ?>
                                    <tr>
                                        <td><?php echo $fecha_tecnomecanica; ?></td>
                                        <td><?php echo $dias_restantes_tecnomecanica; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                   
                </div>
            </div>
        <?php } ?>

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <li class="page-item <?php if ($i === $paginaActual) echo 'active'; ?>"><a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
