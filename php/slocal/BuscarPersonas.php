<?php

require_once "../../PDO.php";

$dato=$_POST['valorBusqueda'];
$dato='%'.$dato.'%';

$ObtenerPersonas = $conexion -> prepare (" SELECT * FROM personas_slocal WHERE (nombre LIKE :dato) OR (DNI LIKE :dato) ORDER BY nombre ASC");
$ObtenerPersonas -> bindParam(':dato',$dato);
$ObtenerPersonas -> execute();

$result = $ObtenerPersonas->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>