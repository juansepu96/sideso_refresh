<?php

require_once "PDO.php";
$ObtenerCabeceras = $conexion->query("SELECT * FROM personas");

foreach($ObtenerCabeceras as $Cabecera){
    $ExisteEnGrupos = $conexion -> prepare("SELECT * FROM grupos WHERE dni=:dni");
    $ExisteEnGrupos->bindParam(':dni',$Cabecera['dni']);
    $ExisteEnGrupos->execute();
    if($ExisteEnGrupos->RowCount()>0){
        echo $Cabecera['dni']."<br>";
    }
}


?>