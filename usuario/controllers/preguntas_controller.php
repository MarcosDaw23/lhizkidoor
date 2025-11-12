<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

$bd = new AccesoBD_Usuario();
$usuarioId = $_SESSION['user']['id'];
$action = $_GET['action'] ?? 'start';
$rama = $bd->obtenerIdRamaPorSector($_SESSION['user']['sector']);

switch ($action) {

 case 'start':
    $_SESSION['preguntas'] = $bd->obtenerPreguntas($rama);
    $_SESSION['indicePregunta'] = 0;
    $_SESSION['puntuacion'] = 0;
    $_SESSION['modo'] = 'normal';

    // 🔥 limpia resultados anteriores antes de empezar de nuevo
    $_SESSION['resultados'] = [];
    $_SESSION['ultima_accion'] = null;

    header("Location: ../index.php?section=preguntas");
    exit;

    // RESPONDER PREGUNTA
  case 'responder':
    // Inicializar resultados si no existe
    if (!isset($_SESSION['resultados'])) {
        $_SESSION['resultados'] = [];
    }

    $indice = $_SESSION['indicePregunta'];
    $preguntas = $_SESSION['preguntas'];
    $respuesta = $_POST['opcion'] ?? null;
    $correcta = $preguntas[$indice]['ondo'];

    // ✅ Evitar duplicados: si ya se guardó este índice, no volver a guardarlo
    if (!isset($_SESSION['resultados'][$indice])) {
        $_SESSION['resultados'][$indice] = [
            'definicion' => $preguntas[$indice]['definicion'],
            'respuesta' => $preguntas[$indice]['eusk' . $respuesta],
            'correcta'  => $preguntas[$indice]['eusk' . $correcta]
        ];

        // Puntuación solo una vez
        if ($respuesta == $correcta) {
            $_SESSION['puntuacion'] += 100;
        } else {
            $_SESSION['puntuacion'] -= 50;
            if ($_SESSION['puntuacion'] < 0) $_SESSION['puntuacion'] = 0;
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

    if (isset($_SESSION['modo']) && $_SESSION['modo'] === 'semanal') {
        $partidaId = $bd->obtenerPartidaSemanaActual();
        $bd->registrarPartidaUsuario($usuarioId, $partidaId, $puntuacionFinal);
    }

    // Guardar la puntuación final (ya existe en $_SESSION)
    $_SESSION['mensaje'] = "✅ Has finalizado el juego con {$puntuacionFinal} puntos.";
    $_SESSION['tipo_mensaje'] = "success";

    // 👉 Redirigir a la vista de resultados
    header("Location: ../index.php?section=resultadosPartidas");
    exit;

}
?>
