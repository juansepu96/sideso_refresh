<?php

require_once "../../PDO.php";

$dato=$_POST['valorBusqueda'];
$dato=json_decode($dato,true);

$ObtenerIntervenciones=$conexion->prepare("SELECT * from intervenciones_slocal WHERE fecha BETWEEN :fecha1 AND :fecha2");
$ObtenerIntervenciones -> bindParam(':fecha1',$dato[0]);
$ObtenerIntervenciones -> bindParam(':fecha2',$dato[1]);
$ObtenerIntervenciones->execute();
$result = $ObtenerIntervenciones->fetchAll(\PDO::FETCH_ASSOC);
print_r (json_encode($result));    



?>