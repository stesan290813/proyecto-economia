<?php 
  session_start(); 
  if(!isset($_SESSION['userCode']))
    header("Location: index.php");
?>
<!doctype html>
<html>
<head>
	<title>Pedidos - Rapidito</title>
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
      <img src="img/Rapiditologo.png" width="200" height="65" alt="RapiditoLogo" style="margin-top: 10%;">
    </a>

    <button class="navbar-toggler btn btn-warning" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span id="count"><?php //echo count($_SESSION["products"]);?></span>
      <span class="glyphicon glyphicon-shopping-cart"></span>
    </button>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
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
        <div class="col align-self-center mt-5" align="center">
            <div class="col-md-10 col-sm-4 mt-3" align="center">
                <img src="img/list.svg" class="img-responsive" width="150" height="150">
            </div>
            <div class="col-md-4 col-sm-4 mt-3" align="center">
                <h6><b>Saldo Disponible:</b> $ <?php echo $_SESSION["cash"];?></h6>
            </div>
            <div class="col-md-8" align="center" id="respuesta">
                
                  
            </div >
            <form action="products.php">
            <button type="submit" class="btn btn-success btn-md" id="btn-buy">
              Realizar compra
            </button>
            </form>
        </div>
    </div>
</div>      
<br><br>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/orders-controller.js"></script>


</body>
</html>