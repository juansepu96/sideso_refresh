<?php 
require_once "PDO.php";

$asistencia=$_POST['valorBusqueda'];
$rta="";
        $ObtenerListadoEncuestas=$conexion->prepare("SELECT * from encuestas WHERE dni_titular=:dni");
		$ObtenerListadoEncuestas->bindParam(':dni',$asistencia);
		$ObtenerListadoEncuestas->execute();

	foreach ($ObtenerListadoEncuestas as $Encuesta) {
        $id=$Encuesta['ID'];
        $timestamp = strtotime($Encuesta['fecha']);
        $fecha = date("d/m/Y", $timestamp);
        $anio=$Encuesta['anio'];
        $rta=$rta."@#".$id."@#".$fecha."@#".$anio."@#";
	}

    echo $rta;

?>