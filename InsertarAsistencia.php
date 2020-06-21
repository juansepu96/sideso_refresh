<?php

require_once "PDO.php";

$datos =$_POST['valorBusqueda'];

$datos = explode("@#",$datos);

	$InsertarAsistencia=$conexion->prepare("INSERT INTO asistencias (dni,tipo,monto,observacion,fecha,estado) VALUES (:dni,:tipo,:monto,:observacion,:fecha,:estado)");
	$InsertarAsistencia->bindParam(':dni',$datos[0]);
	$InsertarAsistencia->bindParam(':tipo',$datos[1]);
	$InsertarAsistencia->bindParam(':monto',$datos[2]);
	$InsertarAsistencia->bindParam(':observacion',$datos[3]);
	$InsertarAsistencia->bindParam(':fecha',$datos[4]);
	$InsertarAsistencia->bindParam(':estado',$datos[5]);

	if($InsertarAsistencia->execute()){
        echo "OK";
    }else{
        echo "NO";
    }



?>