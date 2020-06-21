<?php

require_once "PDO.php";

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
    
    <title>Nueva Encuesta - SiDeSo v2.0</title>
</head>
<body  onload="$('#Acceder').modal('show');">

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
      <li class="nav-item active ">
        <a class="nav-link" href="Nueva.php">Nueva</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Buscar.php">Buscar</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Asistencias.php">Asistencias</a>
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
    
   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js" ></script> 
	<script src="Backups.js" ></script> 
</body>
</html>