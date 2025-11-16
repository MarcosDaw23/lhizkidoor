<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar clase de acceso a la BD
require_once __DIR__ . '/../models/AccesoBD_class.php';

// Recoger la clase desde GET
$clase = isset($_GET['clase']) ? (int)$_GET['clase'] : 0;

if ($clase <= 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => true, 'mensaje' => 'Clase no válida']);
    exit;
}

try {
    $acceso = new AccesoBD_Profesor();
    $datos = $acceso->obtenerEstadisticasJugadores($clase);

    // Asegurarnos de que $datos es un array con los campos esperados
    if (!isset($datos['total'], $datos['jugados'], $datos['no_jugados'])) {
        throw new Exception("Datos incompletos desde la base de datos");
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($datos);

} catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'error' => true,
        'mensaje' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}
