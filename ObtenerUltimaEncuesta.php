<?php 
require_once "PDO.php";

$asistencia=$_POST['valorBusqueda'];
$rta="";
        $ObtenerDni=$conexion->prepare("SELECT * from encuestas WHERE dni_titular=:dni ORDER BY anio DESC");
		$ObtenerDni->bindParam(':dni',$asistencia);
		$ObtenerDni->execute();

	foreach ($ObtenerDni as $DNI) {
        $rta=$DNI['anio'];
        break;
	}

    echo $rta;

?>