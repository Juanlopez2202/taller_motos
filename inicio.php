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
 // Si las credenciales son correctas y el inicio de sesión es exitoso, borramos la variable de sesión 'intentos'
                   unset($_SESSION['intentos']);


                if ($_SESSION['tipo'] == 1 && $_SESSION['estado'] == 1) {
                    header("Location: vist/admin/index.php");
                    exit();
                } else if ($_SESSION['tipo'] == 2 && $_SESSION['estado'] == 1) {
                    header("Location: vist/usuario/index.php");
                    exit();
                } else if ($_SESSION['tipo'] == 3 && $_SESSION['estado'] == 1) {
                    header("Location: ");
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
            $intentosPermitidos = 3; // Número máximo de intentos permitidos

            // Verificar si la variable de sesión existe, si no existe, establecerla en 1
            if (!isset($_SESSION['intentos'])) {
                $_SESSION['intentos'] = 1;
            } else {
                // Si ya existe la variable de sesión, aumentar el conteo de intentos
                $_SESSION['intentos']++;
            }

            // Si se alcanza el número máximo de intentos, bloquear al usuario
            if ($_SESSION['intentos'] >= $intentosPermitidos) {
                $bloqueo = $conectar->prepare("UPDATE usuarios SET id_estado = '2' WHERE documento = '$cedula'");
                $bloqueo->execute();
                echo '<script>alert("Ha excedido el número de intentos, por tal motivo ha sido bloqueado");</script>';
                echo '<script>window.location="vist/admin/bloqueo.php"</script>';
                exit();
            } else {
                // Si la contraseña es incorrecta, mostrar un mensaje y permitir otro intento
                echo '<script>alert("Contraseña Incorrecta. Intento ' . $_SESSION['intentos'] . ' de ' . $intentosPermitidos . '");</script>';
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
