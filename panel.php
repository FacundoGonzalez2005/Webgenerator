<?php  
	//iniciamos session
	session_start();

	include_once 'usuario.php';

	//Si la sessión no existe se redecciona al login
	if (!isset($_SESSION['id'])) {
		header("Location: login.php");
		exit();
	}

	$link = "";
	$msg = "";
	
	// Guardamos la session en una variable
	$id = $_SESSION['id'];

	// Si se aprienta el boton del formulario
	if (isset($_POST["btn_add"])) {
		//contatenamos la id con el dominio ingresado por el usuario
		$dominio = $_SESSION['id'].$_POST['text_dominio'];
		$result = "SELECT * FROM webs WHERE idUsuario = '$id' AND dominio = '$dominio'";

		// Ejecuta la query y lo gaurda en una variable
		$resultQuery = mysqli_query($con, $result);
		$fectchQuery = mysqli_fetch_all($resultQuery);
		
		// si no hay resultado entonces podemos agregar el usuario
		if(count($fectchQuery)==0){
			// Establece la zona horaria
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$fecha_actual = date('Y-m-d H:i:s');
			// inserta el nuevo usuarios
			$sql = "INSERT INTO webs (idUsuario,dominio,fechaCreacion) VALUES ('$id', '$dominio', '$fecha_actual')";
			// Ejecuta la query y lo gaurda en una variable
			$ress = mysqli_query($con, $sql);

			// mensaje de exito al agregar
			$msg = "<h3>Mensaje: dominio concatenado</h3>";

			$nombre = $_POST['text_dominio'];

			// shell_exec("cd ..");
			shell_exec(".././wix.sh $dominio $nombre");


			$link = "";
			$sqll = "SELECT `dominio` FROM webs WHERE idUsuario = '$id'";
			$resss = mysqli_query($con, $sqll);
			$fecth_dominio = mysqli_fetch_all($resss);

			foreach ($fecth_dominio as $key => $fila) {

				$link .= "<a href='http://mattprofe.com.ar:81/alumno/6916/ACTIVIDADES/CLASE_11/$fila[0]/'>$fila[0]</a> ";

				$link .= "<a href='descargar.php?dominio=" .urlencode($fila[0]). "'>Descargar web</a>";

				$link .= " <a href='eliminar.php?dominio=" .urlencode($fila[0]). "'>Eliminar</a><br><br>";
			}

		}else{
			// mensaje del email ya esta registrado
			$msg = "<h3>Mensaje: dominio ya existente</h3>";

			$link = "";
			$sqll = "SELECT `dominio` FROM webs WHERE idUsuario = '$id'";
			$resss = mysqli_query($con, $sqll);
			$fecth_dominio = mysqli_fetch_all($resss);

			foreach ($fecth_dominio as $key => $fila) {

				$link .= "<a href='http://mattprofe.com.ar:81/alumno/6916/ACTIVIDADES/CLASE_11/$fila[0]/'>$fila[0]</a> ";

				$link .= "<a href='descargar.php?dominio=" .urlencode($fila[0]). "'>Descargar web</a>";

				$link .= " <a href='eliminar.php?dominio=" .urlencode($fila[0]). "'>Eliminar</a><br><br>";
			}
		}
	}
	else{
		$link = "";
		$sqll = "SELECT `dominio` FROM webs WHERE idUsuario = '$id'";
		$resss = mysqli_query($con, $sqll);
		$fecth_dominio = mysqli_fetch_all($resss);

		if(count($fecth_dominio)==0){
			$link = "";
		}
		else{
			foreach ($fecth_dominio as $key => $fila) {
				$link .= "<a href='http://mattprofe.com.ar:81/alumno/6916/ACTIVIDADES/CLASE_11/$fila[0]/'>$fila[0]</a> ";

				$link .= "<a href='descargar.php?dominio=" .urlencode($fila[0]). "'>Descargar web</a>";

				$link .= " <a href='eliminar.php?dominio=" .urlencode($fila[0]). "'>Eliminar</a><br><br>";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel</title>
</head>
<body>
	<h1>Bienvenido a tu panel</h1>

	<h2><a href="logout.php">Cerrar sesion <?php echo $id; ?></a></h2><br>

	<form action="" method="POST">
		Generar Web de: <input type="text" placeholder="Ingresar nombre" name="text_dominio" required>
		<input type="submit" value="Crear web" name="btn_add"><br>
		<?php 	 
			echo $msg;
		?>
		<br>
	</form>

	<?php 
		echo $link;
	?>
</body>
</html>