
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Verificación de Código</title>
<?php require_once ("../styles/dependencias.php"); ?>
 <!-- Agregar los enlaces a Bootstrap CSS y jQuery -->

</head>
<body>
 <div class="container mt-5">
  <h1>Verificación de Código</h1>
  <form method="POST" action="adminblo.php">
   <div class="form-group">
    <label for="codigo">Ingrese el código de 6 dígitos:</label>
    <input type="number" class="form-control" id="codigo" name="token" maxlength="6" required>
   </div>
   <button type="submit" class="btn btn-primary">Verificar</button>
   <input type="hidden" name="codigo">
  </form>
 </div>
 <!-- Agregar el enlace a jQuery y Bootstrap JS -->

</body>
</html>