<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: /1semestre/lhizkidoor/auth/index.php?section=login");
  exit;
}

$eventoId = $_GET['evento'] ?? null;
if (!$eventoId) {
  echo "<div class='text-center mt-5'><h3>❌ Evento no válido o inexistente.</h3></div>";
  exit;
}

$bd = new AccesoBD_Usuario();
$evento = $bd->obtenerEventoPorId($eventoId);

if (!$evento) {
  echo "<div class='text-center mt-5'><h3>❌ Este evento no existe o ha sido eliminado.</h3></div>";
  exit;
}

// 🔸 Obtener preguntas según la cantidad definida en el evento
$preguntas = $bd->obtenerPreguntasEvento($evento['num_preguntas']);

// Guardar en sesión (modo evento)
$_SESSION['modo'] = 'evento';
$_SESSION['evento_id'] = $eventoId;
$_SESSION['preguntas'] = $preguntas;
$_SESSION['indicePregunta'] = 0;
$_SESSION['puntuacion'] = 0;

header("Location: index.php?sections=preguntasEvento");
exit;
?>
