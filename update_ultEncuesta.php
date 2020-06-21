<?php

$cfg['ExecTimeLimit'] = 6000;


require_once "PDO.php";

$ObtenerPersonas = $conexion->query("SELECT * from personas");
$conta=0;
$conta1=0;
foreach ($ObtenerPersonas as $Persona){
    $DNI=$Persona['dni'];
    $ObtenerEncuesta = $conexion->prepare("SELECT * from encuestas WHERE dni_titular=:dni ORDER BY anio DESC LIMIT 1");
    $ObtenerEncuesta->bindParam(':dni',$DNI);
    $ObtenerEncuesta->execute();
    foreach ($ObtenerEncuesta as $Encuesta){
        $AnioActualizado = $Encuesta['anio'];
    }
    $ActualizarAnio = $conexion->prepare ("UPDATE personas SET ult_encuesta=:anioActualiado WHERE dni=:dni");
    $ActualizarAnio -> bindParam(':dni',$DNI);
    $ActualizarAnio -> bindparam(':anioActualiado',$AnioActualizado);
    if($ActualizarAnio->execute()){
        $conta++;
    }else{
        $conta1++;
    }
}

echo "SE ACTUALIZARON: ".$conta." REGISTROS Y NO SE ACTUALIZARON ".$conta1;
?>