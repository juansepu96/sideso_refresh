<?php 
require_once "PDO.php";

$asistencia=$_POST['valorBusqueda'];
$rta="";
        $ObtenerDni=$conexion->prepare("SELECT * from encuestas WHERE dni_titular=:dni ORDER BY ID DESC");
		$ObtenerDni->bindParam(':dni',$asistencia);
		$ObtenerDni->execute();

	foreach ($ObtenerDni as $DNI) {
        $fecha= strtotime($DNI['fecha']);
        $anio=date("Y",$fecha);

        $rta=$anio;
        break;
	}

    echo $rta;

?>