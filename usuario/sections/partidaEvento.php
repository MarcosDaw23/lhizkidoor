<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

// 1. Comprobar si el usuario está logueado
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/index.php?section=login");
    exit;
}

// 2. Validar parámetro de evento
$eventoId = $_GET['evento'] ?? null;

if (!$eventoId || !ctype_digit($eventoId)) {
    echo "<div class='text-center mt-5'><h3>❌ Evento no válido o inexistente.</h3></div>";
    exit;
}

// 3. Consultas necesarias
$bd = new AccesoBD_Usuario();
$jugado = $bd->eventoYaJugado($_SESSION['user']['nombre'], $eventoId);
$rama = $bd->obtenerIdRamaPorSector($_SESSION['user']['sector']);
$evento = $bd->obtenerEventoPorId($eventoId);

// 4. Validar que el evento exista
if (!$evento) {
    echo "<div class='text-center mt-5'><h3>❌ El evento no existe.</h3></div>";
    exit;
}

$fechaFin = strtotime($evento['fechaFin']);
date_default_timezone_set('Europe/Madrid'); // Ajusta a tu zona horaria
$ahora = date('Y-m-d H:i:s');

if ($jugado) {
    $_SESSION['mensaje'] = 'Ya jugaste este evento';
    $_SESSION['tipo_mensaje'] = 'danger';
    header("Location: index.php");
    exit;
}

if ($ahora > $fechaFin) {
    $_SESSION['mensaje'] = 'El evento ya finalizó';
    $_SESSION['tipo_mensaje'] = 'danger';
    header("Location: index.php");
    exit;
}

// 6. Cargar preguntas
$preguntas = $bd->obtenerPreguntasEvento($rama, $evento['num_preguntas']);

// 7. Inicializar el modo evento
$_SESSION['modo'] = 'evento';
$_SESSION['evento_id'] = $eventoId;
$_SESSION['preguntas'] = $preguntas;
$_SESSION['indicePregunta'] = 0;
$_SESSION['puntuacion'] = 0;
$_SESSION['fallos'] = 0;
$_SESSION['aciertos'] = 0;

// 8. Redirigir a las preguntas del evento
header("Location: index.php?section=preguntasEvento");
exit;
