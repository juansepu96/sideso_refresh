<?php

require_once "../../PDO.php";

$CargarCitas=$conexion->query("SELECT * from agenda_slocal");

$result = $CargarCitas->fetchAll(\PDO::FETCH_ASSOC);
print_r (json_encode($result));    



?>