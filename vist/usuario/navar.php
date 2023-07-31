<?php
  if(isset($_POST['btncerrar']))
  {
      session_destroy();
      header('location:../../index.html');
  }
  date_default_timezone_set('America/Bogota');
?>


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
            
            <li><a href="misdatos.php"><span class="glyphicon glyphicon-user"></span>‎ ‎ ‎Mis datos</a>
            </li>
            <li><a href="documentos.php"><span class="glyphicon glyphicon-user"></span>‎ ‎ ‎Documentos legales </a>
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
    </div>
</div>