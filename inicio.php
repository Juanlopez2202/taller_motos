<?php
require_once("bd/conexion.php");
session_start();

$db = new Database();
$conectar = $db->conectar();

if (isset($_POST["validar"])) {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];
    $cedula = $_POST["documento"];

    $sqli = $conectar->prepare("SELECT password FROM usuarios WHERE documento = :cedula");
    $sqli->bindParam(':cedula', $cedula);
    $sqli->execute();
    $fila1 = $sqli->fetch();

    if ($fila1 !== false) {
        $clave1 = $fila1['password'];

        $pass = password_verify($clave, $clave1); 
        if ($pass) {
            // Reiniciar el contador de intentos fallidos solo para el usuario que se logueó
            $reiniciarIntentos = $conectar->prepare("UPDATE usuarios SET intentos_fallidos = 0 WHERE documento = :cedula");
            $reiniciarIntentos->bindParam(':cedula', $cedula);
            $reiniciarIntentos->execute();

            $sql = $conectar->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND documento = :cedula");
            $sql->bindParam(':usuario', $usuario);
            $sql->bindParam(':cedula', $cedula);
            $sql->execute();
            $fila = $sql->fetch();

            if ($fila !== false) {
                $_SESSION['documento'] = $fila['documento'];
                $_SESSION['nombre'] = $fila['nombre_completo'];
                $_SESSION['tipo'] = $fila['id_tip_usu'];
                $_SESSION['usuario'] = $fila['usuario'];
                $_SESSION['estado'] = $fila['id_estado'];
                $_SESSION['email'] = $fila['email'];

                if ($_SESSION['tipo'] == 1 && $_SESSION['estado'] == 1) {
                    header("Location: vist/admin/index.php");
                    exit();
                } else if ($_SESSION['tipo'] == 2 && $_SESSION['estado'] == 1) {
                    header("Location: vist/usuario/index.php");
                    exit();
                } else if ($_SESSION['tipo'] == 3 && $_SESSION['estado'] == 1) {
                    header("Location: vist/mecanico/vender.php");
                    exit();
                } else {
                    echo '<script>alert("ESTE USUARIO ESTÁ INACTIVO");</script>';
                    echo '<script>window.location="index.html"</script>';
                    exit();
                }
            } else {
                echo '<script>alert("EXISTEN DATOS ERRÓNEOS");</script>';
                echo '<script>window.location="index.html"</script>';
                exit();
            }
        } else {
            // Obtener el tipo de usuario desde la base de datos usando la cédula
            $verificacionTipo = $conectar->prepare("SELECT id_tip_usu, intentos_fallidos FROM usuarios WHERE documento = :cedula");
            $verificacionTipo->bindParam(':cedula', $cedula);
            $verificacionTipo->execute();
            $usuarioData = $verificacionTipo->fetch(PDO::FETCH_ASSOC);

            $usuarioTipo = $usuarioData['id_tip_usu'];
            $intentosFallidos = $usuarioData['intentos_fallidos'];

            // Incrementar el contador de intentos fallidos
            $intentosFallidos++;

            // Establecer el número máximo de intentos permitidos según el tipo de usuario
            $intentosPermitidos = ($usuarioTipo == 1) ? 3 : 3;

            // Si se alcanza el número máximo de intentos, realizar la actualización correspondiente
            if ($intentosFallidos >= $intentosPermitidos) {
                if ($usuarioTipo == 1) {
                    $token = sprintf('%06d', mt_rand(0, 999999));
                    $bloqueo = $conectar->prepare("UPDATE usuarios SET id_estado = 2, token = :token WHERE documento = :cedula");
                    $bloqueo->bindParam(':token', $token);
                    $bloqueo->bindParam(':cedula', $cedula);
                    $bloqueo->execute();
                } elseif ($usuarioTipo == 2) {
                    $bloqueo = $conectar->prepare("UPDATE usuarios SET id_estado = 2 WHERE documento = :cedula");
                    $bloqueo->bindParam(':cedula', $cedula);
                    $bloqueo->execute();
                }

                echo '<script>alert("Ha excedido el número de intentos, por tal motivo ha sido bloqueado");</script>';
                echo '<script>window.location="bloqueo.php?token=' . $cedula . '"</script>';
                exit();
            } else {
                // Actualizar el contador de intentos fallidos en la base de datos
                $actualizarIntentos = $conectar->prepare("UPDATE usuarios SET intentos_fallidos = :intentosFallidos WHERE documento = :cedula");
                $actualizarIntentos->bindParam(':intentosFallidos', $intentosFallidos);
                $actualizarIntentos->bindParam(':cedula', $cedula);
                $actualizarIntentos->execute();

                // Si la contraseña es incorrecta, mostrar un mensaje y permitir otro intento
                echo '<script>alert("Contraseña Incorrecta. Intento ' . $intentosFallidos . ' de ' . $intentosPermitidos . '");</script>';
                echo '<script>window.location="index.html"</script>';
                exit();
            }
        }
    } else {
        echo '<script>alert("Usuario no encontrado");</script>';
        echo '<script>window.location="index.html"</script>';
        exit();
    }
} elseif (empty($_POST["usuario"]) || strlen($_POST["usuario"]) < 4 || empty($_POST["clave"]) || strlen($_POST["clave"]) < 4 || empty($_POST["documento"]) || strlen($_POST["documento"]) < 6) {
    echo '<script>alert("ERROR: Datos incorrectos o vacíos");</script>';
    echo '<script>window.location="index.html"</script>';
    exit();
}
?>
