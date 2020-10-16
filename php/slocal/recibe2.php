<?php

$path = '../../docs_slocal/'; // upload directory

        $img = $_FILES['doc_intervencion']['name'];
        $tmp = $_FILES['doc_intervencion']['tmp_name'];
        // get uploaded file's extension
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        // can upload same image using rand function
        $final_image = rand(1000,1000000).$img;
        // check's valid format
            $path = $path.strtolower($final_image); 
            if(move_uploaded_file($tmp,$path))  {
                $persona=$_POST['id'];
                include_once '../../PDO.php';
                $insert = $conexion->prepare("UPDATE intervenciones_slocal SET doc=:doc WHERE ID=:id");
                $insert -> bindParam(':doc',$path);
                $insert -> bindparam(':id',$persona);
                if($insert-> execute()){
                    echo "OK";
                }else{
                    echo "NO";
                }
                
            }
?>