<?php 

require_once "PDO.php";


$dniaobtener=$_POST['valorBusqueda'];

$datos="";
$testigo="@#";

	    $ObtenerPersona=$conexion->prepare("SELECT * FROM personas WHERE ID=:aobtener");
		$ObtenerPersona->bindParam(':aobtener',$dniaobtener);
		$ObtenerPersona->execute();
		foreach($ObtenerPersona as $persona) {
			$dni=$persona['dni'];
			$nombre=$persona['nombre'];
			$estado_civil=$persona['estado_civil'];
			$fnacimiento=$persona['fnacimiento'];
			$lnacimiento=$persona['lnacimiento'];
			$domicilio=$persona['domicilio'];
			$tel_fijo=$persona['tel_fijo'];
			$tel_cel=$persona['tel_cel'];
			$email=$persona['email'];
			$anios=$persona['anios'];
			$ocupacion=$persona['ocupacion'];
			$ingresos=$persona['ingresos'];
			$nacionalidad=$persona['nacionalidad'];
			$barrio=$persona['barrio'];
			$educacion=$persona['educacion'];
			$institucion=$persona['institucion'];
			$otra=$persona['otra'];
			$obs=$persona['obs'];
            $datos=$dni.$testigo.$nombre.$testigo.$estado_civil.$testigo.$fnacimiento.$testigo.$lnacimiento.$testigo.$domicilio.$testigo;
            $datos=$datos.$tel_fijo.$testigo.$tel_cel.$testigo.$email.$testigo.$anios.$testigo.$ocupacion.$testigo.$ingresos.$testigo;
            $datos=$datos.$nacionalidad.$testigo.$barrio.$testigo.$educacion.$testigo.$institucion.$testigo.$otra.$testigo.$obs;
        }

echo $datos;
        

?>