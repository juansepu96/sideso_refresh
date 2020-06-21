<?php
require_once "PDO.php";

$datos =$_POST['valorBusqueda'];

$datos = explode("@#",$datos);


	$InsertarAsistencia=$conexion->prepare("UPDATE asistencias SET tipo=:tipo,fecha=:fecha,monto=:monto,observacion=:observacion,estado=:estado,fecha_ultima=:ultimafecha WHERE ID=:id");
	$InsertarAsistencia->bindParam(':id',$datos[0]);
	$InsertarAsistencia->bindParam(':monto',$datos[1]);
	$InsertarAsistencia->bindParam(':observacion',$datos[3]);
	$InsertarAsistencia->bindParam(':estado',$datos[2]);
	$InsertarAsistencia->bindParam(':ultimafecha',$datos[4]);
	$InsertarAsistencia->bindParam(':fecha',$datos[5]);
	$InsertarAsistencia->bindParam(':tipo',$datos[6]);

	if($InsertarAsistencia->execute()){
        echo "OK";
    }else{
        echo "NO";
    }


?>