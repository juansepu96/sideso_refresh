<?php 
require_once "PDO.php";

$asistencia=$_POST['valorBusqueda'];
$rta="";
        $ObtenerDocs=$conexion->prepare("SELECT * from docs WHERE dni=:dni");
		$ObtenerDocs->bindParam(':dni',$asistencia);
		$ObtenerDocs->execute();

	foreach ($ObtenerDocs as $Doc) {
        $id=$Doc['ID'];
        $url=$Doc['url'];
        $detalle=$Doc['detalle'];
        $rta=$rta."@#".$id."@#".$url."@#".$detalle."@#";
	}

    echo $rta;

?>