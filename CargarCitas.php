<?php

require_once "../PDO.php";

$datos=$_POST['valorBusqueda'];

$ObtenerCitas = $conexion -> prepare (" SELECT * FROM agenda WHERE date=:fecha ORDER BY time ASC");
$ObtenerCitas -> bindParam(':fecha',$datos);
$ObtenerCitas -> execute();
$result = $ObtenerCitas->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>