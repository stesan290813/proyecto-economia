<!doctype html>
<html lang="es">
<head>
  <title>Inicio de Sesión</title>
  <meta charset="utf-8">
  <meta name="author" content="Grupo Rapidito">
  <meta name="description" content="Proyecto Final - Economia Digital">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/Rapidito.jpeg" rel="shortcut icon" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <meta name="theme-color" content="#ff9900"/>
  <link rel="manifest" href="manifest.json">
</head>

<body class="text-center">
  
<form id="login">
  <div class="form-signin" style="margin-top: 10%;">
    <a href="index.php"><img class="mb-4" src="img/Rapiditologo.png" alt="" width="250" height="80"></a>
    <input type="email" id="email" class="form-control my-2" placeholder="Correo Electronico" required autofocus>
    <input type="password" id="password" class="form-control" placeholder="Contraseña" required>
    <button class="btn btn-lg btn-primary btn-block" id="btn-login">Ingresar</button>
  </div>  
</form>
<div style="width: 300px; position:absolute; left: 532px;">
  <form action="index.php">
  <button class="btn btn-lg btn-primary btn-block" id="btn-login" type="submit">Regresar</button>
  </form>
</div>

<div id="response" class="alert alert-danger" style="display: none;"></div>

<script src="js/jquery.min.js"></script>
<script src="js/login-controller.js"></script>

</body>
</html>
