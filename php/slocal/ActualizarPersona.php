<?php

require_once "../../PDO.php";

$datos =$_POST['valorBusqueda'];

$datos = explode("@#",$datos);

    $ActualizarPersona=$conexion->prepare("UPDATE personas_slocal SET nombre=:nombre,date=:date,domicilio=:domicilio,telefono=:telefono,obs=:obs,legajo=:legajo WHERE ID=:id");
    $ActualizarPersona->bindParam(':id',$datos[0]);
    $ActualizarPersona->bindParam(':nombre',$datos[1]);
    $ActualizarPersona->bindParam(':date',$datos[2]);
    $ActualizarPersona->bindParam(':domicilio',$datos[3]);
    $ActualizarPersona->bindParam(':telefono',$datos[4]);
    $ActualizarPersona->bindParam(':obs',$datos[5]);
    $ActualizarPersona->bindParam(':legajo',$datos[6]);

    if($ActualizarPersona->execute()){
        echo "OK";
    }else{
        echo "NO";
    }


?>