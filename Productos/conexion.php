<?php 
$contrasena = $_SERVER["MYSQL_PASSWORD"];
$usuario = $_SERVER["MYSQL_USER"];
$nombre_bd = $_SERVER["MYSQL_DATABASE"];
$dns = "mysql:host=".$_SERVER["MYSQL_HOST"]."; dbname=".$nombre_bd;
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
