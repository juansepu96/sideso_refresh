<?php


require_once "PDO.php";

$encuestaaobtener = $_SESSION['valor.encuesta'];

	$ObtenerEncuesta=$conexion->prepare("SELECT * FROM encuestas WHERE ID=:encuestaaobtener");
	$ObtenerEncuesta->bindParam(':encuestaaobtener',$encuestaaobtener);
	$ObtenerEncuesta->execute();
	foreach ($ObtenerEncuesta as $encuesta) {
        $dniaobtener=$encuesta['dni_titular'];
		$registro=$encuesta['ID'];
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

    }
    
    $ObtenerPersona=$conexion->prepare("SELECT * FROM personas WHERE dni=:aobtener");
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

		}

	$ObtenerGrupo=$conexion->prepare("SELECT *  FROM grupos WHERE dni_titular=:dni");

	$ObtenerGrupo->bindParam(':dni',$dniaobtener);
	$ObtenerGrupo->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Encuesta - SiDeSo v2.0</title>
    <link rel="stylesheet" href="class.css">

</head>
<body>

    <center>

		<a href='index.php' > <img src="logo A.jpg"> </a>
 
	</center>

	<div class="wrap">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <h4>Nro. Registro: <?php echo $registro;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>INFORME SOCIO-ECONOMICO <?php $fechaen=strtotime($fecha); echo date ("Y",$fechaen);?></u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Fecha: <?php echo date_format(date_create_from_format('Y-m-d', $fecha), 'd/m/Y');?></h4>

            <br><br>

            <h4 align="left"><u>Apellido y Nombre:</u> <?php echo $nombre;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>DNI:</u>&nbsp;&nbsp;&nbsp;<?php echo $dni;?></h4>
            <br>


            <h4 align="left"><u>Estado Civil:</u>&nbsp;&nbsp;<?php echo $estado_civil;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<u>F. Nacimiento:</u>&nbsp;&nbsp;<?php echo date_format(date_create_from_format('Y-m-d', $fnacimiento), 'd/m/Y');;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <u>Lugar de Nacimiento:</u>&nbsp; <?php echo $lnacimiento;?> </h4>
            <br>		

            <h4 align="left"><u>Nacionalidad:</u>&nbsp;&nbsp;<?php echo $nacionalidad;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Ocupación:</u>&nbsp;&nbsp;<?php echo $ocupacion;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Ingresos:</u>&nbsp;&nbsp;<?php echo '$ '.$ingresos;?> </h4>
            <br>

            <h4 align="left"><u>Domicilio:</u>&nbsp;&nbsp;<?php echo $domicilio;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>Barrio:</u>&nbsp;&nbsp; <?php echo $barrio;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>Nivel Educativo:</u>&nbsp;&nbsp; <?php echo $educacion;?> </h4>
            <br>

            <h4 align="left"><u>Tel. Fijo:</u>&nbsp;&nbsp; <?php echo $tel_fijo;?> &nbsp;&nbsp;&nbsp; <u>Celular:</u>&nbsp;&nbsp; <?php echo $tel_cel;?> &nbsp;&nbsp;&nbsp; <u>Email:</u> <?php echo $email;?>&nbsp;&nbsp;&nbsp;</h4>
            <br>

            <h4 align="left"><u>Institucion:</u>&nbsp;&nbsp; <?php echo $institucion;?> &nbsp;&nbsp;&nbsp; <u>Otra Inst.:</u>&nbsp;&nbsp; <?php echo $otra;?> &nbsp;&nbsp;&nbsp; </h4>
            <br>

            <h4 align="left"><u>Años de residencia en Monte Hermoso:</u>&nbsp;&nbsp; <?php echo $anios;?> &nbsp;&nbsp;&nbsp; </h4>
            <br>
            <center><h3>Grupo Familiar Conviviente</h3></center><br>
                        <table class="Mensajes">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Vinculo</th>
                                        <th>DNI</th>
                                        <th>F. Nacimiento</th>
                                        <th>N. Educativo</th>
                                        <th>Ocupacion</th>
                                        <th>Institucion</th>
                                        <th>Otra Inst</th>
                                        <th>Ingreso</th>
                                    </tr>

                                    <?php foreach ($ObtenerGrupo as $persona) { ?>	
                                    
                                            <td align="Center"><?php echo $persona['nombre'];?></td>

                                            <td align="Center"><?php echo $persona['vinculo'];?></td>

                                            <td align="Center"><?php echo $persona['dni'];?></td>

                                            <td align="Center" ><?php echo date_format(date_create_from_format('Y-m-d', $persona['fnacimiento']), 'd/m/Y');?></td>

                                            <td align="Center"><?php echo $persona['nivel_educativo'];?></td>

                                            <td align="Center"><?php echo $persona['ocupacion'];?></td>

                                            <td align="Center"><?php echo $persona['institucion'];?></td>

                                            <td align="Center"><?php echo $persona['otra'];?></td>

                                            <td align="Center"><?php echo $persona['ingreso'];?></td>
                                    
                                    </tr>
                                    <?php } ?>	
                                    </table>
                <br><br>
                <center><h3>Caracteristicas de la vivienda</h3></center><br>

                <h4 align="left"><u>Tipo:</u>&nbsp;&nbsp;<?php echo $tipo;?>&nbsp;&nbsp;&nbsp; <u>Condición:</u>&nbsp;&nbsp; <?php echo $condicion;?> &nbsp;&nbsp;&nbsp; <u>Monto:</u>&nbsp;&nbsp; <?php if($monto==''){ echo '----';}else{echo $monto;};?>&nbsp;&nbsp;&nbsp;<u>Energia Eléctrica:</u>&nbsp; <?php echo $electricidad;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><u>Agua:</u>&nbsp;&nbsp; <?php echo $agua;?>&nbsp;&nbsp;&nbsp;<u>Desague:</u>&nbsp;&nbsp; <?php echo $desague;?>&nbsp;&nbsp;&nbsp;<u>Gas:</u>&nbsp;&nbsp; <?php echo $gas;?></h4>
                <h4 align="left"><u>Material de las paredes:</u>&nbsp;&nbsp;<?php echo $paredes;?>&nbsp;&nbsp;&nbsp; <u>Material del techo:</u>&nbsp;&nbsp; <?php echo $techo;?> &nbsp;&nbsp;&nbsp; <u>Revestimiento:</u>&nbsp;&nbsp; <?php echo $revestimiento;?>&nbsp;&nbsp;&nbsp;<u>Material de los pisos:</u>&nbsp;&nbsp; <?php echo $pisos;?></h4>
                <br>

                <h4 align="left"><u>¿Percibe otros ingresos?</u>&nbsp;&nbsp;<?php echo $otros_ingresos;?></h4>
                <br>

                <h4 align="left"><u>¿Posee otros bienes?:</u>&nbsp;&nbsp;<?php echo $otros_bienes;?>&nbsp;&nbsp;&nbsp; <u>¿Se encuentra adherido al servicio de sepelios?:</u>&nbsp;&nbsp; <?php echo $sepelio;?></h4>
                <br>

                <h4 align="left"><u>Salud:</u>&nbsp;&nbsp; <?php echo $salud;?>&nbsp;&nbsp;&nbsp; <u>Obra Social:</u>&nbsp;&nbsp; <?php echo $obrasocial;?> &nbsp;<?php if($obrasocial=='SI'){ echo '--> &nbsp;'.$osocial;}?>	</h4>
                <br><Br>

                <h4 align="left"><u>Observaciones:</u>&nbsp;&nbsp; <?php echo $observaciones;?> </h4>




            </form>

</div>

</body>
</html>