<?php

require_once "PDO.php";

$busque='false';
$hayresultados='false';
$cargarencuestas='false';
$mostrartodo='false';
$editar='false';
$personales='false';
$grupo='false';
$editarenc='false';

$_SESSION['busqueda.array']=array();


if(isset($_POST['buscarr'])){
	$abuscar=$_POST['buscar'];
	$abuscar='%'.$abuscar.'%';
	$BuscarPersona=$conexion->prepare("SELECT * FROM personas WHERE dni LIKE :abuscar");
	$BuscarPersona->bindParam(':abuscar',$abuscar);
	$BuscarPersona->execute();
	foreach ($BuscarPersona as $persona){
		$ID=$persona['ID'];
		$dni=$persona['dni'];
		$nombre=strtoupper($persona['nombre']);
		$fnacimiento=$persona['fnacimiento'];		
		$ultima_encuesta=$persona['ult_encuesta'];
		$detalle_busqueda=array($ID,$dni,$nombre,$fnacimiento,$ultima_encuesta);
		array_push($_SESSION['busqueda.array'], $detalle_busqueda);
	}
	$BuscarPersona=$conexion->prepare("SELECT * FROM personas WHERE nombre LIKE :abuscar");
	$BuscarPersona->bindParam(':abuscar',$abuscar);
	$BuscarPersona->execute();
	foreach ($BuscarPersona as $persona){
		$ID=$persona['ID'];
		$dni=$persona['dni'];
		$nombre=strtoupper(utf8_encode($persona['nombre']));
		$estado_civil=$persona['estado_civil'];
		$fnacimiento=$persona['fnacimiento'];
		$lnacimiento=$persona['lnacimiento'];
		$domicilio=$persona['domicilio'];
		$tel_fijo=$persona['tel_fijo'];
		$tel_cel=$persona['tel_cel'];
		$email=$persona['email'];
		$ultima_encuesta=$persona['ult_encuesta'];
		$detalle_busqueda=array($ID,$dni,$nombre,$fnacimiento,$ultima_encuesta);
		array_push($_SESSION['busqueda.array'], $detalle_busqueda);
	}
	$BuscarGrupo = $conexion->prepare("SELECT * from grupos WHERE ((nombre LIKE :abuscar) OR (dni LIKE :abuscar))");
	$BuscarGrupo ->bindParam(':abuscar',$abuscar);
	$BuscarGrupo -> execute();
	foreach ($BuscarGrupo as $Person){
		$abuscar=$Person['dni_titular'];
		$abuscar='%'.$abuscar.'%';
		$BuscarPersona=$conexion->prepare("SELECT * FROM personas WHERE dni LIKE :abuscar");
		$BuscarPersona->bindParam(':abuscar',$abuscar);
		$BuscarPersona->execute();
		foreach ($BuscarPersona as $persona){
      $ID=$persona['ID'];
      $dni=$persona['dni'];
      $nombre=strtoupper($persona['nombre']);
      $fnacimiento=$persona['fnacimiento'];		
      $ultima_encuesta=$persona['ult_encuesta'];
      $detalle_busqueda=array($ID,$dni,$nombre,$fnacimiento,$ultima_encuesta);
      array_push($_SESSION['busqueda.array'], $detalle_busqueda);
		}
	}

	$busque='true';

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">    
    <title>Buscar Personas - SiDeSo v2.0</title>
</head>
<body>

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
      <li class="nav-item active">
        <a class="nav-link" href="Buscar.php">Personas</a>
      </li>     
	  <li class="nav-item">
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

<div class="buscador mt-5 mr-5 ml-5 p-4 ">        
      <h3 class="welcome">BUSCAR POR DNI O NOMBRE DEL TITULAR O INTEGRANTE DEL GRUPO FAMILIAR</h3>
      <form method="post">
        <div class="row text-center">
            <div class="col-lg-11 col-xl-11 col-xs-6 col-md-6">
                <input type="text" class="form-control" name="buscar">
            </div>
            <div class="col-1">
              <button type="submit" name="buscarr" class="btn btn-primary" class="form-control"><i class="fas fa-search fa-1x"></i></button>
            </div>         
        </div>
       </form>
</div>

    <?php if($busque=='true'){?>
        <div id="Resultados" class="buscador mt-1 mr-5 ml-5 p-4">        
        <h3 class="welcome">RESULTADO DE LA BÚSQUEDA</h3>
        <div style="float:right;" class="mb-2">
          <button type="button" name="nueva_persona" class="btn btn-primary"  onclick="NuevaPersona();"><i class="fas fa-plus-circle fa-1x"></i> Nueva Persona </button> <br>
        </div>
            <table class="table table-hover mt-2" style="color:white;">
                 <thead>
                        <tr class="text-center">
                            <th hidden>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>F. Nacimiento</th>
                            <th>Ult. Encuesta</th>
                        </tr>
                 </thead>
                 <tbody>        
                        <?php foreach ($_SESSION['busqueda.array'] as $persona) { ?>
                            <tr class="celda text-center" onclick="Completar('<?php echo $persona[0];?>');">

                                <th><?php echo $persona[1];?></th>
        
                                <th><?php echo $persona[2];?></th>
        
                                <th><?php echo date_format(date_create_from_format('Y-m-d', $persona[3]), 'd/m/Y');?></th>
                        
                                <th><?php echo $persona[4];?></th>
                            </tr>													
                        <?php } ?>	
                </tbody>
            </table>
        </div>
    <?php } ?>

<!--Aca voy a poner un form flotante para ver Ficha de la persona-->
<div class="modal" id="VerFicha" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ver Persona</h5>  <h4 hidden class="ml-2" id="noResidente" style="background:red;color:white;" > -- NO RESIDENTE --</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body formulario">
      <form id="form-persona" method="post" action="Buscar.php">
            <input hidden type="number" class="form-control" id="id_persona" name="id_persona"  placeholder="Ej: Juan">
            <input hidden type="text" class="form-control" id="dni_persona" name="dni_persona"  placeholder="Ej: Juan">


              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="Nombre">Nombre</label>
                  <input  required  type="text" class="form-control" id="nombre" name="nombre"  data-toggle="tooltip" data-placement="bottom" title="Ej. Juan">
                </div>
              
                <div class="form-group col-md-3">
                  <label for="dni">DNI</label>
                  <input  required  type="number" class="form-control" id="dni" name="dni" data-toggle="tooltip" data-placement="bottom" title="Sin puntos ni coma">
                </div>

                <div class="form-group col-md-4">
                  <label for="estado_civil">Estado Civil</label>
                  <select name="estado_civil" id="estado_civil" class="form-control">
                       <option value="Soltero">Soltero</option>
								    	 <option value="Casado">Casado</option>
								    	 <option value="Viudo">Viudo</option>
								    	 <option value="Divorciado">Divorciado</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <input  required  type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>
                <div class="form-group col-md-4">
                  <label for="domicilio">Domicilio</label>
                  <input  required  type="text" class="form-control" id="domicilio" name="domicilio" data-toggle="tooltip" data-placement="bottom" title="Av. Siempreviva 742">
                </div>
                <div class="form-group col-md-2">
                  <label for="barrio">Barrio</label>
                  <select  name="barrio" id="barrio" class="form-control">
                  <option value="---">---</option>
                       <option value="Autogestion">Autogestion</option>
								    	 <option value="San Martin">San Martin</option>
								    	 <option value="FONAVI">FONAVI</option>
								    	 <option value="Pro Casa">Pro Casa</option>
								    	 <option value="Solidaridad">Solidaridad</option>
								    	 <option value="N. Kirchner">N. Kirchner</option>
								    	 <option value="A. Abraham">A. Abraham</option>
								    	 <option value="Esperanza">Esperanza</option>
								    	 <option value="Ricardo Luna">Ricardo Luna</option>
								    	 <option value="Sauce Grande">Sauce Grande</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label for="ocupacion">Ocupacion</label>
                  <select name="ocupacion" id="ocupacion" class="form-control">
                      <option value="---">---</option>
                       <option value="En relacion de dependencia">En relacion de dependencia</option>
								    	 <option value="Independiente">Independiente</option>
								    	 <option value="Jubilado">Jubilado</option>
								    	 <option value="Pensionado">Pensionado</option>
								    	 <option value="Estudiante">Estudiante</option>
								    	 <option value="Ama de casa">Ama de casa</option>
								    	 <option value="Desocupado">Desocupado</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
              <div class="form-group col-md-3">
                  <label for="lnacimiento">Lugar de Nacimiento</label>
                  <input  required  type="text" class="form-control" id="lnacimiento"  name="lnacimiento" >
                </div>
                <div class="form-group col-md-3">
                  <label for="telefono">Tel.</label>
                  <input  required  type="number" class="form-control" id="telefono"  name="telefono" >
                </div>
                <div class="form-group col-md-3">
                  <label for="celular">Cel</label>
                  <input   type="number" class="form-control" id="celular" name="celular">
                </div>
                <div class="form-group col-md-3">
                  <label for="email">E-mail</label>
                  <input  type="text" class="form-control" id="email" name="email" data-toggle="tooltip" data-placement="bottom" title="Ej. juan@softweare.com.ar">
                </div>
              </div>              
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="anios">Años en MH</label>
                  <input  required  type="text" class="form-control" id="anios" name="anios" data-toggle="tooltip" data-placement="bottom" title="Ej: 15">
                </div>
                <div class="form-group col-md-3">
                  <label for="ingresos">Ingresos</label>
                  <input   type="text" class="form-control" id="ingresos" name="ingresos" data-toggle="tooltip" data-placement="bottom" title="Monto de ingresos. Indicar siempre un monto.">
                </div>
                <div class="form-group col-md-6">
                  <label for="nacionalidad">Nacionalidad</label>
                  <input  type="text" class="form-control" id="nacionalidad" name="nacionalidad" data-toggle="tooltip" data-placement="bottom" title="Ej: Argentina/Chilena/Italiana (La nacionalidad siempre va en femenino)">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="educacion">Educacion</label>
                  <select name="educacion" id="educacion" class="form-control">
                       <option value="Primario Completo">Primario Completo</option>
								    	 <option value="Primario Incompleto">Primario Incompleto</option>
								    	 <option value="Primario En Curso">Primario En Curso</option>
								    	 <option value="Secundario Completo">Secundario Completo</option>
								    	 <option value="Secundario Incompleto">Secundario Incompleto</option>
								    	 <option value="Secundario En Curso">Secundario En Curso</option>
								    	 <option value="Terciario Completo">Terciario Completo</option>
								    	 <option value="Terciario Incompleto">Terciario Incompleto</option>
								    	 <option value="Terciario En Curso">Terciario En Curso</option>
								    	 <option value="Universitario Completo">Universitario Completo</option>
								    	 <option value="Universitario Incompleto">Universitario Incompleto</option>
								    	 <option value="Universitario En Curso">Universitario En Curso</option>
                  </select>
                </div> 
                <div class="form-group col-md-4">
                  <label for="institucion">Institucion</label>
                  <select name="institucion" id="institucion" class="form-control">
                     <option value="---">---</option>
								    	  <option value="Escuela Primaria 1">Escuela Primaria 1</option>
								    	  <option value="Escuela Primaria 2">Escuela Primaria 2</option>
                        <option value="Escuela Primaria 3">Escuela Primaria 3</option>
                        <option value="Escuela Secundaria 1">Escuela Secundaria 1</option>
                        <option value="Escuela Secundaria 2">Escuela Secundaria 2</option>
                        <option value="Escuela Tecnica">Escuela Tecnica</option>
                        <option value="Escuela Especial">Escuela Especial</option>
                        <option value="Jardin de Infantes 1">Jardin de Infantes 1</option>
                        <option value="Jardin de Infantes 2">Jardin de Infantes 2</option>
                        <option value="Jardin de Infantes 3">Jardin de Infantes 3</option>
                        <option value="JIRIMM Sauce Grande">JIRIMM Sauce Grande</option>
                        <option value="Escuela Rural Pedro Hauguer">Escuela Rural Pedro Hauguer</option>
                        <option value="CENS">CENS</option>
                  </select>
                </div> 
                <div class="form-group col-md-4">
                  <label for="otra">Otra Inst.</label>
                  <select name="otra" id="otra" class="form-control">
                       <option value="---">---</option>
								    	 <option value="CEC">CEC</option>
								    	 <option value="Guarderia">Guarderia</option>
										   <option value="Envion">Envion</option>
								    	 <option value="Centro Formacion Profesional">Centro Formacion Profesional</option>
                  </select>
                </div>                
              </div>

              <ul id="menu-2" class="nav nav-tabs" style="cursor:pointer;">
                <li  class="nav-item">
                  <a class="nav-link item2" href="#Grupo">Grupo</a>                  
                </li>
                <li class="nav-item">
                  <a class="nav-link item2" href="#Asistencias">Asistencias</a>
                </li>
                <li class="nav-item">
                  <a  class="nav-link item2" href="#Documentos">Documentos</a>
                </li>
                <li class="nav-item">
                  <a  class="nav-link item2" href="#Encuestas">Encuestas</a>
                </li>
                <li class="nav-item">
                  <a  class="nav-link item2" href="#Observaciones">Observaciones</a>
                </li>
             </ul>

              <!-- Paneles de pestañas ocultos -->             
            <div class="tab-content border mb-3">   
             <div id="Grupo" class="container tab-pane fade"><br>
             <button type="button" class="btn btn-primary mb-2" onclick="NuevoIntegrante();">Nuevo Integrante</button>  <br>
              <table class="table table-hover" id="tabla-grupo">
                  <thead>
                    <tr>
                      <th scope="col">Nombre</th>
                      <th scope="col">DNI</th>
                      <th scope="col">Vinculo</th>
                      <th scope="col">F. Nacim.</th>
                      <th scope="col">Ocupacion</th>
                      <th scope="col">Ingresos</th>
                      <th scope="col">N. Educativo</th>
                      <th scope="col">Institucion</th>
                      <th scope="col">Otra</th>
                    </tr>
                  </thead>
                  <tbody>                      
                  </tbody>
                </table>
             </div>        
              
              <div id="Asistencias" class="container tab-pane fade"><br>
              <button type="button" class="btn btn-primary mb-2" onclick="NuevaAsistencia();">Nueva Asistencia</button>  <br>
                <table class="table table-hover" id="tabla-asistencias">
                  <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Observaciones</th>
                        <th>Fecha Sol.</th>
                        <th>Fecha Ult. Estado</th>
                        <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>                      
                  </tbody>
                </table>
              </div>
              <div id="Documentos" class="container tab-pane fade"><br>
                  <button type="button" class="btn btn-primary mb-2" onclick="NuevoDocumento();">Nuevo Documento</button>  <br>

                  <table class="table table-hover" id="tabla-documentos">
                  <thead>
                    <tr>
                      <th scope="col">Descripcion</th>
                      <th scope="col">URL</th>
                      <th scope="col">Abrir</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>                      
                  </tbody>
                </table>
              </div>
              <div id="Encuestas" class="container tab-pane fade"><br>
                 <table class="table table-hover" id="tabla-encuestas" >
                 <button type="button" class="btn btn-primary mb-2" onclick="NuevaEncuesta();">Nueva Encuesta</button>  <br>

                  <thead>
                    <tr>
                      <th scope="col">Fecha</th>
                      <th scope="col">Año</th>
                      <th scope="col">Realizada Por</th>
                      <th scope="col">Abrir</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>                      
                  </tbody>
                </table>
              </div>       
              <div id="Observaciones" class="container tab-pane fade mb-2"><br>
                <p class="lead">Recuerde que estas observaciones son de uso INTERNO y que no se veran reflejadas en la encuesta</p>
                 <textarea id="texto_observaciones" class="form-control"></textarea>
              </div>               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button hidden type="button" name="actualizar" id="actualizar" class="btn btn-primary btn2" onclick="ActualizarPersona();">Actualizar</button>

        <button hidden type="button" name="guardar_persona" id="guardar_persona" class="btn btn-primary btn2" onclick="GuardarPersona();">Guardar</button>
      </div>

    </div>
  </div>
        </form>
</div>

<!--Aca voy a poner un form flotante para ver Ficha del integrante del Grupo Familiar-->
<div class="modal" id="VerIntegrante" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Integrante del Grupo Familiar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body formulario">
      <form id="form-familiar" method="post" action="Buscar.php">
            <input hidden type="number" class="form-control" id="id_familiar" name="id_familiar"  placeholder="Ej: Juan">
            <input hidden type="text" class="form-control" id="dni_familiar" name="dni_familiar"  placeholder="Ej: Juan">
              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="nombre_familiar">Nombre</label>
                  <input  required  type="text" class="form-control" id="nombre_familiar" name="nombre_familiar"  data-toggle="tooltip" data-placement="bottom" title="Ej. Juan">
                </div>
              
                <div class="form-group col-md-3">
                  <label for="dni_familiar2">DNI</label>
                  <input  required  type="number" class="form-control" id="dni_familiar2" name="dni_familiar2" data-toggle="tooltip" data-placement="bottom" title="Sin puntos ni coma">
                </div>

                <div class="form-group col-md-4">
                  <label for="vinculo_familiar">Vinculo</label>
                  <input  required  type="text" class="form-control" id="vinculo_familiar" name="vinculo_familiar" data-toggle="tooltip" data-placement="bottom" title="Ej. Esposa / Hija">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="fecha_nacimiento_familiar">Fecha de Nacimiento</label>
                  <input  required  type="date" class="form-control" id="fecha_nacimiento_familiar" name="fecha_nacimiento_familiar">
                </div>
                <div class="form-group col-md-4">
                  <label for="ocupacion_familiar">Ocupacion</label>
                  <select name="ocupacion_familiar" id="ocupacion_familiar" class="form-control">
                       <option value="---">---</option>
                       <option value="En relacion de dependencia">En relacion de dependencia</option>
								    	 <option value="Independiente">Independiente</option>
								    	 <option value="Jubilado">Jubilado</option>
								    	 <option value="Pensionado">Pensionado</option>
								    	 <option value="Estudiante">Estudiante</option>
								    	 <option value="Ama de casa">Ama de casa</option>
								    	 <option value="Desocupado">Desocupado</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="ingresos_familiar">Ingresos</label>
                  <input  required  type="text" class="form-control" id="ingresos_familiar" name="ingresos_familiar" data-toggle="tooltip" data-placement="bottom" title="Ingresar valores enteros. En caso de no tener, ingresar 0">
                </div>
              </div>     
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="educacion_familiar">Educacion</label>
                  <select name="educacion_familiar" id="educacion_familiar" class="form-control">
                        <option value="---">---</option>
                       <option value=">Jardin de Infantes">Jardin de Infantes</option>
                       <option value="Primario Completo">Primario Completo</option>
								    	 <option value="Primario Incompleto">Primario Incompleto</option>
								    	 <option value="Primario En Curso">Primario En Curso</option>
								    	 <option value="Secundario Completo">Secundario Completo</option>
								    	 <option value="Secundario Incompleto">Secundario Incompleto</option>
								    	 <option value="Secundario En Curso">Secundario En Curso</option>
								    	 <option value="Terciario Completo">Terciario Completo</option>
								    	 <option value="Terciario Incompleto">Terciario Incompleto</option>
								    	 <option value="Terciario En Curso">Terciario En Curso</option>
								    	 <option value="Universitario Completo">Universitario Completo</option>
								    	 <option value="Universitario Incompleto">Universitario Incompleto</option>
								    	 <option value="Universitario En Curso">Universitario En Curso</option>
                  </select>
                </div> 
                <div class="form-group col-md-4">
                  <label for="institucion_familiar">Institucion</label>
                  <select name="institucion_familiar" id="institucion_familiar" class="form-control">
                     <option value="---">---</option>
								    	  <option value="Escuela Primaria 1">Escuela Primaria 1</option>
								    	  <option value="Escuela Primaria 2">Escuela Primaria 2</option>
                        <option value="Escuela Primaria 3">Escuela Primaria 3</option>
                        <option value="Escuela Secundaria 1">Escuela Secundaria 1</option>
                        <option value="Escuela Secundaria 2">Escuela Secundaria 2</option>
                        <option value="Escuela Tecnica">Escuela Tecnica</option>
                        <option value="Escuela Especial">Escuela Especial</option>
                        <option value="Jardin de Infantes 1">Jardin de Infantes 1</option>
                        <option value="Jardin de Infantes 2">Jardin de Infantes 2</option>
                        <option value="Jardin de Infantes 3">Jardin de Infantes 3</option>
                        <option value="JIRIMM Sauce Grande">JIRIMM Sauce Grande</option>
                        <option value="Escuela Rural Pedro Hauguer">Escuela Rural Pedro Hauguer</option>
                        <option value="CENS">CENS</option>
                  </select>
                </div> 
                <div class="form-group col-md-4">
                  <label for="otra_familiar">Otra Inst.</label>
                  <select name="otra_familiar" id="otra_familiar" class="form-control">
                       <option value="---">---</option>
								    	 <option value="CEC">CEC</option>
								    	 <option value="Guarderia">Guarderia</option>
										   <option value="Envion">Envion</option>
								    	 <option value="Centro Formacion Profesional">Centro Formacion Profesional</option>
                  </select>
                </div>                
              </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button hidden type="button" name="actualizar_familiar" id="actualizar_familiar" class="btn btn-primary" onclick="ActualizarFamiliar();">Actualizar</button>
        <button hidden type="button" name="borrar_familiar" id="borrar_familiar" class="btn btn-primary bg-danger" onclick="BorrarFamiliar();">Borrar</button>
        <button hidden type="button" name="nuevo_familiar" id="nuevo_familiar" class="btn btn-primary" onclick="NuevoFamiliar();">Guardar</button>
                  
      </div>

    </div>
  </div>
        </form>
</div>
<!--Aca voy a poner un form flotante para ver el documento tipo Popup-->
<div class="modal" id="MostrarImagen" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ver Imagen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="ImagenHC_1" height="400px" width="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Aca voy a poner un form flotante para nuevo documento tipo Popup-->
<div class="modal" id="NuevoDocumento" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" id="formNuevoDocumento">
        <div class="form-row">
                     <div class="form-group col-md-12">
                        <label for="ImagenHC">Documento</label>
                       <input type="file" required class="form-control" id="ImagenHC" name="ImagenHC" placeholder="Ej: Tratamiento de Conducto...">
                      </div>
        </div>
        <div class="form-row">
                     <div class="form-group col-md-12">
                        <label for="DescripcionDocumento">Descripcion</label>
                       <input type="text" required class="form-control" id="DescripcionDocumento" name="DescripcionDocumento" placeholder="Ej: DNI Frente">
                      </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="CerrarDocumento();">Cerrar</button>
        <button type="button" class="btn btn-primary"  onclick="CargarDocumento();" data-dismiss="modal">Cargar Documento</button>
      </div>
    </div>
  </div>
</div>
<!--Aca voy a poner un form flotante para Abrir Asistencia tipo Popup-->

<div class="modal mt-5" id="AbrirAsistencia" tabindex="-1" role="dialog" >
  <div class="modal-dialog mt-5" role="document" > 
    <div class="modal-content" style="background:#FCFBC9;">
      <div class="modal-header">
        <h5 class="modal-title">Abrir Asistencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_asistencias">
            <input hidden type="number" id="id_asistencia">
            <input hidden type="number" id="id_persona_4">
            <input hidden type="text" id="id_persona_3">
            <input hidden type="date" id="fecha_modificacion" value="<?php echo date('Y-m-d');?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tipo_asistencia">Tipo de Asistencia</label>
                    <select disabled name="tipo_asistencia" id="tipo_asistencia" class="form-control">
                        <option value="PASAJES">PASAJES</option>
                        <option value="MEDICACION">MEDICACION</option>
                        <option value="CONSTRUCCION">CONSTRUCCION</option>
                        <option value="MERCADERIA">MERCADERIA</option>
                        <option value="DIETAS">DIETAS</option>
                        <option value="SUBSIDIOS">SUBSIDIOS</option>
                        <option value="GARRAFAS">GARRAFAS</option>
                        <option value="SUMINISTRO DE AGUA">SUMINISTRO DE AGUA</option>
                        <option value="BECAS">BECAS</option>	
                        <option value="PLAN MAS VIDA">PLAN MAS VIDA</option>	
                        <option value="EXENCION DE IMPUESTOS">EXENCION DE IMPUESTOS</option>			
                        <option value="PASE LIBRE DISCAPACIDAD">PASE LIBRE DISCAPACIDAD</option>	
                        <option value="CASA DEL ESTUDIANTE">CASA DEL ESTUDIANTE</option>	
                        <option value="OTRO">OTRO</option>
				          	</select> 
                </div> 
                <div class="form-group col-md-4">
                    <label for="monto_asistencia">Monto</label>
                    <input type="text" id="monto_asistencia" class="form-control" value="0">
                </div>
                <div class="form-group col-md-4">
                    <label for="fecha_asistencia">Fecha</label>
                    <input type="date" id="fecha_asistencia" class="form-control" value="<?php echo date('Y-m-d');?>">

                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="estado_asistencia">Estado</label>
                    <select name="estado_asistencia" id="estado_asistencia" class="form-control">
                        <option value="SOLICITADA">SOLICITADA</option>
						<option value="EMITIDA">EMITIDA</option>
						<option value="RECHAZADA">RECHAZADA</option>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <label for="observaciones_asistencia">Observaciones</label>
                    <textarea name="observaciones_asistencia" id="observaciones_asistencia" class="form-control">---</textarea>
                </div>
            </div>
            
        </form>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button hidden type="button" class="btn btn-primary" id="actualizar_asistencia" onclick="ActualizarAsistencia();">Actualizar</button>
        <button hidden type="button" class="btn btn-primary bg-danger" id="borrar_asistencia" onclick="BorrarAsistencia();">Borrar</button>
        <button hidden type="button" class="btn btn-primary" id="guardar_asistencia" onclick="GuardarAsistencia();">Guardar</button>

      </div>
    </div>
  </div>
</div>

<!--Aca voy a poner un form flotante para Clave Asistencia tipo Popup-->

<div class="modal mt-5" id="Acceder" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese contraseña de Supervisor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input hidden type="text" id="id_asistencia_borrar">
          <input hidden type="text" id="id_persona_borrar">
          <div class="alert alert-danger" role="alert">
			  RECUERDE QUE ESTA ACCEDIENDO A UN AREA RESTRINGIDA DEL SISTEMA <hr>
			  SOLO PUEDEN INGRESAR LOS USUARIOS CON ACCESO PERMITIDO. 
          </div>
          <label for="password">Ingrese la contraseña</label>
          <input type="password" id="password" name="password" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" style="background:red;" onclick="EliminarDefinitivo();">Eliminar</button>

      </div>
    </div>
  </div>
</div>

<!--Aca voy a poner un form flotante para Clave Asistencia tipo Popup-->

<div class="modal mt-5" id="Acceder2" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese contraseña de Supervisor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input hidden type="text" id="id_encuesta_borrar">
          <div class="alert alert-danger" role="alert">
			  RECUERDE QUE ESTA ACCEDIENDO A UN AREA RESTRINGIDA DEL SISTEMA <hr>
			  SOLO PUEDEN INGRESAR LOS USUARIOS CON ACCESO PERMITIDO. 
          </div>
          <label for="password">Ingrese la contraseña</label>
          <input type="password" id="password2" name="password2" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" style="background:red;" onclick="EliminarEncuestaDefinitivo();">Eliminar</button>

      </div>
    </div>
  </div>
</div>

<!--Aca voy a poner un form flotante para crear encuesta -->
<div class="modal" id="NuevaEncuesta" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-xl" role="document">
    <div class="modal-content" style="background:#FCFBC9;">
      <div class="modal-header">
        <h5 class="modal-title text-center">Nueva Encuesta <?php echo date("Y");?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body formulario">
        <form id="form-encuesta" method="post">
              <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tipo_vivienda">Tipo de Vivienda</label>
                    <select name="tipo_vivienda" id="tipo_vivienda" class="form-control">
                       <option value="Casa">Casa</option>
								    	 <option value="'Departamento">Departamento</option>
								    	 <option value="Casilla">Casilla</option>
								    	 <option value="Rancho">Rancho</option>
								    	 <option value="Pieza en Inquilanato">Pieza en Inquilanato</option>
								    	 <option value="Vivienda Movil">Vivienda Movil</option>
								    	 <option value="Local no construido para habitacion">Local no construido para habitacion</option>
								    	 <option value="Habitacion independiente">Habitacion independiente</option>
				          	</select> 
                </div> 
                <div class="form-group col-md-4">
                    <label for="tenencia_vivienda">Tenencia</label>
                    <select name="tenencia_vivienda" id="tenencia_vivienda" onchange="VerificarTenencia();" class="form-control">
                    <option value="Propia">Propia</option>
								    	 <option value="Alquilada">Alquilada</option>
								    	 <option value="Cedida">Cedida</option>
								    	 <option value="Prestada">Prestada</option>
								    	 <option value="Ocupada">Ocupada</option>
				          	</select> 
                </div>
                <div hidden id="monto_tenencia_d" class="form-group col-md-4">
                    <label for="monto_tenencia">Monto</label>
                    <input type="number" id="monto_tenencia" name="monto_tenencia" class="form-control" value="0">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="material_pisos">Material del Piso</label>
                    <select  name="material_pisos" id="material_pisos" class="form-control">
                       <option value="Cerámica, Baldosa o Madera">Cerámica, Baldosa o Madera</option>
								    	 <option value="Cemento">Cemento</option>
								    	 <option value="Tierra">Tierra</option>
								    	 <option value="Otra">Otra</option>
				          	</select> 
                </div> 
                <div class="form-group col-md-4">
                    <label for="material_paredes">Material de Paredes</label>
                    <select  name="material_paredes" id="material_paredes" class="form-control">
                       <option value="Ladrillo, Piedra, Bloques u Hormigón">Ladrillo, Piedra, Bloques u Hormigón</option>
								    	 <option value="Madera">Madera</option>
								    	 <option value="Chapa">Chapa</option>
								    	 <option value="Otro">Otro</option>
				          	</select> 
                </div>
                <div class="form-group col-md-4">
                    <label for="cubiera_exterior">Material de Cubierta Ext. Techo</label>
                    <select  name="cubiera_exterior" id="cubiera_exterior" class="form-control">
                       <option value="Cubierta asfaltica o membrana">Cubierta asfaltica o membrana</option>
								    	 <option value="Losa">Losa</option>
								    	 <option value="Chapa">Chapa</option>
								    	 <option value="Otro">Otro</option>
				          	</select> 
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="rev_interior">Tiene Rev. Interior o Cielorraso?</label>
                    <select  name="rev_interior" id="rev_interior" class="form-control">
                       <option value="SI">SI</option>
								    	 <option value="NO">NO</option>
				          	</select> 
                </div> 
                <div class="form-group col-md-4">
                    <label for="electricidad">Electricidad</label>
                    <select  name="electricidad" id="electricidad" class="form-control">
                       <option value="Red de Energia Eléctrica">Red de Energia Eléctrica</option>
								    	 <option value="Por generacion propia o motor">Por generacion propia o motor</option>
								    	 <option value="Conexion irregular">Conexion irregular</option>
				          	</select> 
                </div>
                <div class="form-group col-md-4">
                    <label for="agua">Agua</label>
                    <select  name="agua" id="agua" class="form-control">
                       <option value="Conexion domiciliaria de Red Publica">Conexion domiciliaria de Red Publica</option>
								    	 <option value="Pozo">Pozo</option>
								    	 <option value="Pileta publica fuera del terreno">Pileta publica fuera del terreno</option>
				          	</select> 
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="desague">Desague</label>
                    <select  name="desague" id="desague" class="form-control">
                       <option value="Cloacas">Cloacas</option>
								    	 <option value="Camara septica y pozo ciego">Camara septica y pozo ciego</option>
								    	 <option value="Pozo ciego">Pozo ciego</option>
								    	 <option value="Hoyo o excavacion en la tierra">Hoyo o excavacion en la tierra</option>
				          	</select> 
                </div> 
                <div class="form-group col-md-4">
                    <label for="gas">Gas</label>
                    <select  name="gas" id="gas" class="form-control">
                       <option value="Gas de red">Gas de red</option>
								    	 <option value="Tubo o garrafa">Tubo o garrafa</option>
								    	 <option value="No tiene">No tiene</option>
				          	</select> 
                </div>
                <div class="form-group col-md-2">
                    <label for="otros_ingresos">Otros Ingresos</label>
                    <input type="number" class="form-control" id="otros_ingresos" value="0" name="otros_ingresos" data-toggle="tooltip" data-placement="bottom" title="Numero entero. Si no posee, ingrese 0">
                </div>
                <div class="form-group col-md-2">
                    <label for="otros_bienes">Otros Bienes</label>
                    <input type="text" class="form-control" id="otros_bienes" name="otros_bienes" value="--" data-toggle="tooltip" data-placement="bottom" title="Ej: Auto /  Casa">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-1">
                    <label for="sepelio">Sepelio?</label>
                    <select  name="sepelio" id="sepelio" class="form-control" onchange="VerificarSepelios();">
                       <option value="SI">SI</option>
                       <option value="NO">NO</option>
				          	</select> 
                </div> 
                <div id="sepelio_nombre_d" class="form-group col-md-2">
                    <label for="sepelio_nombre">Cual?</label>
                    <input type="text" class="form-control" id="sepelio_nombre" name="sepelio_nombre" value="--" data-toggle="tooltip" data-placement="bottom" title="Ej: Lavios">
                </div>
                <div class="form-group col-md-1">
                    <label for="os">O.Social?</label>
                    <select  name="os" id="os" class="form-control" onchange="VerificarOS();">
                       <option value="SI">SI</option>
                       <option value="NO">NO</option>
				          	</select> 
                </div> 
                <div id="osocial_d" class="form-group col-md-2">
                    <label for="osocial">Cual?</label>
                    <input type="text" class="form-control" id="osocial" value="--" name="osocial" data-toggle="tooltip" data-placement="bottom" title="Ej: OSDE / IOMA">
                </div>

                <div class="form-group col-md-3">
                    <label for="salud">Salud</label>
                    <input type="text" class="form-control" id="salud" name="salud" data-toggle="tooltip" value="--" data-placement="bottom" title="Sale impreso en la encuesta">
                </div>
                <div class="form-group col-md-3">
                    <label for="observaciones">Observaciones</label>
                    <input type="text" class="form-control" id="observaciones" name="observaciones" data-toggle="tooltip" value="--" data-placement="bottom" title="Sale impreso en la encuesta">
                </div>
            </div>

            
        </form>                      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" name="nueva_encuesta" id="nueva_encuesta" class="btn btn-primary" onclick="GuardarEncuesta();">Guardar Encuesta</button>
      </div>
      </form>
    </div>
  </div>       
</div>
   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js" ></script> 
  <script src="Buscar.js" ></script> 
  <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

      $(document).ready(function(){
      $(".nav-tabs a").click(function(){
        $(this).tab('show');
      });
      });
    </script>
</body>
</html>