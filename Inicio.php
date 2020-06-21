<?php

require_once "PDO.php";

$hora=date("G");

$hora=intval($hora);

 if ($hora>5 and $hora<=13){
				$saludo='Buenos Dias';
			}else{
				if($hora>=13 and $hora<20){
					$saludo='Buenas Tardes';
				}else{
					if($hora>=20 and $hora<=23){
						$saludo='Buenas Noches';
					}else{
						if($hora>=0 and $hora<=5){
							$saludo='Buenas Noches';
						}
				}
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
    
    <title>Menu Principal - SiDeSo v2.0</title>
  </head>
  <body>
      <div class="container">
                          
         <div class="d-flex justify-content-center h-100">   
                      
            <div class="card2">        
            <div class="mt-4">
                    <h2 class="welcome"><?php echo $saludo.' '.$_SESSION['nombre'].' !';?></h2>
                </div>           
                <div class="row">
                    <div class="col ml-5">
                        <a href="Buscar.php" class="ml-5" data-toggle="tooltip" data-placement="bottom" title="Personas"><i class="fas fa-users fa-10x icono"></i></a>
                    </div>
                    <div class="col  ml-5">
                    <a href="Estadisticas.php" class="ml-5" data-toggle="tooltip" data-placement="bottom" title="Estadisticas"><i class="fas fa-chart-pie fa-10x icono"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col  ml-5">
                        <a href="Backups.php"  class="ml-5"  data-toggle="tooltip" data-placement="bottom" title="Copia de Seguridad"><i class="fas fa-server fa-10x icono" ></i></a>
                    </div> 
                    <div class="col  ml-5">
                        <a href="Cerrar.php" class="ml-5" data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesion"><i class="fas fa-times-circle fa-10x icono"></i></a>
                    </div>

                </div>
            </div>
         </div>
        </div>
   

   
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" ></script>
    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
  </body>
</html>