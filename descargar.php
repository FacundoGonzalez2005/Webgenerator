<?php 
	$dominio = $_GET['dominio'];

	shell_exec("zip -r '../$dominio.zip' '../$dominio'");

	header("Location: ../$dominio.zip");
?>