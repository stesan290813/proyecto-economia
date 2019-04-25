<?php
	
	class User{

		private $idCountry;
		private $name;
		private $lastName;
		private $email;
		private $password;
		private $phone;
		private $creationDate;
		private $money;

		public function __construct($idCountry,$name,$lastName,$email,$password,$phone,$creationDate,$money){
			$this->idCountry = $idCountry;
			$this->name = $name;
			$this->lastName = $lastName;
			$this->email = $email;
			$this->password = $password;
			$this->phone = $phone;
			$this->creationDate = $creationDate;
			$this->money = $money;
		}
		
		public function getName(){
			return $this->name;
		}
		public function setName($name){
			$this->name = $name;
		}
		public function getLastName(){
			return $this->lastName;
		}
		public function setLastName($lastName){
			$this->lastName = $lastName;
		}
		public function getEmail(){
			return $this->email;
		}
		public function setEmail($email){
			$this->email = $email;
		}
		public function getPassword(){
			return $this->password;
		}
		public function setPassword($password){
			$this->password = $password;
		}
			
		public static function verificarUsuario($conexion, $email, $password){
			$resultado = $conexion->executeQuery(
				sprintf("
					SELECT 	U.num_usuario_pk as userCode, U.txt_nombre as userName, 
							U.txt_apellido as lastName, U.txt_email as email, 
							U.txt_password as password, P.txt_nombre as country,
							U.txt_telefono as phone, U.fecha_creacion as date_in, 
							U.monto_disponible as cash, U.txt_foto as photo 
					FROM Usuario U 
					INNER JOIN Pais P 
					ON U.num_pais_fk = P.num_pais_pk
					WHERE txt_email = '%s' 
					AND txt_password = sha1('%s')",
					stripslashes($email),
					stripslashes($password)
			));
			$respuesta = array();

			if($conexion->countRegisters($resultado) >0){
				$fila = $conexion->getRow($resultado);
				$respuesta["codigo_resultado"] = 1;
				$respuesta["resultado"] = "exists";
				$respuesta["userCode"] = $fila["userCode"];
				$respuesta["email"] = $fila["email"];
				$respuesta["userName"] = $fila["userName"];
				$respuesta["lastName"] = $fila["lastName"];
				$respuesta["country"] = $fila["country"];
				$respuesta["phone"] = $fila["phone"];
				$respuesta["date_in"] = $fila["date_in"];
				$respuesta["cash"] = $fila["cash"];
				$respuesta["photo"] = $fila["photo"];
			}
			else {
				$respuesta["codigo_resultado"] = 0;
				$respuesta["resultado"] = "Usuario no Existe";
				//echo "<script type="text/javascript">alert("Usuario no Existe");</script>";
			}
			return $respuesta;

		}

		public function guardarRegistro($conexion){
			$sql = sprintf(
				"INSERT INTO Usuario 
						(num_pais_fk, txt_nombre, txt_apellido, txt_email, txt_password, txt_telefono, fecha_creacion, monto_disponible,txt_foto) 
						VALUES ('%s','%s', '%s', '%s', sha1('%s'), '%s', '%s', '%s','%s')",
						stripslashes($this->idCountry),
						stripslashes($this->name),
						stripslashes($this->lastName),
						stripslashes($this->email),
						stripslashes($this->password),
						stripslashes($this->phone),
						stripslashes($this->creationDate),
						stripslashes($this->money),
						stripslashes('img/user.svg')
				);
			$resultado = $conexion->executeQuery($sql);
			if($resultado){
				echo "success";
			}else{
				echo "Error al guardar el registro";
				exit;
			}		
		}

	}
?>