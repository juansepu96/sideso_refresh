<?php

require_once "../PDO.php";

$ObtenerPersonas = $conexion -> query (" SELECT * FROM personas_mujeres");

$result = $ObtenerPersonas->fetchAll(\PDO::FETCH_ASSOC);


print_r (json_encode($result));

?>