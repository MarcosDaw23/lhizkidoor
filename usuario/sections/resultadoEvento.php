<?php
session_start();
require_once __DIR__ . '/models/AccesoBD.class.php';

$id_evento = $_SESSION['evento_id'] ?? null;
$id_usuario = $_SESSION['user']['id'] ?? null;

if (!$id_evento || !$id_usuario) {
    echo "No hay evento o usuario definido en la sesión.";
    exit;
}

$bd = new AccesoBD_class();
$miEstadistica = $bd->obtenerMiEstadistica($id_evento, $id_usuario);

if ($miEstadistica) {
    echo "Puntos: " . htmlspecialchars($miEstadistica['puntuacion']) . "<br>";
    echo "Aciertos: " . htmlspecialchars($miEstadistica['aciertos']) . "<br>";
    echo "Fallos: " . htmlspecialchars($miEstadistica['fallos']);
} else {
    echo "No hay estadísticas para este evento.";
}
