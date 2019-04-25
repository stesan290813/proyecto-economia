<?php
	
	class Department{

		private $name;
		private $description;
		
		public function __construct($name, $description){
			$this->name = $name;
			$this->description = $description;	
		}

		public static function mostrarDepartamentos($conexion){
			$result = $conexion->executeQuery(
				"SELECT num_depto_pk, txt_nombre FROM Departamento");
			echo '<select id="slc-depto" name="slc-depto" class="form-control">';
			echo '<option value="" selected disabled hidden>Departamentos</option>';
			while($row = $conexion->getRow($result)){
				echo '<option value="'.$row["num_depto_pk"].'">'.
				utf8_encode($row["txt_nombre"]).'</option>';
			}
			echo '</select>';
		}

	}

?>