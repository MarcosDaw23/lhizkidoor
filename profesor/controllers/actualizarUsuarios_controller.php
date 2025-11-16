<?php
session_start();
require_once __DIR__ . '/../models/AccesoBD_class.php';

$db = new AccesoBD_Profesor();
$resultado = $db->actualizarUsuario($_POST);

if ($resultado) {
    $usuarioActualizado = $db->obtenerUsuarioPorId(intval($_POST['id']));
    if ($usuarioActualizado) {
        $_SESSION['user']['nombre'] = $usuarioActualizado['nombre'];
        $_SESSION['user']['centro'] = $usuarioActualizado['centro'];
        $_SESSION['user']['sector'] = $usuarioActualizado['sector'];
        $_SESSION['user']['clase'] = $usuarioActualizado['clase'];
    }
}

header("Location: ../index.php?section=perfil&success=1");
exit;