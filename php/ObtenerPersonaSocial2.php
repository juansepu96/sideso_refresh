<?php

require_once "../PDO.php";

$dato=$_POST['valorBusqueda'];

$VerificarEncuesta = $conexion -> prepare ("SELECT * from personas WHERE dni=:dni");
$VerificarEncuesta -> bindParam(':dni',$dato);
$VerificarEncuesta -> execute();
$datos="";
$testigo="@#";
if($VerificarEncuesta->RowCount()>0){
		foreach($VerificarEncuesta as $persona) {
			$dni=$persona['dni'];
			$nombre=$persona['nombre'];
			$estado_civil=$persona['estado_civil'];
			$fnacimiento=$persona['fnacimiento'];
			$domicilio=$persona['domicilio'];
			$tel=$persona['tel_cel'];
			$datos=$dni.$testigo.$nombre.$testigo.$fnacimiento.$testigo.$domicilio.$testigo.$tel;
        }
        echo $datos;
}else{
    $VerificarGrupo = $conexion -> prepare ("SELECT * from grupos WHERE dni=:dni");
    $VerificarGrupo -> bindParam(':dni',$dato);
    $VerificarGrupo -> execute();
    foreach($VerificarGrupo as $persona) {
        $dni=$persona['dni'];
        $nombre=$persona['nombre'];
		$fnacimiento=$persona['fnacimiento'];
		$domicilio="";
		$tel="";
        $datos=$dni.$testigo.$nombre.$testigo.$fnacimiento.$testigo.$domicilio.$testigo.$tel;
    }
    echo $datos;
}


?>