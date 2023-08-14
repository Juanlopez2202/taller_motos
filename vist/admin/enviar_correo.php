<?php
require_once("../../bd/conexion.php");

$db = new database();
$conectar = $db->conectar();
if (isset($_GET['placa']) && isset($_GET['dias']) && isset($_GET['tipo'])) {
    $placa = $_GET['placa'];
    $dias = $_GET['dias'];
    $tipo = $_GET['tipo'];

    // Consulta para obtener los datos del dueño de la moto
    $consultaDueño = $conectar->prepare("SELECT * FROM usuarios INNER JOIN moto ON moto.documento = usuarios.documento WHERE moto.placa = :placa");
    $consultaDueño->bindParam(":placa", $placa);
    $consultaDueño->execute();
    $dueño = $consultaDueño->fetch(PDO::FETCH_ASSOC);

    $correo = $dueño['email'];
    $nombre = $dueño['nombre_completo'];

    // Configura el mensaje del correo
    $titulo = "Estimado/a {$nombre}";
    $mensaje = "Su ";
    if ($tipo === "soat") {
        $mensaje .= "SOAT";
    } elseif ($tipo === "tecnomecanica") {
        $mensaje .= "Tecnomecánica";
    }
    $mensaje .= " está próxima a vencerse, le quedan {$dias} día(s) de vigencia.";

    // Envía el correo
    $headers = "From: lopezcerquerajuanfrancisco@gmail.com"; // Reemplaza con tu dirección de correo
    if (mail($correo, $titulo, $mensaje, $headers)) {
        echo '<script>alert("Correo enviado con éxito");</script>';
    } else {
        echo '<script>alert("Error al enviar el correo");</script>';
    }

    // Redirige de vuelta a la página principal
    echo '<script>window.location="index.php"</script>';
    exit();
}
?>
