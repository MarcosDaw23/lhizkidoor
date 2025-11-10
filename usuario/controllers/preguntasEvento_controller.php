<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: /1semestre/lhizkidoor/auth/index.php?section=login");
  exit;
}

$bd = new AccesoBD_Usuario();
$usuarioId = $_SESSION['user']['id'];
$action = $_GET['action'] ?? 'start';
$evento = isset($_GET['evento']) ? intval($_GET['evento']) : null;
$_SESSION['evento'] = $evento;
$nombre = $_SESSION['user']['nombre'];
$fallos = $_SESSION['fallos'] = 0;
$aciertos = $_SESSION['aciertos'] = 0;

switch ($action) {

  case 'responder':
    $indice = $_SESSION['indicePregunta'];
    $preguntas = $_SESSION['preguntas'];
    $respuesta = $_POST['opcion'] ?? null;
    $correcta = $preguntas[$indice]['ondo'];
    $evento = $_GET['evento'];
    $puntuacion = $_SESSION['puntuacion'];

    $_SESSION['resultados'][] = [
      'definicion' => $preguntas[$indice]['definicion'],
      'opciones' => [
        1 => $preguntas[$indice]['eusk1'],
        2 => $preguntas[$indice]['eusk2'],
        3 => $preguntas[$indice]['eusk3']
      ],
      'respuesta' => $respuesta,
      'correcta' => $correcta
    ];

    if ($respuesta == $correcta) {
      $_SESSION['puntuacion'] += 100;
      $_SESSION['aciertos'] += 1;
    } else {
      $_SESSION['puntuacion'] -= 50;
      $_SESSION['fallos'] += 1;
      if ($_SESSION['puntuacion'] < 0) $_SESSION['puntuacion'] = 0;
    }

    $_SESSION['indicePregunta']++;

    if ($_SESSION['indicePregunta'] >= count($_SESSION['preguntas'])) {
      header("Location: ./preguntasEvento_controller.php?action=finalizar");
    } else {
      header("Location: ../index.php?section=preguntasEvento");
    }
    exit;

  case 'finalizar':
    $_SESSION['mensaje'] = "Has completado el evento. Tu puntuación fue: " . ($_SESSION['puntuacion'] ?? 0) . " puntos.";
    $_SESSION['tipo_mensaje'] = "success";
    $bd->insertarRanking($evento,$nombre, $puntuacion, $fallos, $aciertos);
    header("Location: ../index.php?section=resultadosPartidas");
    exit;

  default:
    header("Location: ../index.php");
    break;
}
?>
