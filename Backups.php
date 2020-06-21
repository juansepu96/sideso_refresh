<?php

require_once "PDO.php";


function EXPORT_DATABASE($host,$user,$pass,$name,$tables=false, $backup_name=false)
{ 
	set_time_limit(3000); $mysqli = new mysqli($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
	$queryTables = $mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }	if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); } 
	$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
	foreach($target_tables as $table){
		if (empty($table)){ continue; } 
		$result	= $mysqli->query('SELECT * FROM `'.$table.'`');  	$fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows; 	$res = $mysqli->query('SHOW CREATE TABLE '.$table);	$TableMLine=$res->fetch_row(); 
		$content .= "\n\n".$TableMLine[1].";\n\n";   $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
		for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
			while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
				if ($st_counter%100 == 0 || $st_counter == 0 )	{$content .= "\nINSERT INTO ".$table." VALUES";}
					$content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
				//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
				if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";}	$st_counter=$st_counter+1;
			}
		} $content .="\n\n\n";
	}
	$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
	$backup_name = $backup_name ? $backup_name : $name.'___('.date('H-i-s').'_'.date('d-m-Y').').sql';
	ob_get_clean(); header('Content-Type: application/octet-stream');  header("Content-Transfer-Encoding: Binary");  header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    header("Content-disposition: attachment; filename=\"".$backup_name."\""); 
	echo $content; exit;
}

function IMPORT_TABLES($host,$user,$pass,$dbname, $sql_file_OR_content){
    set_time_limit(3000);  
    
	$SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ?  $sql_file_OR_content : file_get_contents($sql_file_OR_content)  );  
    $allLines = explode("\n",$SQL_CONTENT); 
        $mysqli = new mysqli($host, $user, $pass, $dbname); if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();} 
		$zzzzzz = $mysqli->query('SET foreign_key_checks = 0');	        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n". $SQL_CONTENT, $target_tables); foreach ($target_tables[2] as $table){$mysqli->query('DROP TABLE IF EXISTS '.$table);}         $zzzzzz = $mysqli->query('SET foreign_key_checks = 1');    $mysqli->query("SET NAMES 'utf8'");	
	$templine = '';	// Temporary variable, used to store current query
	foreach ($allLines as $line)	{											// Loop through each line
		if (substr($line, 0, 2) != '--' && $line != '') {$templine .= $line; 	// (if it is not a comment..) Add this line to the current segment
			if (substr(trim($line), -1, 1) == ';') {		// If it has a semicolon at the end, it's the end of the query
				if(!$mysqli->query($templine)){ print('Error performing query \'<strong>' . $templine . '\': ' . $mysqli->error . '<br /><br />');  }  $templine = ''; // set variable to empty, to start picking up the lines after ";"
			}
		}
    }	return 'Importing finished. Now, Delete the import file.';
}


if(isset($_POST['realizar'])){
    EXPORT_DATABASE("localhost", "c1650705_juan", "Ah000240", "c1650705_desarrollosocial");

}

if(isset($_POST['restore2'])){

    $fileTmpPath = $_FILES['company_backup']['tmp_name'];
    $fileName = $_FILES['company_backup']['name'];
    $fileSize = $_FILES['company_backup']['size'];
    $fileType = $_FILES['company_backup']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $newFileName = 'sideso' . '.' . $fileExtension;
    $uploadFileDir = './backups/';
    $dest_path = $uploadFileDir . $newFileName;
    move_uploaded_file($fileTmpPath, $dest_path);   

    $DeleteTable=$conexion->query("DROP TABLE asistencias");
    $DeleteTable=$conexion->query("DROP TABLE encuestas");
    $DeleteTable=$conexion->query("DROP TABLE grupos");
    $DeleteTable=$conexion->query("DROP TABLE personas");
    $DeleteTable=$conexion->query("DROP TABLE usuarios");

    IMPORT_TABLES("localhost", "c1650705_juan", "Ah000240", "c1650705_desarrollosocial", $dest_path);

    header ("Location: Cerrar.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">    
    
    <title>Copias de Seguridad - SiDeSo v2.0</title>
</head>
<body  onload="$('#Acceder').modal('show');">

<nav class="navbar text-center navbar-expand-lg navbar-dark bg-dark navbar-toggleable-sm sticky-top">
        <a class="navbar-brand" href="Inicio.php">
            SiDeSo v2.0
         </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <ul class="navbar-nav text-center">
      <li class="nav-item">
        <a class="nav-link" href="Inicio.php">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Buscar.php">Personas</a>
      </li>     
	  <li class="nav-item">
        <a class="nav-link" href="Estadisticas.php">Estadisticas</a>
	  </li>
	  <li class="nav-item active">
        <a class="nav-link" href="Backups.php">Copias de Seguridad</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Cerrar.php">Cerrar Sesion</a>
      </li> 
           
    </ul>
  </div>
</nav>

<div hidden id="Backup" class="container">                          
         <div class="d-flex justify-content-center h-100">                         
            <div class="card">        
				<div class="mt-4">
					<h2 class="welcome">Copias de Seguridad</h2>
				</div>           
				<form method="post">
					<div class="row">
						<div class="col text-center m-5">
							<button type="submit" name="backup" class="btn btn-primary" class="form-control">Realizar</button>
						</div>
					</div>
					<div class="row">
						<div class="col text-center">
							<button type="button" name="restore" class="btn btn-primary" onclick="Restaurar();" class="form-control">Restaurar</button>
						</div>
					</div>  
				</form>              
            </div>
         </div>		
</div>

<div hidden id="Restore" class="container">                          
         <div class="d-flex justify-content-center h-100">                         
            <div class="card">        
				<div class="mt-4">
					<h2 class="welcome">Copias de Seguridad</h2>
				</div>           
				<form method="post">
					<div class="row">
						<div class="col text-center m-5">
						<strong style="color:white;">Seleccione el archivo: <br> <input type="file" accept=".sql"  name="company_backup" id="company_backup" class="form-control"></strong>
						<button type="submit" name="restore2" class="btn btn-primary m-2" class="form-control">Restaurar</button>
						</div>
					</div>					
				</form>              
            </div>
         </div>		
</div>

<div class="modal mt-5" id="Acceder" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingrese contraseña de Supervisor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger" role="alert">
			  RECUERDE QUE ESTA ACCEDIENDO A UN AREA RESTRINGIDA DEL SISTEMA <hr>
			  SOLO PUEDEN INGRESAR LOS USUARIOS CON ACCESO PERMITIDO. 
          </div>
          <label for="password">Ingrese la contraseña</label>
          <input type="password" id="password" name="password" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" style="background:red;" onclick="Acceder();">Acceder</button>

      </div>
    </div>
  </div>
</div>
    
   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js" ></script> 
	<script src="Backups.js" ></script> 
</body>
</html>