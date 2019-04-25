<!DOCTYPE html>
<html>
<head>
	<title>Tienda en linea - Proyecto Final</title>
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
      <img src="img/Rapiditologo.png" width="200" height="65" alt="Logo" style="margin-top: 10%;">
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
        <li class="nav-item active form-inline my-2">
		      <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" id="product">
		      <button type="button" class="btn btn-warning btn-md" id="search" data-toggle="modal" data-target="#modalSearch">
            <span class="glyphicon glyphicon-search"></span>
            </button>
        </li>
        <li class="nav-item my-2 mx-2">
          	<?php
          		include("class/class_connection.php");
          		include("class/class_department.php");
          		$conexion = new Connection();
          		Department::mostrarDepartamentos($conexion);
          		$conexion->closeConnection();
          	?>
        </li>
        <li class="nav-item my-2 mx-2">
          	<div class="dropdown">
          		<?php 
					session_start(); 
					if(isset($_SESSION['userCode'])){
						echo '
							<a class="nav-link dropdown" href="#">'.
								$_SESSION['userName']." ".$_SESSION['lastName'].
							'</a>
			  				<div class="dropdown-content">
                  <a href="menu.php">Inicio</a>
			    				<a href="profile.php">Mi cuenta</a>
			    				<a href="orders.php">Mis Pedidos</a>
			    				<a href="products.php">Mis Productos</a>
			    				<a href="logout.php">Salir</a>
			  				</div>';
					}else{
						header("Location: index.php");
					}
						
				?>
			</div>
        </li>
        <li class="nav-item my-2 mx-2">
          	<button type="button" class="btn btn-warning btn-md">
      			<span id="count2"><?php //echo count($_SESSION["products"]);?></span>
      			<span class="glyphicon glyphicon-shopping-cart"></span>
      		</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="modal fade" id="modalSearch" tabindex="-1" role="dialog" aria-labelledby="modalSearchTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nombre</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div align="center">
              <img class="card-img-top img-responsive" alt="Producto" style="width: 55%;" id="photo">
          </div>

          <div class="container">
            
            <div class="row">
              <div class="col text-right">
                <b>Nombre:</b>
              </div>
              <div class="col text-left" id="name">
                Nombre
              </div>
            </div>

            <div class="row">
              <div class="col text-right">
                <b>Departamento:</b>
              </div>
              <div class="col text-left" id="depto">
                Depto
              </div>
            </div>

            <div class="row">
              <div class="col text-right">
                <b>Descripción:</b>
              </div>
              <div class="col text-left" id="description">
                Descripcion
              </div>
            </div>

            <div class="row">
              <div class="col text-right">
                <b>Precio:</b>
              </div>
              <div class="col text-left" id="price">
                $ 45.00
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

<div class="container mt-5">
	<div class="row">
		<?php

			include("class/class_product.php");
			$conexion = new Connection();
  		Product::mostrarProductosLogin2($conexion);
  		$conexion->closeConnection();
      
		?>
	</div>
</div>	


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/main-controller.js"></script>

</body>
</html>