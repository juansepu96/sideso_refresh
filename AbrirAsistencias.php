<?php

require_once "PDO.php";

$r="";


    $aobtener=$_POST['valorBusqueda'];
	$ObtenerAsistencias=$conexion->prepare("SELECT * FROM asistencias WHERE dni=:aobtener ORDER BY fecha DESC");
	$ObtenerAsistencias->bindParam(':aobtener',$aobtener);
    $ObtenerAsistencias->execute();
    
    $resultado = $ObtenerAsistencias->RowCount();

    if($resultado>0){
        foreach ($ObtenerAsistencias as $Asistencia){
            $timestamp = strtotime($Asistencia['fecha']);
            $fecha = date("d/m/Y", $timestamp);
            if($Asistencia['fecha_ultima']==null){
                $fecha2="---";
            }else{
                $timestamp = strtotime($Asistencia['fecha_ultima']);
                $fecha2 = date("d/m/Y", $timestamp);
            }
            $r=$r."@#".$Asistencia['ID']."@#".$Asistencia['tipo']."@#".$Asistencia['monto']."@#".$Asistencia['observacion']."@#".$fecha."@#".$fecha2."@#".$Asistencia['estado'];
        }
    }else{
        $r="NO";
    }

    echo $r;

?>