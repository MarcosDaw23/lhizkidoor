<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

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
                $_SESSION['mensaje'] = "Error inesperado al iniciar sesion";
        }

        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: ../index.php?section=login");
        exit;
    }

    if ($resultado && !isset($resultado['error'])) {
        $_SESSION['user'] = [
            'id' => $resultado['id'],
            'nombre' => $resultado['nombre'],
            'rol' => $resultado['rol']
        ];

        $_SESSION['mensaje'] = "Inicio correcto. Kaixo " . $resultado['nombre'];
        $_SESSION['tipo_mensaje'] = "success";

        //obtengo rol para desplazar segun el numero de la bd, hago switch porque if no me va, mirar
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

    $_SESSION['mensaje'] = "Error magico macoso, no va na del login";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../index.php?section=login");
    exit;
} else {
    echo "Tch, pa tras maleante";
}
