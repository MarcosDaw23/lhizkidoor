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

switch ($action) {

    case 'start':
        $_SESSION['preguntas'] = $bd->obtenerPreguntas();
        $_SESSION['indicePregunta'] = 0;
        $_SESSION['puntuacion'] = 0;
        $_SESSION['modo'] = 'normal';
        header("Location: ../index.php?section=preguntas");
        exit;

   case 'responder':
    $indice = $_SESSION['indicePregunta'];
    $preguntas = $_SESSION['preguntas'];
    $respuesta = $_POST['opcion'] ?? null;
    $correcta = $preguntas[$indice]['ondo'];

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
    } else {
        $_SESSION['puntuacion'] -= 50;
        if ($_SESSION['puntuacion'] < 0) {
            $_SESSION['puntuacion'] = 0;
        }
    }

    $_SESSION['indicePregunta']++;

    if ($_SESSION['indicePregunta'] >= count($_SESSION['preguntas'])) {
        header("Location: ./Preguntas_controller.php?action=finalizar");
    } else {
        header("Location: ../index.php?section=preguntas");
    }
    exit;


case 'finalizar':
    $puntuacionFinal = $_SESSION['puntuacion'] ?? 0;

    if (isset($_SESSION['modo']) && $_SESSION['modo'] === 'semanal') {
        $partidaId = $_SESSION['partida_id']; // usar solo la de sesion
        $bd->registrarPartidaUsuario($usuarioId, $partidaId, $puntuacionFinal);

        $_SESSION['yaJugo'] = true;
        $_SESSION['semana_jugada'] = date('W');
    }

    $bd->actualizarPuntuacionClase($usuarioId, $puntuacionFinal);
    header("Location: ../index.php?section=resultadosPartidas");
    exit;

    default:
        header("Location: ../index.php");
        break;
}
?>
