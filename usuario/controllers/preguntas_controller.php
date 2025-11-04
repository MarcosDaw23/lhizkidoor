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

    // RESPONDER PREGUNTA
    case 'responder':
        $indice = $_SESSION['indicePregunta'];
        $preguntas = $_SESSION['preguntas'];

        $respuesta = $_POST['opcion'] ?? null;
        $correcta = $preguntas[$indice]['ondo'];

        // Calcular puntuación
        if ($respuesta == $correcta) {
            $_SESSION['puntuacion'] += 100;
        } else {
            $_SESSION['puntuacion'] -= 50;
            if ($_SESSION['puntuacion'] < 0) {
                $_SESSION['puntuacion'] = 0;
            }
        }

        // Pasar a la siguiente pregunta
        $_SESSION['indicePregunta']++;

        if ($_SESSION['indicePregunta'] >= count($_SESSION['preguntas'])) {
            header("Location: ./Preguntas_controller.php?action=finalizar");
        } else {
            header("Location: ../index.php?section=preguntas");
        }
        exit;


    // FINALIZAR JUEGO (modo normal o semanal)
    case 'finalizar':
        $puntuacionFinal = $_SESSION['puntuacion'] ?? 0;

        // Si es partida semanal, registrar en tabla y actualizar puntuaciones
        if (isset($_SESSION['modo']) && $_SESSION['modo'] === 'semanal') {
            $partidaId = $bd->obtenerPartidaSemanaActual();
            $bd->registrarPartidaUsuario($usuarioId, $partidaId, $puntuacionFinal);
        }

        // Actualizar la puntuación total del sector
        $bd->actualizarPuntuacionClase($usuarioId, $puntuacionFinal);

        $_SESSION['mensaje'] = "✅ Has finalizado el juego con {$puntuacionFinal} puntos.";
        $_SESSION['tipo_mensaje'] = "success";

        unset($_SESSION['preguntas'], $_SESSION['indicePregunta'], $_SESSION['puntuacion'], $_SESSION['modo']);

        header("Location: ../index.php");
        exit;


    default:
        header("Location: ../index.php");
        break;
}
?>
