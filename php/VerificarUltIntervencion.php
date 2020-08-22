<?php 

require_once "../PDO.php";

$dato=$_POST['valorBusqueda'];

$ObtenerUtimaIntervencion = $conexion -> prepare ("SELECT * FROM intervenciones WHERE persona_ID=:id ORDER BY fecha DESC LIMIT 1");
$ObtenerUtimaIntervencion -> bindParam(':id',$dato);
$ObtenerUtimaIntervencion -> execute();

if($ObtenerUtimaIntervencion->RowCount()>0){
    foreach ($ObtenerUtimaIntervencion as $Intervencion){
        $fecha=$Intervencion['fecha'];
        $fecha= date("d/m/Y", strtotime($fecha));
    }
}else{
    $fecha="---";
}

echo $fecha;



?>