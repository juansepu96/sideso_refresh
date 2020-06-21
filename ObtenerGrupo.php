<?php 
require_once "PDO.php";

$titular=$_POST['valorBusqueda'];

$rta="";

    $ObtenerGrupo=$conexion->prepare("SELECT *  FROM grupos WHERE dni_titular=:dni");
	$ObtenerGrupo->bindParam(':dni',$titular);
	$ObtenerGrupo->execute();

	foreach ($ObtenerGrupo as $Grup) {
        $id=$Grup['ID'];
        $nombre=$Grup['nombre'];
        $vinculo=$Grup['vinculo'];
        $dni=$Grup['dni'];
        $fnacimiento=$Grup['fnacimiento'];
        $timestamp = strtotime($fnacimiento);
        $fnacimiento = date("d/m/Y", $timestamp);
        $ocupacion=$Grup['ocupacion'];
        $ingreso=$Grup['ingreso'];
        $nivel=$Grup['nivel_educativo'];
        $institucion=$Grup['institucion'];
        $otra=$Grup['otra'];
		$rta=$rta."@#".$id."@#".$nombre."@#".$vinculo."@#".$dni."@#".$fnacimiento."@#".$ocupacion."@#".$ingreso."@#".$nivel."@#".$institucion."@#".$otra;
	}

echo $rta;

?>