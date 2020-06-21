<?php

require_once "PDO.php";

$datos =$_POST['valorBusqueda'];

$datos = explode("@#",$datos);

var_dump ($datos);

    $ActualizarPersona=$conexion->prepare("UPDATE personas SET obs=:obs,lnacimiento=:lnacimiento,dni=:dni,nombre=:nombre,estado_civil=:estadocivil,fnacimiento=:fnacimiento,anios=:anios,ocupacion=:ocupacion,ingresos=:ingresos,domicilio=:domicilio,tel_fijo=:telfijo,tel_cel=:telcel,email=:email,nacionalidad=:nacionalidad,barrio=:barrio,educacion=:educacion,institucion=:institucion,otra=:otra WHERE ID=:id");
    $ActualizarPersona->bindParam(':id',$datos[0]);
    $ActualizarPersona->bindParam(':dni',$datos[2]);
    $ActualizarPersona->bindParam(':nombre',$datos[1]);
    $ActualizarPersona->bindParam(':estadocivil',$datos[3]);
    $ActualizarPersona->bindParam(':fnacimiento',$datos[4]);
    $ActualizarPersona->bindParam(':anios',$datos[11]);
    $ActualizarPersona->bindParam(':ocupacion',$datos[7]);
    $ActualizarPersona->bindParam(':ingresos',$datos[12]);
    $ActualizarPersona->bindParam(':lnacimiento',$datos[18]);
    $ActualizarPersona->bindParam(':domicilio',$datos[5]);
    $ActualizarPersona->bindParam(':telfijo',$datos[8]);
    $ActualizarPersona->bindParam(':telcel',$datos[9]);
    $ActualizarPersona->bindParam(':email',$datos[10]);					
    $ActualizarPersona->bindParam(':nacionalidad',$datos[13]);
    $ActualizarPersona->bindParam(':barrio',$datos[6]);
    $ActualizarPersona->bindParam(':educacion',$datos[14]);
    $ActualizarPersona->bindParam(':institucion',$datos[15]);
    $ActualizarPersona->bindParam(':otra',$datos[16]);
    $ActualizarPersona->bindParam(':obs',$datos[19]);
    if($ActualizarPersona->execute()){
        echo "OK";
    }else{
        echo "NO";
    }

    $dni_anterior = $datos[17];
    $dni_actual = $datos[2];

    if($dni_anterior!=$dni_actual){

         //Vamos a Actualizar Grupo

         $ActualizarGrupo = $conexion -> prepare("UPDATE grupos SET dni_titular=:dni_nuevo WHERE dni_titular=:dni_anterior");
         $ActualizarGrupo -> bindParam(':dni_anterior',$dni_anterior);
         $ActualizarGrupo -> bindParam(':dni_nuevo',$dni_actual);
         $ActualizarGrupo -> execute();

          //Vamos a Actualizar Encuestas

          $ActualizarEncuestas = $conexion -> prepare("UPDATE encuestas SET dni_titular=:dni_nuevo WHERE dni_titular=:dni_anterior");
          $ActualizarEncuestas -> bindParam(':dni_anterior',$dni_anterior);
          $ActualizarEncuestas -> bindParam(':dni_nuevo',$dni_actual);
          $ActualizarEncuestas -> execute();

          //Vamos a Actualizar Docs

          $ActualizarDocs = $conexion -> prepare("UPDATE docs SET DNI=:dni_nuevo WHERE DNI=:dni_anterior");
          $ActualizarDocs -> bindParam(':dni_anterior',$dni_anterior);
          $ActualizarDocs -> bindParam(':dni_nuevo',$dni_actual);
          $ActualizarDocs -> execute();

          //Vamos a Actualizar Asistencias

          $ActualizarDocs = $conexion -> prepare("UPDATE asistencias SET dni=:dni_nuevo WHERE dni=:dni_anterior");
          $ActualizarDocs -> bindParam(':dni_anterior',$dni_anterior);
          $ActualizarDocs -> bindParam(':dni_nuevo',$dni_actual);
          $ActualizarDocs -> execute();

    }

?>