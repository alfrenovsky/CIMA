<?php 
$contrasena = "";
$usuario = "root";
$nombre_bd = "productos";
$dns = "mysql:host=localhost; dbname=".$nombre_bd;
try {
	$bd = new PDO (
		$dns,
		$usuario,
		$contrasena,
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
	);
} catch (Exception $e) {
	echo "Problema con la conexion: ".$e->getMessage();
}
?>