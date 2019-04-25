<?php 
  session_start(); 
  if(!isset($_SESSION['userCode']))
    header("Location: index.php");
?>
<!doctype html>
<html lang="es">
<head>
	<title>Agregar Producto - Rapidito</title>
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

<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="menu.php">
      <img src="img/Rapiditologo.png" width="150" height="50" alt="Logo" style="margin-top: 10%;">
    </a>

    <button class="navbar-toggler btn btn-warning" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span id="count">0</span>
      <span class="glyphicon glyphicon-shopping-cart"></span>
    </button>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item my-2 mx-2">
          	<div class="dropdown">
          		<a class="nav-link dropdown" href="#">Cuenta</a>
      			  	<div class="dropdown-content">
      			    	<a href="profile.php">Mi cuenta</a>
      			    	<a href="orders.php">Mis pedidos</a>
      			    	<a href="products.php">Mis productos</a>
      			    	<a href="logout.php">Salir</a>
      			  	</div>
      			</div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="form-signin mt-5" style="margin-top: 5%;">
    <div align="center" class="mt-5">
    	<a href="index.php" aria-label="Login"><img class="mb-4" src="img/bag.svg" alt="" width="250" height="150"></a>
    </div>
    
    <?php
    	include("class/class_connection.php");
    	include("class/class_department.php");
    	$conexion = new Connection();
    	Department::mostrarDepartamentos($conexion);
    	$conexion->closeConnection();
    ?>
    <input type="text" id="name" class="form-control my-2" placeholder="Nombre" required autofocus>
    <input type="text" id="description" class="form-control my-2" placeholder="Descripción" required autofocus>
    <input type="text" id="price" class="form-control my-2" placeholder="Precio $" required autofocus>
    <input type="number" id="cant" class="form-control my-2" placeholder="Cantidad" required autofocus>
    <input type="text" id="discount" class="form-control my-2" placeholder="Descuento (%)" required autofocus>
    <input type="text" id="tax" class="form-control my-2" placeholder="Impuesto (%)" required autofocus>
    
    <form method="post" id="formulario" enctype="multipart/form-data">
    	<input type="file" name="file" id="file" class="form-control my-2">
	</form>
		    
    <button class="btn btn-lg btn-block btn-info" id="btn-save" style="color: white;background-color: #146eb4;">Agregar Producto</button>

    <div id="respuesta" class="text-center my-2 alert alert-success" style="display: none;"></div>	
	<div id="respuesta2" class="text-center alert alert-danger" style="display: none;"></div>

</div>
        
	
	<script src="js/jquery.min.js"></script>
	<script src="js/product-controller.js"></script>

</body>
</html>
