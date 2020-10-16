<?php 

require_once "../../PDO.php";

$dato=$_POST['valorBusqueda'];

$ObtenerDocumentos = $conexion -> prepare ("SELECT * from docs_slocal WHERE persona_ID=:id");
$ObtenerDocumentos -> bindParam(':id',$dato);
$ObtenerDocumentos -> execute();


$result = $ObtenerDocumentos->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>