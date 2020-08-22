<?php

require_once "../PDO.php";

$dato=$_POST['valorBusqueda'];

$ObtenerIntervenciones=$conexion->prepare("SELECT * from intervenciones WHERE persona_ID=:dato ORDER BY fecha DESC");
$ObtenerIntervenciones -> bindParam(':dato',$dato);
$ObtenerIntervenciones -> execute();

$result = $ObtenerIntervenciones->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));


?>