<?php

require_once "PDO.php";

$datos =$_POST['valorBusqueda'];

$datos = explode("@#",$datos);

$anio = "2020";

    $InsertarFamiliar=$conexion->prepare("INSERT INTO grupos (dni_titular,anio,nombre,vinculo,dni,fnacimiento,ocupacion,ingreso,nivel_educativo,institucion,otra) VALUES (:dni_titular,:anio,:nombre,:vinculo,:dni,:fnacimiento,:ocupacion,:ingreso,:nivel_educativo,:institucion,:otra)");
    $InsertarFamiliar->bindParam(':dni_titular',$datos[0]);
    $InsertarFamiliar->bindParam(':anio',$anio);
    $InsertarFamiliar->bindParam(':nombre',$datos[2]);
    $InsertarFamiliar->bindParam(':vinculo',$datos[3]);
    $InsertarFamiliar->bindParam(':dni',$datos[1]);
    $InsertarFamiliar->bindParam(':fnacimiento',$datos[4]);
    $InsertarFamiliar->bindParam(':ocupacion',$datos[5]);
    $InsertarFamiliar->bindParam(':ingreso',$datos[6]);
    $InsertarFamiliar->bindParam(':nivel_educativo',$datos[7]);
    $InsertarFamiliar->bindParam(':institucion',$datos[8]);
    $InsertarFamiliar->bindParam(':otra',$datos[9]);
    if($InsertarFamiliar->execute()){
        echo "OK";
    }else{
        echo "NO";
    }

    
?>