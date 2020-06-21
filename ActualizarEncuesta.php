<?php  
    
    require_once "PDO.php";

    $datos =$_POST['valorBusqueda'];
    
    $datos = explode("@#",$datos);

    if($datos[14]=="NO"){
        $sepelio="NO";
    }else{
        $sepelio=$datos[15];
    }

    $anioactual=date("Y");
    $fecha=date("Y-m-d");
    $realizada_por=$_SESSION['usuario'];
    
    $InsertarEncuesta=$conexion->prepare("UPDATE encuestas SET tipo_vivienda=:tipo_vivienda,condicion_vivienda=:condicion_vivienda,monto=:monto,otros_bienes=:otros_bienes,sepelio=:sepelio,salud=:salud,osocial=:osocial,obrasocial=:obrasocial,observaciones=:observaciones,fecha=:fecha,pisos=:pisos,paredes=:paredes,techo=:techo,revestimiento=:revestimiento,electricidad=:electricidad,agua=:agua,desague=:desague,gas=:gas,otros_ingresos=:otros_ingresos WHERE ID=:id");
    $InsertarEncuesta->bindParam(':id',$datos[0]);
    $InsertarEncuesta->bindParam(':tipo_vivienda',$datos[1]);
	$InsertarEncuesta->bindParam(':condicion_vivienda',$datos[2]);
	$InsertarEncuesta->bindParam(':monto',$datos[3]);
    $InsertarEncuesta->bindParam(':otros_bienes',$datos[13]);   
	$InsertarEncuesta->bindParam(':sepelio',$sepelio);
	$InsertarEncuesta->bindParam(':salud',$datos[19]);
	$InsertarEncuesta->bindParam(':osocial',$datos[17]);
	$InsertarEncuesta->bindParam(':obrasocial',$datos[16]);
	$InsertarEncuesta->bindParam(':observaciones',$datos[18]);
	$InsertarEncuesta->bindParam(':fecha',$fecha);	
	$InsertarEncuesta->bindParam(':pisos',$datos[4]);
	$InsertarEncuesta->bindParam(':paredes',$datos[5]);
	$InsertarEncuesta->bindParam(':techo',$datos[6]);
	$InsertarEncuesta->bindParam(':revestimiento',$datos[7]);
	$InsertarEncuesta->bindParam(':electricidad',$datos[8]);
	$InsertarEncuesta->bindParam(':agua',$datos[9]);	
	$InsertarEncuesta->bindParam(':desague',$datos[10]);
	$InsertarEncuesta->bindParam(':gas',$datos[11]);
	$InsertarEncuesta->bindParam(':otros_ingresos',$datos[12]);

    if($InsertarEncuesta->execute()){
        echo "OK";
    }else{
        echo "NO";
    }
    


?>