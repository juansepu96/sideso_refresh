<?php  
    
    require_once "PDO.php";

    $datos =$_POST['valorBusqueda'];
    
    $datos = explode("@#",$datos);

    $ultima_encuesta="0";

    $obs="";

    $CargarPersona=$conexion->prepare("INSERT INTO personas (nombre,dni,estado_civil,fnacimiento,lnacimiento,anios,ocupacion,ingresos,domicilio,tel_fijo,tel_cel,email,ult_encuesta,nacionalidad,barrio,educacion,institucion,otra,obs) VALUES (:nombre,:dni,:estado_civil,:fnacimiento,:lnacimiento,:anios,:ocupacion,:ingresos,:domicilio,:tel_fijo,:tel_cel,:email,:ult_encuesta,:nacionalidad,:barrio,:educacion,:institucion,:otra,:obs)");
    $CargarPersona->bindParam(':nombre',$datos[0]);
    $CargarPersona->bindParam(':dni',$datos[1]);
    $CargarPersona->bindParam(':estado_civil',$datos[2]);
    $CargarPersona->bindParam(':fnacimiento',$datos[3]);
    $CargarPersona->bindParam(':lnacimiento',$datos[4]);
    $CargarPersona->bindParam(':anios',$datos[11]);
    $CargarPersona->bindParam(':ocupacion',$datos[7]);
    $CargarPersona->bindParam(':ingresos',$datos[12]);
    $CargarPersona->bindParam(':domicilio',$datos[5]);
    $CargarPersona->bindParam(':tel_fijo',$datos[8]);
    $CargarPersona->bindParam(':tel_cel',$datos[9]);
    $CargarPersona->bindParam(':email',$datos[10]);
    $CargarPersona->bindParam(':ult_encuesta',$ultima_encuesta);
    $CargarPersona->bindParam(':nacionalidad',$datos[13]);
    $CargarPersona->bindParam(':barrio',$datos[6]);
    $CargarPersona->bindParam(':educacion',$datos[14]);
    $CargarPersona->bindParam(':institucion',$datos[15]);
    $CargarPersona->bindParam(':otra',$datos[16]);
    $CargarPersona->bindParam(':obs',$obs);
    if($CargarPersona->execute()){
        echo "OK";
    }else{
        echo "NO";
    }
                    
?>