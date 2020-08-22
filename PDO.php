<?php

session_start();


if(htmlspecialchars($_SERVER['PHP_SELF']) != "/desarrollo/refresh_desarrollo/index.php"){
	if(!isset($_SESSION['usuario'])){
		echo '<script>location.href="index.php";</script>';
	}
}


date_default_timezone_set('America/Argentina/Buenos_Aires');

$date=date("Y-m-d");
$time=date("H:i:s");

try {
	$conexion = new PDO('mysql:host=localhost;dbname=dsocial','root','');


}catch(PDOException $e){
		echo "Error" . $e->getMessage();

}

?>
