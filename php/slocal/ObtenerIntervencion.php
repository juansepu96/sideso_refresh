<?php

require_once "../../PDO.php";

$dato=$_POST['valorBusqueda'];

$ObtenerIntervenciones=$conexion->prepare("SELECT * from intervenciones_slocal WHERE ID=:id");
$ObtenerIntervenciones -> bindParam(':id',$dato);
$ObtenerIntervenciones->execute();
$result = $ObtenerIntervenciones->fetchAll(\PDO::FETCH_ASSOC);
print_r (json_encode($result));    



?>