<?php
require_once "../../PDO.php";
$ObtenerPersonas = $conexion -> query (" SELECT * FROM personas_slocal ORDER BY legajo DESC");

$result = $ObtenerPersonas->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>