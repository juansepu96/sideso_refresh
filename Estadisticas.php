<?php


date_default_timezone_set('America/Argentina/Buenos_Aires');

$date=date("Y-m-d");
$time=date("H:i");


require_once "PDO.php";


$contador=0;
$contador2=0;

$ObtenerEncuestas=$conexion->query("SELECT * FROM personas");
$contador=$ObtenerEncuestas->RowCount();

$PorBarrio=$conexion->query("SELECT COUNT(*) as cantidad,barrio FROM personas GROUP BY barrio ORDER BY cantidad DESC");

$PorEstadoCivil=$conexion->query("SELECT COUNT(*) as cantidad,estado_civil FROM personas GROUP BY estado_civil ORDER BY cantidad DESC");

$PorLugarNacimiento=$conexion->query("SELECT COUNT(*) as cantidad,lnacimiento FROM personas GROUP BY lnacimiento ORDER BY cantidad DESC LIMIT 29");

$PorOcupacion=$conexion->query("SELECT COUNT(*) as cantidad,ocupacion FROM personas GROUP BY ocupacion ORDER BY cantidad DESC");

$PorNacionalidad=$conexion->query("SELECT COUNT(*) as cantidad,nacionalidad FROM personas GROUP BY nacionalidad ORDER BY cantidad DESC");

$PorEducacion=$conexion->query("SELECT COUNT(*) as cantidad,educacion FROM personas GROUP BY educacion ORDER BY cantidad DESC");

$PorInstitucion=$conexion->query("SELECT COUNT(*) as cantidad,institucion FROM personas GROUP BY institucion ORDER BY cantidad DESC");

$PorOtra=$conexion->query("SELECT COUNT(*) as cantidad,otra FROM personas GROUP BY otra ORDER BY cantidad DESC");

$PorVivienda=$conexion->query("SELECT COUNT(*) as cantidad,tipo_vivienda FROM encuestas GROUP BY tipo_vivienda ORDER BY cantidad DESC");

$PorCondicionVivienda=$conexion->query("SELECT COUNT(*) as cantidad,condicion_vivienda FROM encuestas GROUP BY condicion_vivienda ORDER BY cantidad DESC");

$PorSepelio=$conexion->query("SELECT COUNT(*) as cantidad,sepelio FROM encuestas GROUP BY sepelio ORDER BY cantidad DESC");

$PorObraSocial=$conexion->query("SELECT COUNT(*) as cantidad,obrasocial FROM encuestas GROUP BY obrasocial ORDER BY cantidad DESC");

$PorAnio=$conexion->query("SELECT COUNT(*) as cantidad,anio FROM encuestas GROUP BY anio ORDER BY cantidad DESC");

$PorPiso=$conexion->query("SELECT COUNT(*) as cantidad,pisos FROM encuestas GROUP BY pisos ORDER BY cantidad DESC");

$PorParedes=$conexion->query("SELECT COUNT(*) as cantidad,paredes FROM encuestas GROUP BY paredes ORDER BY cantidad DESC");

$PorTecho=$conexion->query("SELECT COUNT(*) as cantidad,techo FROM encuestas GROUP BY techo ORDER BY cantidad DESC");

$PorRevestimiento=$conexion->query("SELECT COUNT(*) as cantidad,revestimiento FROM encuestas GROUP BY revestimiento ORDER BY cantidad DESC");

$PorElectricidad=$conexion->query("SELECT COUNT(*) as cantidad,electricidad FROM encuestas GROUP BY electricidad ORDER BY cantidad DESC");

$PorAgua=$conexion->query("SELECT COUNT(*) as cantidad,agua FROM encuestas GROUP BY agua ORDER BY cantidad DESC");

$PorDesague=$conexion->query("SELECT COUNT(*) as cantidad,desague FROM encuestas GROUP BY desague ORDER BY cantidad DESC");

$PorGas=$conexion->query("SELECT COUNT(*) as cantidad,gas FROM encuestas GROUP BY gas ORDER BY cantidad DESC");

$ObtenerAsistencias=$conexion->query("SELECT * FROM asistencias");
$contador2=$ObtenerAsistencias->RowCount();

$PorTipo=$conexion->query("SELECT SUM(monto) as monto,tipo FROM asistencias GROUP BY tipo ORDER BY monto DESC");

$PorMes2019=$conexion->query("SELECT count(*) as cantidad,month(fecha) as mes FROM asistencias where year(fecha)='2019' group by month(fecha)");

$PorMes2020=$conexion->query("SELECT count(*) as cantidad,month(fecha) as mes FROM asistencias where year(fecha)='2020' group by month(fecha)");

$PorMes2019Totales=$conexion->query("SELECT sum(monto) as cantidad,month(fecha) as mes FROM asistencias where year(fecha)='2019' group by month(fecha)");

