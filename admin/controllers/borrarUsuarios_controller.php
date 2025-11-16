<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 1) {
    $_SESSION['mensaje'] = "No tienes permisos suficientes para estar aqui, pa fuera";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../../auth/index.php?section=login");
    exit;
}
if (!isset($_GET['id'])) {
    header("Location: ../index.php?section=gestionUsuarios");
    exit;
}

$id = intval($_GET['id']);
$bd = new AccesoBD_Admin();

if ($bd->borrarUsuario($id)) {
    $_SESSION['mensaje'] = "Usuario eliminado de forma adecuada";
    $_SESSION['tipo_mensaje'] = "success";
} else {
    $_SESSION['mensaje'] = "Hubo un problema al eliminar al usuario, disculpe las molestias";
    $_SESSION['tipo_mensaje'] = "danger";
}

header("Location: ../index.php?section=gestionUsuarios");
exit;
?>
