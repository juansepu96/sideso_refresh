<?php

require_once "../PDO.php";

$datos=$_POST['valorBusqueda'];
$datos=json_decode($datos);
$obs="";

$InsertarPersona= $conexion -> prepare("INSERT INTO personas_mujeres (DNI,nombre,date,domicilio,telefono,obs) VALUES (:DNI,:nombre,:date,:domicilio,:telefono,:obs)");
$InsertarPersona -> bindParam(':DNI',$datos[0]);
$InsertarPersona -> bindParam(':nombre',$datos[1]);
$InsertarPersona -> bindParam(':date',$datos[2]);
$InsertarPersona -> bindParam(':domicilio',$datos[3]);
$InsertarPersona -> bindParam(':telefono',$datos[4]);
$InsertarPersona -> bindParam(':obs',$obs);
$InsertarPersona -> execute();

//Obtenemos el ID

$BuscarID=$conexion->query("SELECT * FROM personas_mujeres ORDER BY ID DESC LIMIT 1");
foreach($BuscarID as $ID){
    echo $ID['ID'];
break;
}


?>