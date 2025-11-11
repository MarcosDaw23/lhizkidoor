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
$puntuacion = ($respuesta === $correcta) ? 10 : 0;

// Registrar puntuación si acierta
if ($puntuacion > 0) {
    $partidaId = $bd->obtenerPartidaSemanaActual();
    $bd->registrarPartidaUsuario($usuarioId, $partidaId, $puntuacion);
}

$_SESSION['resultado_traduccion'] = [
    'correcta' => $palabra['cast'],
    'tu_respuesta' => $respuesta,
    'resultado' => $respuesta === $correcta ? '✅ ¡Correcto!' : '❌ Incorrecto',
    'puntuacion' => $puntuacion
];

header("Location: ../index.php?section=resultadoTraduccion");
exit;
?>
