<?php 
require_once "PDO.php";

$asistencia=$_POST['valorBusqueda'];
$rta="";
$AbrirAsistencia=$conexion->prepare("SELECT * FROM asistencias WHERE ID=:aeditar");
$AbrirAsistencia->bindParam(':aeditar',$asistencia);
$AbrirAsistencia->execute();

	foreach ($AbrirAsistencia as $Asis) {
        $id_persona=$Asis['dni'];
		$tipo=$Asis['tipo'];
		$monto=$Asis['monto'];
        $estado=$Asis['estado'];
        $fecha=$Asis['fecha'];
		$observaciones=$Asis['observacion'];
		$rta=$tipo."@#".$monto."@#".$estado."@#".$observaciones."@#".$fecha."@#".$id_persona;
	}

    echo $rta;

?>