<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /1semestre/lhizkidoor/auth/index.php?section=login");
    exit;
}

$usuarioId = $_SESSION['user']['id'];
$action = $_GET['action'] ?? 'home';
$bd = new AccesoBD_Usuario();

switch ($action) {

   case 'jugar':
    if ($bd->haJugadoEstaSemana($usuarioId)) {
        header("Location: ../index.php");
        exit;
    }

    $_SESSION['preguntas'] = $bd->obtenerPreguntasPorRamaUsuario($usuarioId);
    $_SESSION['indicePregunta'] = 0;
    $_SESSION['puntuacion'] = 0;
    $_SESSION['modo'] = 'semanal';

    $_SESSION['partida_id'] = $bd->registrarPartidaSemanal();

    $_SESSION['yaJugo'] = true;
    $_SESSION['semana_jugada'] = date('W');

    header("Location: ../index.php?section=preguntas");
    exit;


    case 'repasar':
        $palabra = $bd->obtenerPalabraAleatoria();
        $_SESSION['palabra'] = $palabra;
        header("Location: ../index.php?section=jugarPartidaSemanal");
        exit;


    case 'verificar':
        $idPalabra = $_POST['id'] ?? null;
        $opcion = $_POST['opcion'] ?? null;

        if (!$idPalabra || !$opcion) {
            $_SESSION['mensaje'] = "Error al recibir los datos.";
            $_SESSION['tipo_mensaje'] = "danger";
            header("Location: ../index.php");
            exit;
        }

        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "SELECT eusk1, eusk2, eusk3, ondo FROM diccionario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idPalabra);
        $stmt->execute();
        $palabra = $stmt->get_result()->fetch_assoc();
        $db->cerrarConexion();

        $correcta = $palabra['ondo'];
        $resultado = ($opcion == $correcta);

        $_SESSION['mensaje'] = $resultado
            ? "¡Correcto! La respuesta era '{$palabra['eusk' . $correcta]}'"
            : "Incorrecto. La respuesta correcta era '{$palabra['eusk' . $correcta]}'";
        $_SESSION['tipo_mensaje'] = $resultado ? "success" : "danger";

        header("Location: ../index.php");
        break;

    default:
        header("Location: ../index.php");
        break;
}
?>
