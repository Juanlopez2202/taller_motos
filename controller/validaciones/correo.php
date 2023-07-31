<?php

    $correo = $_POST['correo'];
    $paracorreo = $correo;
    $titulo ="Recuperacion de contraseña";
    $msj = "Para cambiar tu contraseña da click en el siguiente link: http://localhost/taller/controller/validaciones/contraseña.php";
    $tucorreo="From:juan.lopez7196@misena.edu.co";
    if(mail($paracorreo, $titulo, $msj, $tucorreo))
    {
        echo'<script>alert("Correo enviado con exito");</script>';
        echo '<script> window.location="../../index.html"</script>';
        exit();
    }
    else{
        echo'<script>alert("ERROR, intentelo nuevamente");</script>';
        echo '<script> window.location="../../index.html"</script>';
        exit();
    }

?>