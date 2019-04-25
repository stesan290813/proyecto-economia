<?php 
  session_start(); 
  if(!isset($_SESSION['userCode']))
    header("Location: index.php");
?>
<!doctype html>
<html>
<head>
	<title>Productos - Rapidito</title>
	<meta charset="utf-8">
	<meta name="author" content="Grupo Rapidito">
  <meta name="description" content="Proyecto Final - Sistemas Exeprtos">
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
      <span id="count"><?php echo count($_SESSION["products"]);?></span>
      <span class="glyphicon glyphicon-shopping-cart"></span>
    </button>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item my-2 mx-2">
            <a class="nav-link" href="add_product.php">Agregar Producto</a>
        </li>
        <li class="nav-item my-2 mx-2">
          	<div class="dropdown">
          		<a class="nav-link dropdown" href="#">Cuenta <?php echo $_SESSION["userName"]." ".$_SESSION["lastName"];?></a>
      			  	<div class="dropdown-content">
                  <a href="menu.php">Inicio</a>
      			    	<a href="profile.php">Mi cuenta</a>
      			    	<a href="orders.php">Mis pedidos</a>
      			    	<a href="products.php">Mis productos</a>
      			    	<a href="logout.php">Salir</a>
      			  	</div>
      			</div>
        </li>
        <li class="nav-item my-2 mx-2">
          	<button type="button" class="btn btn-warning btn-md">
      			<span><?php //echo count($_SESSION["products"]);?></span>
      			<span class="glyphicon glyphicon-shopping-cart"></span>
      		</button>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-5">
  <div class="row">
    <div class="col mt-5" style="border-right: #ff9900 2px solid;">
      <h4 align="center" style="color: #146eb4;">Productos Comprados</h4>
      <div class="container">
        <div class="row">       
  
          <?php
            include("class/class_connection.php");
            include("class/class_product.php");
            $conexion = new Connection();
            Product::productosComprados($conexion,$_SESSION['userCode']);
            $conexion->closeConnection();
          ?>        
  
        </div>
      </div>
    </div>
    
    <!--Productos en venta-->
   <!-- <div class="col mt-5" style="border-left: #ff9900 2px solid;">
      <h4 align="center" style="color: #146eb4;">Productos en venta</h4>
      <div class="container">
        <div class="row">

          <?php
            
            $conexion = new Connection();
            Product::productosVendidos($conexion,$_SESSION['userCode']);
            $conexion->closeConnection();
          ?> 

        </div>
      </div>
    </div>
  </div>  
</div>
 -->       
	
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>


</body>
</html>