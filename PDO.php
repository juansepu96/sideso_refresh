<?php

session_start();


date_default_timezone_set('America/Argentina/Buenos_Aires');

$date=date("Y-m-d");
$time=date("H:i:s");

try {
	$conexion = new PDO('mysql:host=localhost;dbname=dsocial;charset=utf8','root','');
}catch(PDOException $e){
		echo "Error" . $e->getMessage();

}

?>
