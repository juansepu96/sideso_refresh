<?php

require_once "../PDO.php";

$dato=$_POST['valorBusqueda'];

$ObtenerDatosPersona=$conexion->prepare("SELECT * from personas_mujeres WHERE ID=:dato");
$ObtenerDatosPersona -> bindParam(':dato',$dato);
$ObtenerDatosPersona -> execute();

$result = $ObtenerDatosPersona->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));


?>