<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

require_once __DIR__ . '/../models/AccesoBD_class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $mail = trim($_POST['mail']);
    $centro = intval($_POST['centro']);
    $sector = intval($_POST['sector']);
    $clase = intval($_POST['clase']);
    $nueva_password = trim($_POST['nueva_password'] ?? '');
    $confirmar_password = trim($_POST['confirmar_password'] ?? '');
    
    // Validar que sea el usuario actual
    if (!isset($_SESSION['user']['id'])) {
        header("Location: ../index.php?section=perfil&error=no_session");
        exit;
    }
    
    $session_user_id = intval($_SESSION['user']['id']);
    if ($id !== $session_user_id) {
        header("Location: ../index.php?section=perfil&error=unauthorized&sid=" . $session_user_id . "&pid=" . $id);
        exit;
    }

    // Validar contraseñas si se proporcionan
    if (!empty($nueva_password) || !empty($confirmar_password)) {
        if ($nueva_password !== $confirmar_password) {
            header("Location: ../index.php?section=perfil&error=password_mismatch");
            exit;
        }
        if (strlen($nueva_password) < 8) {
            header("Location: ../index.php?section=perfil&error=password_short");
            exit;
        }
    }

    $db = new AccesoBD_Usuario();
    
    // Actualizar perfil
    $resultado = $db->actualizarPerfil($id, $nombre, $apellido, $mail, $centro, $sector, $clase, $nueva_password);
    
    if ($resultado) {
        // Actualizar sesión
        $_SESSION['user']['nombre'] = $nombre;
        $_SESSION['user']['centro'] = $centro;
        $_SESSION['user']['sector'] = $sector;
        $_SESSION['user']['clase'] = $clase;
        
        header("Location: ../index.php?section=perfil&success=1");
    } else {
        header("Location: ../index.php?section=perfil&error=1");
    }
} else {
    header("Location: ../index.php?section=perfil");
}
exit;
?>

