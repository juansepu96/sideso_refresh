<?php 
require_once "PDO.php";

$asistencia=$_POST['valorBusqueda'];
$rta="";
        $ObtenerDni=$conexion->prepare("SELECT * from personas WHERE ID=:dni");
		$ObtenerDni->bindParam(':dni',$asistencia);
		$ObtenerDni->execute();

	foreach ($ObtenerDni as $DNI) {
        $rta=$DNI['dni'];
    break;
	}

    echo $rta;

?>