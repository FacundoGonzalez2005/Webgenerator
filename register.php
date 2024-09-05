<?php 
	
	//wordpress - platillas/plugin y templetes

	session_start();

	include_once 'usuario.php';

	$ssql = "SELECT * FROM `usuarios`";

	$res = mysqli_query($con, $ssql);

	if (isset($_SESSION['id'])) {
		header("Location: panel.php");
		exit();
	}

	if (isset($_POST["btn_add"])) {

	 	$email = $_POST["txt_email"];

		// encripta la contraseña
		$pass = md5($_POST["txt_contrasena"]);
		$pass2 = md5($_POST["txt_contrasena2"]);

		if ($pass==$pass2) {
			// Averigua si el email ya esta en la tabla de usuarios
			$result = "SELECT * FROM usuarios WHERE email = '$email'";
			// Ejecuta la query y lo gaurda en una variable
			$resultQuery = mysqli_query($con, $result);
			$fectchQuery = mysqli_fetch_all($resultQuery);

			// si no hay resultado entonces podemos agregar el usuario
			if(count($fectchQuery)==0){
				// Establece la zona horaria
				date_default_timezone_set('America/Argentina/Buenos_Aires');
				$fecha_actual = date('Y-m-d');
				// inserta el nuevo usuarios
				$sql = "INSERT INTO usuarios (email, password, fechaRegistro) VALUES ('$email', '$pass', '$fecha_actual')";
				// Ejecuta la query y lo gaurda en una variable
				$ress = mysqli_query($con, $sql);

				// mensaje de exito al agregar
				$_SESSION['msg'] = "Usuario agregado";

				header("Location: login.php");
			}else{
				// mensaje del email ya esta registrado
				echo "Email ya registrado";
			}
		}
		else{
			echo "Las contraseñas no son identicas, volver a cargar";
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro</title>
</head>
<body>
	<h1>Registrarte es simple.</h1>
	<form action="" method="POST">
		<input type="text" placeholder="Ingrese email" name="txt_email" required>
		<input type="password" placeholder="Ingrese contraseña" name="txt_contrasena" required>
		<input type="password" placeholder="Ingrese de nuevo la contraseña" name="txt_contrasena2" required>
		<input type="submit" value="Ingresar" name="btn_add">
	</form>
</body>
</html>