$PorMes2020Totales=$conexion->query("SELECT sum(monto) as cantidad,month(fecha) as mes FROM asistencias where year(fecha)='2020' group by month(fecha)");

$PorTipo2019=$conexion->query("SELECT SUM(monto) as monto,month(fecha) as mes, tipo FROM asistencias where year(fecha)='2019' GROUP BY month(fecha),tipo");

$PorTipo2020=$conexion->query("SELECT SUM(monto) as monto,month(fecha) as mes, tipo FROM asistencias where year(fecha)='2020' GROUP BY month(fecha),tipo");






?>

<!DOCTYPE HTML>
<html lang="es">
<head>
	 <!-- Required meta tags -->
	 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">    
    
    <title>Estadisticas - SiDeSo v2.0</title>
</head>
<body onload="Acceder();">

<nav class="navbar text-center navbar-expand-lg navbar-dark bg-dark navbar-toggleable-sm sticky-top">
        <a class="navbar-brand" href="Inicio.php">
            SiDeSo v2.0
         </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <ul class="navbar-nav text-center">
      <li class="nav-item">
        <a class="nav-link" href="Inicio.php">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Buscar.php">Personas</a>
      </li>     
	  <li class="nav-item active">
        <a class="nav-link" href="Estadisticas.php">Estadisticas</a>
	  </li>
	  <li class="nav-item">
        <a class="nav-link" href="Backups.php">Copias de Seguridad</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Cerrar.php">Cerrar Sesion</a>
      </li> 
           
    </ul>
  </div>
