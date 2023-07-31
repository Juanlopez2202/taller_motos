<?php

    $correo = "juan.lopez7196@misena.edu.co";
    $paracorreo = $correo;
    $titulo ="Usuario bloqueo";
    $msj = "Administrador se acaba de inavilitar un usuario por exceder el numero establecido de intentos, por favor revise que usuario es y habilitelo nuevamente";
    $tucorreo="From:juan.lopez@misena.edu.co";
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