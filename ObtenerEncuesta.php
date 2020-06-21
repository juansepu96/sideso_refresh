<?php 
require_once "PDO.php";

$encuesta=$_POST['valorBusqueda'];
$rta="";
        $ObtenerListadoEncuestas=$conexion->prepare("SELECT * from encuestas WHERE ID=:id");
		$ObtenerListadoEncuestas->bindParam(':id',$encuesta);
		$ObtenerListadoEncuestas->execute();

	foreach ($ObtenerListadoEncuestas as $encuesta) {
        $id=$encuesta['ID'];
        $tipo=$encuesta['tipo_vivienda'];
		$condicion=$encuesta['condicion_vivienda'];
		$monto=$encuesta['monto'];
		$otros_bienes=$encuesta['otros_bienes'];
		$sepelio=$encuesta['sepelio'];
		$salud=$encuesta['salud'];
		$osocial=$encuesta['osocial'];
		$obrasocial=$encuesta['obrasocial'];
		$observaciones=$encuesta['observaciones'];
		$fecha=$encuesta['fecha'];
		$pisos=$encuesta['pisos'];
		$paredes=$encuesta['paredes'];
		$techo=$encuesta['techo'];
		$revestimiento=$encuesta['revestimiento'];
		$electricidad=$encuesta['electricidad'];
		$agua=$encuesta['agua'];
		$desague=$encuesta['desague'];
		$gas=$encuesta['gas'];
        $otros_ingresos=$encuesta['otros_ingresos'];
        $observaciones=$encuesta['observaciones'];
        $rta=$id."@#".$tipo."@#".$condicion."@#".$monto."@#".$otros_bienes."@#".$sepelio."@#".$salud."@#".$obrasocial;
        $rta=$rta."@#".$osocial."@#".$observaciones."@#".$fecha."@#".$pisos."@#".$paredes."@#".$techo."@#".$revestimiento;
        $rta=$rta."@#".$electricidad."@#".$agua."@#".$desague."@#".$gas."@#".$otros_ingresos."@##".$observaciones;
        
	}

    echo $rta;

?>