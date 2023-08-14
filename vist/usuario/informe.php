<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas de Vencimiento</title>
  
</head>

<body>
  

    <?php
    require_once("navar.php");
    require_once ("../../controller/styles/dependencias.php");
    require_once("../../bd/conexion.php");
    $db = new database();
    $conectar = $db->conectar();
    session_start();
    date_default_timezone_set('America/Bogota');
   $documento= $_SESSION['documento'];
    $placa1 = isset($_GET['placa']) ? $_GET['placa'] : '';
    $sentencia = $conectar->prepare("
    SELECT
    fv.placa,
    fv.fecha_vigencia_soat,
    fv.fecha_vigencia_tecnomecanica,
    fv.estado
    FROM factura_venta fv
    INNER JOIN moto m
    ON fv.placa = m.placa 
    WHERE fv.estado = 'vigente' AND (fv.fecha_vigencia_soat IS NOT NULL OR fv.fecha_vigencia_tecnomecanica IS NOT NULL) and m.documento = '$documento' ;
    
    ");

    $sentencia->execute();
    $ventas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container mt-5">
        <h1 class="mb-4">Estado De Documentos</h1>
        <div class="row">
            <div class="col-md-6">
                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="placa" class="form-control" placeholder="Buscar por placa">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Placa del Vehículo</th>
                        <th>Fecha de vigencia SOAT</th>
                        <th>Fecha de vigencia tecnomecanica</th>
                        <th>Estado SOAT</th>
                        <th>Estado Tecnomecánica</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta) {
                        $placa = $venta['placa'];
                        if (!empty($_GET['placa']) && stripos($placa, $_GET['placa']) === false) {
                            continue; // Saltar a la siguiente iteración del bucle
                        }
                        $fechaVencimientoSOAT = strtotime($venta['fecha_vigencia_soat']);
                        $fechaVencimientoTecno = strtotime($venta['fecha_vigencia_tecnomecanica']);
                        $fecha_sistema = strtotime(date('Y-m-d')); // Convertir la fecha del sistema a timestamp

                        $diasFaltantesSOAT = $fechaVencimientoSOAT ? ceil(($fechaVencimientoSOAT - $fecha_sistema) / (60 * 60 * 24)) : null;
                        $diasFaltantesTecno = $fechaVencimientoTecno ? ceil(($fechaVencimientoTecno - $fecha_sistema) / (60 * 60 * 24)) : null;

                        $colorSOAT = 'text-muted';
                        $mensajeSOAT = 'No aplica';
                       

                        if ($diasFaltantesSOAT !== null) {
                            if ($diasFaltantesSOAT < 0) {
                                $colorSOAT = 'text-danger';
                                $mensajeSOAT = 'Vencido';
                                
                            } elseif ($diasFaltantesSOAT == 0) {
                                $colorSOAT = 'text-warning';
                                $mensajeSOAT = 'VENCE HOY';
                            
                            } elseif ($diasFaltantesSOAT <= 20) {
                                $colorSOAT = 'text-warning';
                                $mensajeSOAT = 'Vence en menos de 20 días';
                                
                            } else {
                                $colorSOAT = 'text-success';
                                $mensajeSOAT = 'Vigente';
                            }
                        }

                        $colorTecno = 'text-muted';
                        $mensajeTecno = 'No aplica';
                        

                        if ($diasFaltantesTecno !== null) {
                            if ($diasFaltantesTecno < 0) {
                                $colorTecno = 'text-danger';
                                $mensajeTecno = 'Vencido';
                                
                            } elseif ($diasFaltantesTecno == 0) {
                                $colorTecno = 'text-warning';
                                $mensajeTecno = 'VENCE HOY';
                            
                            } elseif ($diasFaltantesTecno <= 20) {
                                $colorTecno = 'text-warning';
                                $mensajeTecno = 'Vence en menos de 20 días';
                                
                            } else {
                                $colorTecno = 'text-success';
                                $mensajeTecno = 'Vigente';
                            }
                        }
                    ?>
                        <tr>
                            <td><?php echo $placa; ?></td>
                            <td><?php echo $venta['fecha_vigencia_soat']; ?></td>
                            <td><?php echo $venta['fecha_vigencia_tecnomecanica']; ?></td>
                            <td class="<?php echo $colorSOAT; ?>"><?php echo $mensajeSOAT; ?></td>
                            <td class="<?php echo $colorTecno; ?>"><?php echo $mensajeTecno; ?></td>
                          
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
