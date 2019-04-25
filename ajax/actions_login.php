<?php
	
	session_start(); 
	switch ($_GET["action"]){
		//Verificamos si existe el usuario
		case 'verify':
			
			include("../class/class_connection.php");
			include("../class/class_user.php");

			$conexion = new Connection();
			$respuesta = User::verificarUsuario($conexion, $_POST["email"], $_POST["password"]);
			$_SESSION["userCode"] = $respuesta["userCode"];
			$_SESSION["userName"] = $respuesta["userName"];
			$_SESSION["lastName"] = $respuesta["lastName"];
			$_SESSION["email"] = $respuesta["email"];
			$_SESSION["country"] = $respuesta["country"];
			$_SESSION["phone"] = $respuesta["phone"];
			$_SESSION["date_in"] = $respuesta["date_in"];
			$_SESSION["cash"] = $respuesta["cash"];
			$_SESSION["photo"] = $respuesta["photo"];

			echo json_encode($respuesta);

			break;

		case 'save':
			include("../class/class_connection.php");
			include("../class/class_user.php");

			$conexion = new Connection();
			$user = new User(
						$_POST["country"],
						$_POST["name"],
						$_POST["last"],
						$_POST["email"],
						$_POST["password"],
						$_POST["phone"],
						date("Y-m-d H:i:s"),
						$_POST["money"]
					);
			$user->guardarRegistro($conexion);
			$conexion->closeConnection();
		break;

		default:
			echo "Accion invalida";
			break;
	}
?>