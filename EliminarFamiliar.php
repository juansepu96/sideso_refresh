<?php

require_once "PDO.php";

$datos =$_POST['valorBusqueda'];

$EliminarAsistencia=$conexion->prepare("DELETE FROM grupos WHERE ID=:id");
$EliminarAsistencia->bindParam(':id',$datos);
if($EliminarAsistencia->execute()){
    echo "OK";
}else{
    echo "NO";
}

?>