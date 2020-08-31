<?php

require_once "../PDO.php";

$dato=$_POST['valorBusqueda'];

$ObtenerIntervenciones=$conexion->prepare("SELECT * from intervenciones WHERE persona_ID=:dato ORDER BY fecha DESC");
$ObtenerIntervenciones -> bindParam(':dato',$dato);
$ObtenerIntervenciones->execute();
if($ObtenerIntervenciones -> RowCount()>0){
    $result = $ObtenerIntervenciones->fetchAll(\PDO::FETCH_ASSOC);
    print_r (json_encode($result));    
}else{
    echo "\nPDO::errorInfo():\n";
    print_r($ObtenerIntervenciones->errorInfo());
}



?>