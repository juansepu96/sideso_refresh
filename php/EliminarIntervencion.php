<?php

require_once "../PDO.php";

$datos =$_POST['valorBusqueda'];

$EliminarIntervencion=$conexion->prepare("DELETE FROM intervenciones WHERE ID=:id");
$EliminarIntervencion->bindParam(':id',$datos);
if($EliminarIntervencion->execute()){
    echo "OK";
}else{
    echo "NO";
}

?>