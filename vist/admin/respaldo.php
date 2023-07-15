<?php
    

    $mysqlDatabaseName = 'taller_motos';
    $mysqlUserName = 'root';
    $mysqlPassword = '1110458199';
    $mysqlHostName = 'localhost';
    $mysqlExportPath = 'respaldo/respaldo.sql';

    $command = 'mysqldump --opt -h' .$mysqlHostName.' -u' .$mysqlUserName .' --password="' .$mysqlPassword .'" ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;

    exec($command,$output,$worked);
    switch($worked){
        case 0:
            echo '<script> alert ("Respaldo exitoso, el documento se encuentra en la ruta: C:\xampp\htdocs\taller\vist\admin/respaldo/respaldo.sql");</script>';
             echo '<script> window.location="index.php"</script>';
            break;
        case 1:
            echo '<script>alert ("ERROR AL REALIZAR EL RESPALDO DE LA BASE DE DATOS");</script>';
            echo '<script> window.location="index.php"</script>';
            break;
        case 2:
            echo '<script>alert ("ERROR AL REALIZAR EL RESPALDO DE LA BASE DE DATOS, POR FAVOR REVISE QUE LOS DATOS DE LA BASE DE DATOS ESTEN CORRECTOS");</script>';
            echo '<script> window.location="index.php"</script>';
            break; 
    }
?>