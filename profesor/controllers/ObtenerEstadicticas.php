<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

$acceso = new AccesoBD_Profesor();
$datos = $acceso->obtenerEstadisticasJugadores();

header('Content-Type: application/json');
echo json_encode($datos);
?>
