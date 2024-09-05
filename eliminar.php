<?php 
	session_start();

	include_once 'usuario.php';

	if (!isset($_SESSION['id'])) {
		header("Location: login.php");
		exit();
	}

	// Verificar que se ha recibido el parámetro "dominio"
	if (isset($_GET['dominio'])) {
	    $dominio = $_GET['dominio'];
	    $idUsuario = $_SESSION['id'];

	   	$sql = "DELETE FROM webs WHERE idUsuario = '$idUsuario' AND dominio = '$dominio'";
	   	$resultQuery = mysqli_query($con, $sql);
	   	shell_exec("rm -r ../$dominio");
	}

	// Redirigir de vuelta al panel
	header("Location: panel.php");
	exit();
 ?>