<?php
session_start();
require_once __DIR__ . '/../models/AccesoBD_class.php';

$db = new AccesoBD_Admin();
$resultado = $db->actualizarUsuario($_POST);

if ($resultado) {
    // Actualizamos la sesión para reflejar los nuevos datos
    $_SESSION['user'] = $db->obtenerUsuarioPorId(intval($_POST['id']));
}

header("Location: ../index.php?section=perfil&success=1");
exit;