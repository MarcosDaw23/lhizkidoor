<?php
session_start();

// si es su primera vez o no tiene session, debe ir a registrase o loguearse
if (!isset($_SESSION['user'])) {
    header("Location: ./auth/");
    exit;
}

switch ($_SESSION['user']['rol']) {
    case 'profesor':
        header("Location: ./profesor/");
        break;
    case 'usuario':
        header("Location: ./usuario/");
        break;
    default:
        // si el rol va mal o peta, forzamos login
        session_destroy();
        header("Location: ./auth/");
}
exit;
?>
