<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $bd = new AccesoBD_Auth();
    $resultado = $bd->loginUsuario($email, $password);

    if (isset($resultado['error'])) {
        switch ($resultado['error']) {
            case 'no_confirmada':
                $_SESSION['mensaje'] = "Tu cuenta no ha sido confirmada, revisa tu correo";
                break;
            case 'incorrecta':
                $_SESSION['mensaje'] = "Contraseña incorrecta";
                break;
            case 'no_existe':
                $_SESSION['mensaje'] = "No existe ninguna cuenta con ese correo";
                break;
            default:
                $_SESSION['mensaje'] = "Error magico de los magicos al iniciar sesión";
        }

        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: ../index.php?section=login");
        exit;
    }

    if ($resultado && !isset($resultado['error'])) {
        $_SESSION['usuario'] = [
            'id' => $resultado['id'],
            'nombre' => $resultado['nombre'],
            'rol' => $resultado['rol']
        ];

        $_SESSION['mensaje'] = "Inicio de sesion correcto, Kaixo " . $resultado['nombre'];
        $_SESSION['tipo_mensaje'] = "success";

        header("Location: /1semestre/lhizkidoor/usuario/index.php");
        exit;
    }

    $_SESSION['mensaje'] = "Error de esos magicos al hacer el login";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../index.php?section=login");
    exit;
    } else {
        echo "tch, a hackear a otro maño";
    }
?>
