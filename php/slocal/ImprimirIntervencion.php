<?php

require_once "../../PDO.php";

$intervencion=$_SESSION['id.print'];

$persona=$_SESSION['id2.print'];

$ObtenerPersona=$conexion->prepare("SELECT * FROM personas_slocal WHERE ID=:id");
$ObtenerPersona->bindParam(':id',$persona);
$ObtenerPersona->execute();
foreach($ObtenerPersona as $datos){
    $nombre=$datos['nombre'];
    $DNI=$datos['DNI'];
    $fnac=$datos['date'];
    $legajo=$datos['legajo'];
    $domicilio=$datos['domicilio'];
    $telefono=$datos['telefono'];
}


$ObtenerIntervencion=$conexion->prepare("SELECT * FROM intervenciones_slocal WHERE ID=:id");
$ObtenerIntervencion->bindParam(':id',$intervencion);
$ObtenerIntervencion->execute();
foreach($ObtenerIntervencion as $datos){
    $id=$datos['ID'];
    $finter=$datos['fecha'];
    $intervino=$datos['intervino'];
    $detalle=$datos['detalle'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargar intervencion</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"> 
    <style>
        .borde{
            border:3px solid rgba(0,0,0,0.7);
        }
    </style>
</head>
<body onload="Imprimir();">

    <div id="contenido" class="row mt-2"> 
        <div class="col-6" style="text-align:center;">
            <img src="../../logo A.jpg">
        </div>
        <div class="col-6 mt-5" style="text-align:center;">
            <h2>SERVICIO LOCAL </h2>
        </div>
    </div>

    <div class="mr-5 ml-5 mt-2 mp-2 p-4 borde" >
        <div class="row">
            <div class="col-4">
                <h5>NOMBRE: <?php echo $nombre;?></h5>
            </div>
            <div class="col-4">
                <h5>DNI: <?php echo $DNI;?></h5>
            </div>
            <div class="col-4">
                <h5>FECHA DE NACIMIENTO: <?php echo date("d/m/Y", strtotime($fnac));?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                    <h5>N° DE LEGAJO: <?php echo $legajo;?></h5>
            </div>
            <div class="col-4">
                    <h5>DOMICILIO: <?php echo $domicilio;?></h5>
            </div>
            <div class="col-4">
                <h5>TELEFONO: <?php echo $telefono;?></h5>
            </div>
        </div>
        <h5 class="text-center">-------------------------------------------------------------------------</h5>
        <div class="row">
            <div class="col-4">
                <h5>N° DE INTERVENCION: <?php echo "000".$id;?></h5>
            </div>
            <div class="col-4">
                <h5>FECHA DE INTERVENCIÓN: <?php echo date("d/m/Y", strtotime($finter));?></h5>
            </div>
            <div class="col-4">
                <h5>INTERVINO: <?php echo $intervino;?></h5>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <p><?php echo $detalle;?></p>
            <div>
        </div>

        <div class="row mt-5 pt-5">
            <div class="col-4">
                
            </div>
            <div class="col-4">
                
            </div>
            <div class="col-4 text-center">
                <h5>________________________</h5>
                <h5>FIRMA Y ACLARACIÓN</h5>
            </div>
        </div>
    </div>

</div>

<script>
    function Imprimir(){
        self.print(); 
        self.onmouseover = () => { window.close(); } 
    }
</script>

    
</body>
</html>
