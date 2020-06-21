<?php
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp','webp'); // valid extensions
$path = 'docs/'; // upload directory

        $img = $_FILES['ImagenHC']['name'];
        $tmp = $_FILES['ImagenHC']['tmp_name'];
        // get uploaded file's extension
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        // can upload same image using rand function
        $final_image = rand(1000,1000000).$img;
        // check's valid format
        if(in_array($ext, $valid_extensions)) { 
            $path = $path.strtolower($final_image); 
            if(move_uploaded_file($tmp,$path))  {
                echo "<img src='$path' />";
                $persona=$_POST['dni'];
                $detalle = $_POST['DescripcionDocumento'];
                include_once 'PDO.php';
                $insert = $conexion->query("INSERT INTO docs (url,detalle,DNI) VALUES ('".$path."','".$detalle."','".$persona."')");
                echo $insert?'OK':'NO';
            }
         }
?>