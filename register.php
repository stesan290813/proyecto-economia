<!doctype html>
<html>
<head>
	<title>Registro - Amazon</title>
	<meta charset="utf-8">
	<meta name="author" content="Grupo Rapidito">
  	<meta name="description" content="Proyecto Final - Economia Digital">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="img/Rapidito.jpeg" rel="shortcut icon" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<meta name="theme-color" content="#146eb4"/>
	<link rel="manifest" href="manifest.json">
</head>

<body>

	<div class="form-signin" style="margin-top: 5%;">
	    <div align="center">
	    	<a href="index.php"><img class="mb-4" src="img/Rapiditologo.png" alt="" width="250" height="80"></a>
	    </div>
	    
	    <input type="text" id="name" class="form-control my-2" placeholder="Nombre" required autofocus>
	    <input type="text" id="last" class="form-control my-2" placeholder="Apellido" required autofocus>
	    <input type="email" id="email" class="form-control my-2" placeholder="Correo Electronico" required autofocus>
	    <?php
	    	include("class/class_connection.php");
	    	include("class/class_country.php");
	    	$conexion = new Connection();
	    	Country::mostrarPaises($conexion);
	    	$conexion->closeConnection();
	    ?>
	    <input type="text" id="phone" class="form-control my-2" placeholder="Telefono" required autofocus>
	    <input type="text" id="money" class="form-control my-2" placeholder="Monto Inicial ($)" required autofocus>
	    <input type="password" id="password" class="form-control" placeholder="Contraseña" required>
	    <input type="password" id="password2" class="form-control" placeholder="Confirmar Contraseña" required>
	    <button class="btn btn-lg btn-block btn-warning" id="btn-save" style="color: white;background-color: #f0c14b;">Crear cuenta</button>
	   <br>
	    <form action="index.php">
        <button class="btn btn-lg btn-block btn-warning" id="btn-save" style="color: white;background-color: #f0c14b;" type="submit">Regresar</button>
        </form>
	</div>
	
	<div id="response" class="alert alert-danger" style="display: none;"></div>
        
	
	<script src="js/jquery.min.js"></script>
	<script src="js/register-controller.js"></script>


</body>
</html>
