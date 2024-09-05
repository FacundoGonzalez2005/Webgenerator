<?php 
	//iniciamos sessión
	session_start();

	// limpia las variables de la sesión
	session_unset();

	// destruye toda la información asociada con la sesión actual.
	session_destroy();

	// redirecciona a la landind
	header("Location: login.php");
	exit();
 ?>