<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 2) { 
    header("Location: ../../auth/index.php?section=login");
    exit;
}

$db = new AccesoBD_Profesor();
$estadisticas = $db->obtenerEstadisticasPartidas();

$_SESSION['estadisticas_partidas'] = $estadisticas;

header("Location: ../index.php?section=Estadisticas");
exit;
?>
