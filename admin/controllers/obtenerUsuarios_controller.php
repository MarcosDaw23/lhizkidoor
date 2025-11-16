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
$usuarios = $bd->obtenerUsuarios();
$_SESSION['usuarios'] = $usuarios;

header("Location: ../index.php?section=gestionUsuarios");
exit;
?>
