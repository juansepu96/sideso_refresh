<?php

require_once "PDO.php";

$fecha=date("Y-m-d");

$_SESSION['busqueda.array']=array();

$busque='false';


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
		$nombre=strtoupper($persona['nombre']);
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
	if(empty($_SESSION['busqueda.array'])){
		$busque='true';
		$hayresultados='false';
		$mostrar='true';
	}else{
		$busque='true';
		$hayresultados='true';
    }

}



?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">    
    <title>Asistencias - SiDeSo v2.0!</title>
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
      <li class="nav-item ">
        <a class="nav-link" href="Nueva.php">Nueva</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Buscar.php">Buscar</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="Asistencias.php">Asistencias</a>
	  </li> 
	  <li class="nav-item">
        <a class="nav-link" href="Estadisticas.php">Estadisticas</a>
	  </li>
	  <li class="nav-item">
        <a class="nav-link " href="Backups.php">Copias de Seguridad</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Cerrar.php">Cerrar Sesion</a>
      </li> 
           
    </ul>
  </div>
</nav>

    <div class="buscador mt-5 mr-5 ml-5 p-4 ">        
      <h3 class="welcome">BUSCAR POR DNI O NOMBRE DEL TITULAR</h3>
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

    <hr>
    <?php if($busque=='true'){?>
        <div id="Resultados" class="buscador mt-1 mr-5 ml-5 p-4">        
        <h3 class="welcome">RESULTADO DE LA BÚSQUEDA</h3>
            <table class="table table-hover mt-2" style="color:white;">
                 <thead>
                        <tr class="text-center">
                            <th hidden>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>F. Nacimiento</th>
                        </tr>
                 </thead>
                 <tbody>        
                        <?php foreach ($_SESSION['busqueda.array'] as $persona) { ?>
                            <tr class="celda text-center" onclick="Completar('<?php echo $persona[1];?>');">

                                <th><?php echo $persona[1];?></th>
        
                                <th><?php echo $persona[2];?></th>
        
                                <th><?php echo date_format(date_create_from_format('Y-m-d', $persona[3]), 'd/m/Y');?></th>
                        
                            </tr>													
                        <?php } ?>	
                </tbody>
            </table>
        </div>
    <?php } ?>

<div class="modal mt-5" id="VerAsistencias" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ver Asistencias</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input hidden type="text" id="id_persona1">
            <table class="table table-hover formulario m-3" id="ResultadoAsistencias">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="NuevaAsistencia();">Nueva</button>

      </div>
    </div>
  </div>
</div>

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
            <input hidden type="text" id="id_persona">
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
        <button hidden type="button" class="btn btn-primary" id="guardar_asistencia" onclick="Guardar();">Guardar</button>

      </div>
    </div>
  </div>
</div>

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
        <button type="button" class="btn btn-primary" style="background:red;" onclick="EliminarDefinitivo();">Acceder</button>

      </div>
    </div>
  </div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" ></script>
    <script src="Asistencias.js" ></script>
  </body>
</html>