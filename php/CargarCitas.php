<?php

require_once "../PDO.php";

$datos=$_POST['valorBusqueda'];
$datos=json_decode($datos);

$GetCitas=$conexion->query("SELECT * from agenda");
$GetCitas -> bindParam(':fecha',$datos);
$GetCitas -> execute();

$result = $GetCitas->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>