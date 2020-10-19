<?php

require_once "../../PDO.php";

$datos=$_POST['valorBusqueda'];
$datos=json_decode($datos,true);

$persona= $_SESSION['nombre'];

$NuevaCita = $conexion -> prepare (" INSERT INTO agenda_slocal (date,time,detail,intervino,description) VALUES (:date,:time,:detail,:intervino,:description)");
$NuevaCita -> bindParam(':date',$datos[0]);
$NuevaCita -> bindParam(':time',$datos[1]);
$NuevaCita -> bindParam(':detail',$datos[3]);
$NuevaCita -> bindParam(':intervino',$persona);
$NuevaCita -> bindParam(':description',$datos[2]);
$NuevaCita -> execute();


?>