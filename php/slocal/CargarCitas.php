<?php

require_once "../../PDO.php";

$datos=$_POST['valorBusqueda'];

$GetCitas=$conexion->prepare("SELECT * from agenda_slocal WHERE date=:fecha");
$GetCitas -> bindParam(':fecha',$datos);
$GetCitas -> execute();

$result = $GetCitas->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>