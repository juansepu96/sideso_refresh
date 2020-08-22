<?php

require_once "../PDO.php";

$datos=$_POST['valorBusqueda'];
$datos=json_decode($datos);

$intervino = $_SESSION['nombre'];

$InsertarIntervencion = $conexion -> prepare ("INSERT into intervenciones (persona_ID,fecha,detalle,intervino) VALUES (:persona_ID,:fecha,:detalle,:intervino)");
$InsertarIntervencion -> bindParam(':persona_ID',$datos[2]);
$InsertarIntervencion -> bindParam(':fecha',$datos[0]);
$InsertarIntervencion -> bindParam(':detalle',$datos[1]);
$InsertarIntervencion -> bindParam(':intervino',$intervino);

$InsertarIntervencion -> execute();



?>