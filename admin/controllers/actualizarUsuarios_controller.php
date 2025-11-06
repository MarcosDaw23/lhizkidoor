<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 1) {
    $_SESSION['mensaje'] = "No tienes permisos suficientes para estar aqui, pa fuera";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../../auth/index.php?section=login");
    exit;
}

$bd = new AccesoBD_Admin();
$exito = $bd->actualizarUsuario($_POST);

if ($exito) {
    $_SESSION['mensaje'] = "Usuario actualizado correctamente";
    $_SESSION['tipo_mensaje'] = "success";
} else {
    $_SESSION['mensaje'] = "Error al actualizar el usuario, disculpe las molestias";
    $_SESSION['tipo_mensaje'] = "danger";
}

header("Location: ../index.php?section=gestionUsuarios");
exit;
?>
