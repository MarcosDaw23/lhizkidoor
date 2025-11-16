<?php
session_start();
require_once __DIR__ . '/../models/AccesoBD_class.php';

$bd = new AccesoBD_Usuario();

$usuarioId = $_SESSION['user']['id'] ?? 0;
$idPalabra  = $_POST['id_palabra'] ?? 0;
$respuesta  = trim(strtolower($_POST['respuesta'] ?? ''));

if (!$usuarioId || !$idPalabra || empty($respuesta)) {
    header("Location: ../index.php?section=traduccionJuego&error=missing");
    exit;
}

// Obtener la palabra original desde la BD
$palabra = $bd->obtenerPalabraPorId($idPalabra);

// Comparar respuesta
$correcta = strtolower(trim($palabra['cast']));

$_SESSION['resultado_traduccion'] = [
    'correcta' => $palabra['cast'],
    'tu_respuesta' => $respuesta,
    'resultado' => $respuesta === $correcta ? '✅ ¡Correcto!' : '❌ Incorrecto',
];

header("Location: ../index.php?section=resultadoTraduccion");
exit;
?>
