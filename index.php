<?php
session_start();

// si es su primera vez o no tiene session, debe ir a registrase o loguearse
if (!isset($_SESSION['user'])) {
    header("Location: ./auth/");
    exit;
}

<<<<<<< Updated upstream
// 🔐si el usuario o profesor ya ha iniciado sesion, se sale y se vuelve a meter al rato, va directamente aqui y segun el rol, llega a su apartado
=======
//esto no ta funcional, tengo que mirarlo pa que se guarde
// si el usuario o profesor ya ha iniciado sesion, se sale y se vuelve a meter al rato, va directamente aqui y segun el rol, llega a su apartado
>>>>>>> Stashed changes
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
