<?php
	
	class Country{
		
		private $name;

		public function __construct($name){
			$this->name = $name;
		}

		public static function mostrarPaises($conexion){
			$result = $conexion->executeQuery("SELECT num_pais_pk, txt_nombre From Pais");

			echo '<select class="form-control my-2" id="country">';
			while($row = $conexion->getRow($result)){
				echo '<option value="'.$row["num_pais_pk"].'">'.
					str_replace("?", "ñ", utf8_decode($row["txt_nombre"])).'</option>';
			}
			echo '</select>';
		}
	}

?>