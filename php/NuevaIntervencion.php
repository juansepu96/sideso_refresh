<?php

require_once "../PDO.php";

$datos=$_POST['valorBusqueda'];
$datos=json_decode($datos);

$intervino = $_SESSION['nombre'];

$InsertarIntervencion = $conexion -> prepare ("INSERT INTO intervenciones (persona_ID,fecha,detalle,intervino) VALUES (:persona_ID,:fecha,:detalle,:intervino)");
$InsertarIntervencion -> bindParam(':persona_ID',$datos[2]);
$InsertarIntervencion -> bindParam(':fecha',$datos[0]);
$InsertarIntervencion -> bindParam(':detalle',$datos[1]);
$InsertarIntervencion -> bindParam(':intervino',$intervino);
$InsertarIntervencion -> execute();

//Obtner iD

$ObtenerID=$conexion->query("SELECT * from intervenciones ORDER BY ID DESC LIMIT 1");
foreach($ObtenerID as $ID){
    $id=$ID['ID'];
break;
}

echo $id;



?>