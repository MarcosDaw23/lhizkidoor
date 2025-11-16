<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
require_once __DIR__ . '/../../usuario/models/AccesoBD_class.php'; // 👈 añadimos esto
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $bd = new AccesoBD_Auth();
    $resultado = $bd->loginUsuario($email, $password);

    if (isset($resultado['error'])) {
        switch ($resultado['error']) {
            case 'no_confirmada':
                $_SESSION['mensaje'] = "Tu cuenta no ha sido confirmada, revisa tu correo.";
                break;
            case 'incorrecta':
                $_SESSION['mensaje'] = "Contraseña incorrecta.";
                break;
            case 'no_existe':
                $_SESSION['mensaje'] = "No existe ninguna cuenta con ese correo.";
                break;
            default:
                $_SESSION['mensaje'] = "Error inesperado al iniciar sesión.";
        }

        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: ../index.php?section=login");
        exit;
    }

    if ($resultado && !isset($resultado['error'])) {
        // ✅ Guardamos la info del usuario
        $_SESSION['user'] = [
            'id' => $resultado['id'],
            'nombre' => $resultado['nombre'],
            'centro' => $resultado['centro'],
            'clase' => $resultado['clase'],
            'sector' => $resultado['sector'],
            'rol' => $resultado['rol'],
            'puntuacion' => $resultado['puntuacionIndividual'],
            'idioma' => $resultado['idioma'] ?? 'español'
        ];
        // ✅ Comprobamos si ya jugó esta semana
        $bdUsuario = new AccesoBD_Usuario();
        $_SESSION['yaJugo'] = $bdUsuario->haJugadoEstaSemana($resultado['id']);
        $_SESSION['semana_jugada'] = date('W'); 
        $_SESSION['mensaje'] = "Inicio correcto. Kaixo " . htmlspecialchars($resultado['nombre']);
        $_SESSION['tipo_mensaje'] = "success";

        // ✅ Redirección según rol
        $rol = intval($resultado['rol']);

        switch ($rol) {
            case 1:
                header('Location: ../../admin/index.php');
                break;
            case 2:
                header('Location: ../../profesor/index.php');
                break;
            case 3:
            default:
                header('Location: ../../usuario/index.php');
                break;
        }
        exit;
    }

    $_SESSION['mensaje'] = "Error inesperado en el login.";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../index.php?section=login");
    exit;
} else {
    echo "Tch, pa tras maleante";
}
