<?php
require_once "../../PDO.php";
$ObtenerPersonas = $conexion -> query (" SELECT * FROM personas_slocal");

$result = $ObtenerPersonas->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>