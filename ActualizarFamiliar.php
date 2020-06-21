<?php

require_once "PDO.php";

$datos =$_POST['valorBusqueda'];

$datos = explode("@#",$datos);

    $ActualizarPersona=$conexion->prepare("UPDATE grupos SET dni=:dni,nombre=:nombre,vinculo=:vinculo,fnacimiento=:fnacimiento,ocupacion=:ocupacion,ingreso=:ingreso,nivel_educativo=:nivel_educativo,institucion=:institucion,otra=:otra WHERE ID=:id");
    $ActualizarPersona->bindParam(':id',$datos[0]);
    $ActualizarPersona->bindParam(':dni',$datos[1]);
    $ActualizarPersona->bindParam(':nombre',$datos[2]);
    $ActualizarPersona->bindParam(':vinculo',$datos[3]);
    $ActualizarPersona->bindParam(':fnacimiento',$datos[4]);
    $ActualizarPersona->bindParam(':ocupacion',$datos[5]);
    $ActualizarPersona->bindParam(':ingreso',$datos[6]);
    $ActualizarPersona->bindParam(':nivel_educativo',$datos[7]);
    $ActualizarPersona->bindParam(':institucion',$datos[8]);
    $ActualizarPersona->bindParam(':otra',$datos[9]);
    if($ActualizarPersona->execute()){
        echo "OK";
    }else{
        echo "NO";
    }

    
?>