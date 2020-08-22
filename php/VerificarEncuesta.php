<?php

require_once "../PDO.php";

$dato=$_POST['valorBusqueda'];

$VerificarEncuesta = $conexion -> prepare ("SELECT * from personas WHERE dni=:dni");
$VerificarEncuesta -> bindParam(':dni',$dato);
$VerificarEncuesta -> execute();

if($VerificarEncuesta->RowCount()>0){
    echo "SI";
}else{
    $VerificarGrupo = $conexion -> prepare ("SELECT * from grupos WHERE dni=:dni");
    $VerificarGrupo -> bindParam(':dni',$dato);
    $VerificarGrupo -> execute();
    if($VerificarGrupo->RowCount()>0){
        echo "SI";
    }else{
        echo "NO";
    }
}

?>