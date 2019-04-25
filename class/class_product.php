<?php
	
	class Product{

		private $idDepartment;
		private $name;
		private $description;
		private $price;
		private $discount;
		private $tax;
		private $photo;

		public function __construct($idDepartment,
					$name,
					$description,
					$price,
					$discount,
					$tax,
					$photo){
			$this->idDepartment = $idDepartment;
			$this->name = $name;
			$this->description = $description;
			$this->price = $price;
			$this->discount = $discount;
			$this->tax = $tax;
			$this->photo = $photo;
		}
		public function getIdDepartment(){
			return $this->idDepartment;
		}
		public function setIdDepartment($idDepartment){
			$this->idDepartment = $idDepartment;
		}
		public function getName(){
			return $this->name;
		}
		public function setName($name){
			$this->name = $name;
		}
		public function getDescription(){
			return $this->description;
		}
		public function setDescription($description){
			$this->description = $description;
		}
		public function getPrice(){
			return $this->price;
		}
		public function setPrice($price){
			$this->price = $price;
		}
		public function getDiscount(){
			return $this->discount;
		}
		public function setDiscount($discount){
			$this->discount = $discount;
		}
		public function getTax(){
			return $this->tax;
		}
		public function setTax($tax){
			$this->tax = $tax;
		}
		public function getPhoto(){
			return $this->photo;
		}
		public function setPhoto($photo){
			$this->photo = $photo;
		}

		public function agregarProducto($conexion,$cantidad,$usuario){
			$sql = sprintf(
				"INSERT INTO Producto(	num_depto_fk, txt_nombre,
										txt_descripcion, precio, descuento,
										impuesto, txt_foto) 
				VALUES('%s','%s','%s','%s','%s','%s','%s')",
				stripslashes($this->idDepartment),
				stripslashes($this->name),
				stripslashes($this->description),
				stripslashes($this->price),
				stripslashes($this->discount),
				stripslashes($this->tax),
				stripslashes($this->photo)
			);
			$result = $conexion->executeQuery($sql);
			if($result){
				$respuesta = array('status' => 200, 'data' => "Registro almacenado con exito!");
				//echo json_encode($respuesta);
			}else{
				$respuesta = array('status' => 500, 'data' => "Error al registrar!");
				echo json_encode($respuesta);
				exit;
			}

			$resultado = $conexion->executeQuery("SELECT last_insert_id() as id");
				$fila = $conexion->getRow($resultado);

				if ($fila["id"]>0){
					$sql = sprintf(
						"INSERT INTO Productos_X_Usuario(Usuario_num_usuario_fk, Producto_num_producto_fk, num_accion_fk, cantidad, total) 
						 VALUES ('%s','%s','%s','%s','%s')",
						stripslashes($usuario),
						stripslashes($fila["id"]),
						stripslashes(2),
						stripslashes($cantidad),
						stripslashes($cantidad*$this->price)
					);
					$r = $conexion->executeQuery($sql);
					if($r){
						$respuesta = array('status' => 200, 'data' => "Registro almacenado con exito!");
						echo json_encode($respuesta);
					}
				}
		}

		public static function mostrarProductosLogin($conexion){
			$result = $conexion->executeQuery("
				SELECT P.num_producto_pk, P.txt_nombre, P.txt_descripcion, P.precio, P.txt_foto, D.txt_nombre as depto 
				FROM Producto P
				INNER JOIN Departamento D 
				ON P.num_depto_fk = D.num_depto_pk");

			while($row = $conexion->getRow($result)){
			?>
				<div class="col-md-3 mt-5">
			    	<div class="card mt-4">
					    <img class="card-img-top" src="<?php echo $row['txt_foto'];?>" alt="Producto" name="producto">
					    <div class="card-body">
					    	<h4 class="card-title"><?php echo $row["txt_nombre"]; ?></h4>
					    	<div class="card-footer">
					      		<span>$ <?php echo number_format((float)$row['precio'], 2, '.', '');?></span>
					      	</div>
					    	
					    	<button role="button" type="button" name="btn<?php echo $row['num_producto_pk'];?>" id="btn<?php echo $row['num_producto_pk'];?>" class="btn btn-primary btn-md" data-toggle="modal" data-target="#exampleModalCenter<?php echo $row['num_producto_pk'];?>">
			      		<span class="glyphicon glyphicon-resize-full"></span>
			      	</button>
					
					<div class="modal fade" id="exampleModalCenter<?php echo $row['num_producto_pk'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title"><?php echo $row["txt_nombre"]; ?></h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div align="center">
					        	<img class="card-img-top img-responsive" alt="Producto" src="<?php echo $row['txt_foto'];?>" style="width: 55%;">
					        </div>

					        <div class="container">
							  
							  <div class="row">
							    <div class="col text-right">
							      <b>Nombre:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['txt_nombre'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Departamento:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['depto'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Descripción:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['txt_descripcion'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Precio:</b>
							    </div>
							    <div class="col text-left">
							      $ <?php echo number_format((float)$row['precio'], 2, '.', '');?>
							    </div>
							  </div>

							</div>

					      </div>
					    </div>
					  </div>
					</div>

			      	<button type="button" name="accept<?php echo $row['num_producto_pk'];?>" role="button" class="btn btn-success btn-md" id="accept<?php echo $row['num_producto_pk'];?>" data-toggle="modal" data-target="#login<?php echo $row['num_producto_pk'];?>">
			      		<span class="glyphicon glyphicon-ok"></span>
			      	</button>

			      	<div class="modal fade" id="login<?php echo $row['num_producto_pk'];?>" tabindex="-1" role="dialog" aria-labelledby="loginTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body text-center">
					      	<img src="img/Rapiditologo.png" width="150" height="50" alt="Logo" class="my-2">
					        <h6>En necesario iniciar sesión!</h6>
					      </div>
					    </div>
					  </div>
					</div>

			      	<button type="button" role="button" name="remove<?php echo $row['num_producto_pk'];?>" class="btn btn-danger btn-md" id="remove<?php echo $row['num_producto_pk'];?>" style="visibility: hidden;">
			      		<span class="glyphicon glyphicon-remove"></span>
			      	</button>

					    </div>
					</div>
			    </div>

			<?php

				}	
			
		}

		public static function mostrarProductosLogin2($conexion){
			$result = $conexion->executeQuery("
				SELECT P.num_producto_pk, P.txt_nombre, P.txt_descripcion, P.precio, P.txt_foto, D.txt_nombre as depto 
				FROM Producto P
				INNER JOIN Departamento D 
				ON P.num_depto_fk = D.num_depto_pk");

			while($row = $conexion->getRow($result)){
			?>
				<div class="col-md-3 mt-5">
			    	<div class="card mt-4">
					    <img class="card-img-top" src="<?php echo $row['txt_foto'];?>" alt="Producto" name="producto">
					    <div class="card-body">
					    	<h4 class="card-title"><?php echo $row["txt_nombre"]; ?></h4>
					    	<div class="card-footer">
					      		<span>$ <?php echo number_format((float)$row['precio'], 2, '.', '');?></span>
					      	</div>
					    	
					    	<button role="button" type="button" name="btn<?php echo $row['num_producto_pk'];?>" id="btn<?php echo $row['num_producto_pk'];?>" class="btn btn-primary btn-md" data-toggle="modal" data-target="#exampleModalCenter<?php echo $row['num_producto_pk'];?>">
			      		<span class="glyphicon glyphicon-resize-full"></span>
			      	</button>
					
					<div class="modal fade" id="exampleModalCenter<?php echo $row['num_producto_pk'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title"><?php echo $row["txt_nombre"]; ?></h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div align="center">
					        	<img class="card-img-top img-responsive" alt="Producto" src="<?php echo $row['txt_foto'];?>" style="width: 55%;">
					        </div>

					        <div class="container">
							  
							  <div class="row">
							    <div class="col text-right">
							      <b>Nombre:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['txt_nombre'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Departamento:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['depto'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Descripción:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['txt_descripcion'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Precio:</b>
							    </div>
							    <div class="col text-left">
							      $ <?php echo number_format((float)$row['precio'], 2, '.', '');?>
							    </div>
							  </div>

							</div>

					      </div>
					    </div>
					  </div>
					</div>

			      	<button type="button" name="accept<?php echo $row['num_producto_pk'];?>" role="button" class="btn btn-success btn-md" id="accept<?php echo $row['num_producto_pk'];?>" data-toggle="modal" data-target="#login<?php echo $row['num_producto_pk'];?>">
			      		<span class="glyphicon glyphicon-ok"></span>
			      	</button>

			      	<button type="button" role="button" name="remove<?php echo $row['num_producto_pk'];?>" class="btn btn-danger btn-md" id="remove<?php echo $row['num_producto_pk'];?>" style="visibility: hidden;">
			      		<span class="glyphicon glyphicon-remove"></span>
			      	</button>

					    </div>
					</div>
			    </div>

			<?php

				}	
			
		}

		public static function mostrarProductos($conexion,$id){
			$result = $conexion->executeQuery("
				SELECT P.num_producto_pk, P.txt_nombre, P.txt_descripcion, P.precio, P.txt_foto, D.txt_nombre as depto 
				FROM Producto P
				INNER JOIN Departamento D 
				ON P.num_depto_fk = D.num_depto_pk
				WHERE P.num_depto_fk = $id");

			while($row = $conexion->getRow($result)){
			?>
				<div class="col-md-3 mt-5">
			    	<div class="card mt-4">
					    <img class="card-img-top" src="<?php echo $row['txt_foto'];?>" alt="Producto" name="producto">
					    <div class="card-body">
					    	<h4 class="card-title"><?php echo $row["txt_nombre"]; ?></h4>
					    	<div class="card-footer">
					      		<span>$ <?php echo number_format((float)$row['precio'], 2, '.', '');?></span>
					      	</div>
					    	
					    	<button role="button" type="button" name="btn<?php echo $row['num_producto_pk'];?>" id="btn<?php echo $row['num_producto_pk'];?>" class="btn btn-primary btn-md" data-toggle="modal" data-target="#exampleModalCenter<?php echo $row['num_producto_pk'];?>">
			      		<span class="glyphicon glyphicon-resize-full"></span>
			      	</button>
					
					<div class="modal fade" id="exampleModalCenter<?php echo $row['num_producto_pk'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title"><?php echo $row["txt_nombre"]; ?></h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div align="center">
					        	<img class="card-img-top img-responsive" alt="Producto" src="<?php echo $row['txt_foto'];?>" style="width: 55%;">
					        </div>

					        <div class="container">
							  
							  <div class="row">
							    <div class="col text-right">
							      <b>Nombre:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['txt_nombre'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Departamento:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['depto'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Descripción:</b>
							    </div>
							    <div class="col text-left">
							      <?php echo $row['txt_descripcion'];?>
							    </div>
							  </div>

							  <div class="row">
							    <div class="col text-right">
							      <b>Precio:</b>
							    </div>
							    <div class="col text-left">
							      $ <?php echo number_format((float)$row['precio'], 2, '.', '');?>
							    </div>
							  </div>

							</div>

					      </div>
					    </div>
					  </div>
					</div>

			      	<button type="button" name="accept<?php echo $row['num_producto_pk'];?>" role="button" class="btn btn-success btn-md" id="accept<?php echo $row['num_producto_pk'];?>">
			      		<span class="glyphicon glyphicon-ok"></span>
			      	</button>

			      	<button type="button" role="button" name="remove<?php echo $row['num_producto_pk'];?>" class="btn btn-danger btn-md" id="remove<?php echo $row['num_producto_pk'];?>" style="visibility: hidden;">
			      		<span class="glyphicon glyphicon-remove"></span>
			      	</button>

					    </div>
					</div>
			    </div>

			<?php

				}	
			
		}

		public static function productosComprados($conexion,$usuario){
			$sql = sprintf(
				"SELECT P.txt_nombre, P.txt_foto, P.precio, PU.cantidad, PU.total, (P.descuento)*100 as descuento
				 FROM Productos_X_Usuario PU 
				 INNER JOIN Producto P 
				 ON PU.Producto_num_producto_fk = P.num_producto_pk 
				 INNER JOIN Usuario U 
				 ON PU.Usuario_num_usuario_fk = U.num_usuario_pk 
				 WHERE PU.num_accion_fk = 1 AND U.num_usuario_pk = '%s'",stripslashes($usuario));

			$result = $conexion->executeQuery($sql);
			while($row = $conexion->getRow($result)){
			?>
				<div class="col-md-5">
	              <div class="card">
	                <img class="card-img-top" src="<?php echo $row['txt_foto'];?>">
	                <div class="card-body">
	                  <h5 class="card-title"><?php echo $row["txt_nombre"];?></h5>
	                  <span><b>Cantidad:</b> <?php echo $row["cantidad"];?></span><br>
	                  <span><b>Precio:</b> $ <?php echo $row["precio"]*$row["cantidad"];?></span><br>
	                  <span><b>Descuento:</b> <?php echo number_format((float)$row['descuento'], 0, '.', '');?>%</span><br>
	                </div>
	                <div class="card-footer text-center">
	                   <?php  
	                		$descuento = $row["total"]*($row['descuento']/100);

	                	?>
	                   <span><b>Total: </b>$<?php echo round($row["total"]-$descuento);?></span>
	                </div>
	              </div>
	            </div>
			<?php	
			}
		}

		public static function productosVendidos($conexion,$usuario){
			$sql = sprintf(
				"SELECT P.txt_nombre, P.txt_foto, P.precio, PU.cantidad, PU.total, (P.descuento)*100 as descuento 
				 FROM Productos_X_Usuario PU 
				 INNER JOIN Producto P 
				 ON PU.Producto_num_producto_fk = P.num_producto_pk 
				 INNER JOIN Usuario U 
				 ON PU.Usuario_num_usuario_fk = U.num_usuario_pk 
				 WHERE PU.num_accion_fk = 2 AND U.num_usuario_pk = '%s'",stripslashes($usuario));

			$result = $conexion->executeQuery($sql);
			while($row = $conexion->getRow($result)){
			?>
				<div class="col-md-5">
	              <div class="card">
	                <img class="card-img-top" src="<?php echo $row['txt_foto'];?>">
	                <div class="card-body">
	                  <h5 class="card-title"><?php echo $row["txt_nombre"];?></h5>
	                  <span><b>Cantidad:</b> <?php echo $row["cantidad"];?></span><br>
	                  <span><b>Precio:</b> $ <?php echo $row["precio"]*$row["cantidad"];?></span><br>
	                  <span><b>Descuento:</b> <?php echo number_format((float)$row['descuento'], 0, '.', '');?>%</span><br>
	                </div>
	                <div class="card-footer text-center">
	                	<?php  
	                		$descuento = $row["total"]*($row['descuento']/100);

	                	?>
	                   <span><b>Total: </b>$<?php echo round($row["total"]-$descuento);?></span>
	                </div>
	              </div>
	            </div>

			<?php	
			}
		}

	}
?>