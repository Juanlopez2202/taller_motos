
<?php


require_once("../../bd/conexion.php");

$db = new Database();
$conectar= $db->conectar();

    if ((isset($_POST["agregar"]))&&($_POST["agregar"]=="formu"))
    {
        $id=$_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $cantidad= $_POST['cantidad'];
        $estado=$_POST['estados'];
        



        $validar="SELECT * FROM productos WHERE id_productos='$id' or nom_producto='$nombre'";
        $queryi=$conectar->prepare($validar);
        $queryi->execute();
        $fila1=$queryi->fetchAll(PDO::FETCH_ASSOC);

        if ($fila1){
            echo '<script> alert ("EL PRODUCTO YA EXISTE");</script>';
            echo '<script> windows.location= "index.php"</script>';

        }

        else if ($id=="" || $nombre=="" || $precio=="" || $descripcion=="" || $cantidad=="" ||$estado=="")
        {
            echo '<script> alert (" EXISTEN DATOS VACIOS");</script>';
            echo '<script> windows.location="index.php"</script>';
        }
        
        else
        {
            $insertsql=$conectar->prepare("INSERT INTO productos(id_productos,nom_producto,precio,cantidad_ini,id_estado) VALUES (?,?, ?, ?,?);");
            $resul=$insertsql->execute([$id,$nombre,$precio,$descripcion,$cantidad,$estado]);
            echo '<script>alert ("Registro Exitoso, Gracias");</script>';
            echo '<script> window.location="estado.php"</script>';
        }

    }

?>