<?php

require_once "../../PDO.php";

$datos =$_POST['valorBusqueda'];

$EliminarDocumento=$conexion->prepare("DELETE FROM docs_slocal WHERE ID=:id");
$EliminarDocumento->bindParam(':id',$datos);
$EliminarDocumento->execute();

?>