</nav>


	<div hidden class="contenedor mt-4 formulario" id="todo">
		
		<h2 style="color:white;"> -> ESTADISTICAS TOTALES <> FECHA: <?php echo date("d/m/Y");?>  -  HORA: <?php echo $time." hs";?> <- </h2> <br>

		<h2 style="color:white;">Cantidad de Encuestas Totales: <?php echo $contador;?> </h2>
		<br>

			<h2 style="color:white;"> --->  Seccion: Datos Personales  <---</h2>	<br>

			<div class="personas">
					<div class="s1">
						<table>
						
						<caption>Segmentación por Barrio </caption>
							
						<?php
							foreach ($PorBarrio as $Persona){ ?>
							<tr>						
								<td><?php if($Persona['barrio']==" ") { echo "OTRO"; } else { echo $Persona['barrio'];} ?></td>
								<td><?php echo $Persona['cantidad'];?></td>
							</tr>
						<?php } ?>
						</table>
						<br>
						<table>
						<caption>Según Estado Civil </caption>
							
						<?php
							foreach ($PorEstadoCivil as $Persona){ ?>
							<tr>						
								<td><?php echo $Persona['estado_civil']; ?></td>
								<td><?php echo $Persona['cantidad'];?></td>
							</tr>
						<?php } ?>
						</table>
						<br>
						<table>
						<caption>Según ocupación</caption>
						
						<?php
							foreach ($PorOcupacion as $Persona){ ?>
							<tr>						
								<td><?php echo $Persona['ocupacion']; ?></td>
								<td><?php echo $Persona['cantidad'];?></td>
							</tr>
						<?php } ?>
						</table>
						<br>
						<table>
						<caption>Según Institucion Educ.</caption>
						
						<?php
							foreach ($PorInstitucion as $Persona){ ?>
							<tr>						
								<td><?php echo $Persona['institucion']; ?></td>
								<td><?php echo $Persona['cantidad'];?></td>
							</tr>
						<?php } ?>
						</table>
					
				</div> <!-- Cierre DIV bloque -->

				<div class="s1">

					<table>
					<caption>Según Lugar de Nac.</caption>

					<?php
						foreach ($PorLugarNacimiento as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['lnacimiento']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>
					<br>
					<table>
					<caption>Según Otra Inst.</caption>

					<?php
						foreach ($PorOtra as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['otra']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					
					
				</div> <!-- Cierre DIV bloque -->

				<div class="s1">

					<table>
					<caption>Según Nacionalidad </caption>

						
					<?php
						foreach ($PorNacionalidad as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['nacionalidad']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>
					<caption> Según N. Educativo </caption>

					<?php
						foreach ($PorEducacion as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['educacion']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>
				</div> <!-- Cierre DIV bloque -->
			</div> <!-- Cierre DIV Personas -->
			<br><br>
			<h1 style="text-decoration:none;color:white;">--------------------------------------------------------</h1>
			<br>

			<h2 style="color:white;"> --->  Seccion: Datos Censales  <---</h2>	<br>


			<div class="encuestas">

				<div class="s1">
					<table>
					<caption> Según T. Vivienda </caption>

					<?php
						foreach ($PorVivienda as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['tipo_vivienda']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>
					<caption> Según Cond. Vivienda </caption>

					<?php
						foreach ($PorCondicionVivienda as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['condicion_vivienda']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>

					<caption> Según Cond. Paredes </caption>

					<?php
						foreach ($PorParedes as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['paredes']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					

				</div>

				<div class="s1">
					<table>
					<caption> Según Obra Social </caption>

					<?php
						foreach ($PorObraSocial as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['obrasocial']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>
					<caption> Cantidad Por Año </caption>

					<?php
						foreach ($PorAnio as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['anio']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>
					<caption> Según Cond. Piso </caption>

					<?php
						foreach ($PorPiso as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['pisos']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>
					<table>
					<caption> Según Sepelio </caption>

					<?php
						foreach ($PorSepelio as $Persona){ 
							if($Persona['sepelio']=="NO"){ ?>				
								<tr>						
									<td><?php echo $Persona['sepelio']; ?></td>
									<td><?php echo $Persona['cantidad'];?></td>
								</tr>
							<?php } else { 	$contador=$contador+1; }?>
							<?php } ?>
								<tr>						
									<td>SI</td>
									<td><?php echo $contador;?></td>
								</tr>						
					
					</table>

					<table>

					<caption> Según Revestimiento </caption>

					<?php
						foreach ($PorRevestimiento as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['revestimiento']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>

					<caption> Según Gas </caption>

					<?php
						foreach ($PorGas as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['gas']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>
					
				
				</div>

				<div class="s1">

					<table>

					<caption> Según Cond. Techo </caption>

					<?php
						foreach ($PorTecho as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['techo']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>

					<caption> Según Electricidad </caption>

					<?php
						foreach ($PorElectricidad as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['electricidad']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>

					<caption> Según Agua </caption>

					<?php
						foreach ($PorAgua as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['agua']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>

					<caption> Según Desague </caption>

					<?php
						foreach ($PorDesague as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['desague']; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					

				</div>



			</div> <!--Cierre DIV Datos censales --> 

			<br><br>
			<h1 style="text-decoration:none;color:white;">--------------------------------------------------------</h1>
			<br>

			<h2 style="color:white;"> --->  Seccion: Asistencias  <---</h2>	<br>
			<h2 style="color:white;">Cantidad de Asistencias Totales: <?php echo $contador2;?> </h2>


			<div class="encuestas">

				<div class="s1">
					<table>
					<caption> Monto segun Tipo de Asistencia</caption>

					<?php
						foreach ($PorTipo as $Persona){ ?>
						<tr>						
							<td><?php echo $Persona['tipo']; ?></td>
							<td><?php echo "$ ".number_format($Persona['monto'],2);?></td>
						</tr>
					<?php } ?>
					</table>

					<table>
					<caption> Cantidad Segun Mes (2019) </caption>

					<?php
						foreach ($PorMes2019 as $Persona){
							switch ($Persona['mes']) {
								case "1":
									$mes = "Enero";
								break;
								case "2":
									$mes = "Febrero";
								break;
								case "3":
									$mes = "Marzo";
								break;
								case "4":
									$mes = "Abril";
								break;
								case "5":
									$mes = "Mayo";
								break;
								case "6":
									$mes = "Junio";
								break;
								case "7":
									$mes = "Julio";
								break;
								case "8":
									$mes = "Agosto";
								break;
								case "9":
									$mes = "Septiembre";
								break;
								case "10":
									$mes = "Octubre";
								break;
								case "11":
									$mes = "Noviembre";
								break;
								case "12":
									$mes = "Diciembre";
								break;					
							} 	
							 ?>
						<tr>						
							<td><?php echo $mes; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<table>
					<caption> Cantidad Segun Mes (2020) </caption>

					<?php
						foreach ($PorMes2020 as $Persona){ 
							switch ($Persona['mes']) {
								case "1":
									$mes = "Enero";
								break;
								case "2":
									$mes = "Febrero";
								break;
								case "3":
									$mes = "Marzo";
								break;
								case "4":
									$mes = "Abril";
								break;
								case "5":
									$mes = "Mayo";
								break;
								case "6":
									$mes = "Junio";
								break;
								case "7":
									$mes = "Julio";
								break;
								case "8":
									$mes = "Agosto";
								break;
								case "9":
									$mes = "Septiembre";
								break;
								case "10":
									$mes = "Octubre";
								break;
								case "11":
									$mes = "Noviembre";
								break;
								case "12":
									$mes = "Diciembre";
								break;					
							} 		
						?>
						<tr>						
							<td><?php echo $mes; ?></td>
							<td><?php echo $Persona['cantidad'];?></td>
						</tr>
					<?php } ?>
					</table>

					<br>
					<table>
					<caption> Total Segun Mes (2019) </caption>

					<?php
						foreach ($PorMes2019Totales as $Persona){ 
							switch ($Persona['mes']) {
								case "1":
									$mes = "Enero";
								break;
								case "2":
									$mes = "Febrero";
								break;
								case "3":
									$mes = "Marzo";
								break;
								case "4":
									$mes = "Abril";
								break;
								case "5":
									$mes = "Mayo";
								break;
								case "6":
									$mes = "Junio";
								break;
								case "7":
									$mes = "Julio";
								break;
								case "8":
									$mes = "Agosto";
								break;
								case "9":
									$mes = "Septiembre";
								break;
								case "10":
									$mes = "Octubre";
								break;
								case "11":
									$mes = "Noviembre";
								break;
								case "12":
									$mes = "Diciembre";
								break;					
							} 		
						?>
						<tr>						
							<td><?php echo $mes; ?></td>
							<td><?php echo "$ ".number_format($Persona['cantidad'],2);?></td>
						</tr>
					<?php } ?>
					</table>
					<table>
					<caption> Total Segun Mes (2020) </caption>

					<?php
						foreach ($PorMes2020Totales as $Persona){ 
							switch ($Persona['mes']) {
								case "1":
									$mes = "Enero";
								break;
								case "2":
									$mes = "Febrero";
								break;
								case "3":
									$mes = "Marzo";
								break;
								case "4":
									$mes = "Abril";
								break;
								case "5":
									$mes = "Mayo";
								break;
								case "6":
									$mes = "Junio";
								break;
								case "7":
									$mes = "Julio";
								break;
								case "8":
									$mes = "Agosto";
								break;
								case "9":
									$mes = "Septiembre";
								break;
								case "10":
									$mes = "Octubre";
								break;
								case "11":
									$mes = "Noviembre";
								break;
								case "12":
									$mes = "Diciembre";
								break;					
							} 		
						?>
						<tr>						
							<td><?php echo $mes; ?></td>
							<td><?php echo "$ ".number_format($Persona['cantidad'],2);?></td>
						</tr>
					<?php } ?>
					</table>

					

				</div>

				<div class="s1">	
					<table>
					<caption> Total Segun Tipo por Mes (2019) </caption>

					<?php
						foreach ($PorTipo2019 as $Persona){ 
							switch ($Persona['mes']) {
								case "1":
									$mes = "Enero";
								break;
								case "2":
									$mes = "Febrero";
								break;
								case "3":
									$mes = "Marzo";
								break;
								case "4":
									$mes = "Abril";
								break;
								case "5":
									$mes = "Mayo";
								break;
								case "6":
									$mes = "Junio";
								break;
								case "7":
									$mes = "Julio";
								break;
								case "8":
									$mes = "Agosto";
								break;
								case "9":
									$mes = "Septiembre";
								break;
								case "10":
									$mes = "Octubre";
								break;
								case "11":
									$mes = "Noviembre";
								break;
								case "12":
									$mes = "Diciembre";
								break;					
							} 		
						?>
						<tr>						
							<td><?php echo $mes; ?></td>
							<td><?php echo $Persona['tipo']; ?></td>
							<td><?php echo "$ ".number_format($Persona['monto'],2);?></td>
						</tr>
					<?php } ?>
					</table>
				
				</div>

				<div class="s1">
				<table>
					<caption> Total Segun Tipo por Mes (2020) </caption>

					<?php
						foreach ($PorTipo2020 as $Persona){ 
							switch ($Persona['mes']) {
								case "1":
									$mes = "Enero";
								break;
								case "2":
									$mes = "Febrero";
								break;
								case "3":
									$mes = "Marzo";
								break;
								case "4":
									$mes = "Abril";
								break;
								case "5":
									$mes = "Mayo";
								break;
								case "6":
									$mes = "Junio";
								break;
								case "7":
									$mes = "Julio";
								break;
								case "8":
									$mes = "Agosto";
								break;
								case "9":
									$mes = "Septiembre";
								break;
								case "10":
									$mes = "Octubre";
								break;
								case "11":
									$mes = "Noviembre";
								break;
								case "12":
									$mes = "Diciembre";
								break;					
							} 		
						?>
						<tr>						
							<td><?php echo $mes; ?></td>
							<td><?php echo $Persona['tipo']; ?></td>
							<td><?php echo "$ ".number_format($Persona['monto'],2);?></td>
						</tr>
					<?php } ?>
					</table>
					<table>
					
					

				</div>



			</div>
	

    </div> <!-- Cierre DIV total -->

   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js" ></script> 
	<script src="Estadisticas.js" ></script> 
</body>
</html>



