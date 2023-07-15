<?php 


    include("../../controller/validar.php");

    require_once("../../bd/conexion.php");
    $db = new Database();
    $conectar= $db->conectar();
    require_once ("../../controller/styles/dependencias.php");

?>

<?php
  if(isset($_POST['btncerrar']))
  {
      session_destroy();
      header('location:../../index.html');
  } 
?>

<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="../../controller/img/icono.png" type="image/x-icon">
  <title>Menu administrador</title>
</head>
<body>

  <!-- Begin Navbar -->
  <div id="nav">
    <div class="navbar navbar-inverse navbar-fixed-top" data-spy="affix" data-offset-top="100">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img class="bl img-responsive logo img-thumbnail" src="../../controller/img/27520215_7323981.jpg" alt="" width="100px" height="100spx"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">

          <ul class="nav navbar-nav navbar-right">

            <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span>‎ ‎ ‎Inicio</a>
            </li>

            
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span>‎ ‎ ‎Menu <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="cilindraje.php">Cilindraje</a></li>
              <li><a href="color.php">Color</a></li>
              <li><a href="combustible.php">Combustible</a></li>
              <li><a href="doculegal.php">Documentos legales</a></li>
              <li><a href="estado.php">Estado</a></li>
              <li><a href="linea.php">Linea</a></li>
              <li><a href="marca.php">Marca</a></li>
              <li><a href="modelo.php">Modelo</a></li>
              <li><a href="productos.php">Productos</a></li>
              <li><a href="servicio.php">Servicios</a></li>
              <li><a href="tip_carroceria.php">Tipo de carroceria</a></li>
              <li><a href="tip_servicio.php">Tipo de servicio</a></li>
              <li><a href="tip_usu.php">Tipo usuarios</a></li>
              <li><a href="tip_vehiculo.php">Tipo de vehiculo</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-barcode"></span>‎ ‎ ‎Barcode <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="barcode.php">Codigo de barras productos</a></li>
              <li><a href="barcodem.php">Codigo de barras moto</a></li>
            </ul>
          </li>

          <li><a href="respaldo.php"><span class="glyphicon glyphicon-floppy-save"></span>‎ ‎ ‎Respaldo db</a>
            </li>

           <li><a href="usuarios.php"><span class="glyphicon glyphicon-user"></span>‎ ‎ ‎ Administrar usuarios</a>
            </li>
       


           <li><a href="motos.php"><span class="glyphicon glyphicon-wrench"></span>‎ ‎ ‎Motos</a>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-usd"></span>‎ ‎ ‎Ventas <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="vender.php">Venta de productos</a></li>
            </ul>
          </li>
          <li><a href="ventas.php"><span class="glyphicon glyphicon-shopping-cart"></span>‎ ‎ ‎Historial de ventas</a>
          </li>
        
          
          <li class="dropdown" >
            <a href="#" style="color: red"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>  <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li> <a style="color: red">
            <form method="post">
              <input type="submit" name="btncerrar" class="btn btn-danger" value="Cerrar sesion">
            </form></a></li>

              
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
    <!--/.contatiner -->
  </div>
</div>
<!-- Main jumbotron for a primary marketing message or call to action -->





<!-- /container -->        


</body>
</html>