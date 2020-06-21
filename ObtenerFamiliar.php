<?php 

require_once "PDO.php";


$dniaobtener=$_POST['valorBusqueda'];

$datos="";
$testigo="@#";

	    $ObtenerPersona=$conexion->prepare("SELECT * FROM grupos WHERE ID=:aobtener");
		$ObtenerPersona->bindParam(':aobtener',$dniaobtener);
		$ObtenerPersona->execute();
		foreach($ObtenerPersona as $persona) {
			$dni=$persona['dni'];
			$nombre=$persona['nombre'];
			$vinculo=$persona['vinculo'];
			$fnacimiento=$persona['fnacimiento'];
			$ocupacion=$persona['ocupacion'];
			$ingresos=$persona['ingreso'];
			$educacion=$persona['nivel_educativo'];
			$institucion=$persona['institucion'];
            $otra=$persona['otra'];
            $datos=$dniaobtener.$testigo.$dni.$testigo.$nombre.$testigo.$vinculo.$testigo.$fnacimiento.$testigo.$ocupacion.$testigo.$ingresos.$testigo;
            $datos=$datos.$educacion.$testigo.$institucion.$testigo.$otra;
            
        }

echo $datos;
        

?>