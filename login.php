<?php 

	session_start();

	include_once 'usuario.php';

	if (isset($_SESSION['id'])) {
		header("Location: panel.php");
		exit();
	}

	if(isset($_SESSION['msg']) && $_SESSION['msg']!=""){
		echo $_SESSION['msg'];
	}

	$ssql = "SELECT * FROM `usuarios`";

	$res = mysqli_query($con, $ssql);

	if (isset($_POST["btn_add"])) {

		$email = $_POST["txt_email"];

		// encripta la contraseña con md5
		$pass = md5($_POST["txt_contrasena"]);

		// averigua si el email existe en la tabla de users
		$result = "SELECT * FROM usuarios WHERE email = '$email'";
		$resultQuery=mysqli_query($con,$result);
		$fectchQuery=mysqli_fetch_all($resultQuery);

		// si no hay filas
		if(count($fectchQuery)==0){
			echo "Email no registrado";
		}else{

			// si la contraseña no coincide
			if($fectchQuery[0][2]!=$pass){
				echo "Contraseña invalida";
			}else{
				// carga los atributos con los datos del usuario
				$email = $fectchQuery[0][1];
				$_SESSION['email']=$email;
				$id = $fectchQuery[0][0];
				$_SESSION['id'] = $id;
				// retorna un mensaje de logueo satisfactorio
				echo "Usuario logueado";

				header("Location: panel.php");
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>
<body>
	<h1>webgenerator Facundo Gonzalez</h1>
	<form action="" method="POST">
		<input type="text" placeholder="Ingrese email" name="txt_email" required>
		<input type="password" placeholder="Ingrese contraseña" name="txt_contrasena" required>
		<br><br>
		<a href="register.php">Registro</a>
		<br><br>
		<input type="submit" value="Ingresar" name="btn_add">
	</form>
</body>
</html>