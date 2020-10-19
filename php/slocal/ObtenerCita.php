<?php

require_once "../../PDO.php";

$dato=$_POST['valorBusqueda'];

$ObtenerCita=$conexion->prepare("SELECT * from agenda_slocal WHERE ID=:dato");
$ObtenerCita -> bindParam(':dato',$dato);
$ObtenerCita -> execute();

$result = $ObtenerCita->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));


?>