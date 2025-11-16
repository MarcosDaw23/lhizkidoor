<?php  
require_once "../../core/Modelos/User_class.php";
require_once "../models/AccesoBD_class.php";

session_start();

$nombre     = $_POST['nombre'] ?? '';
$apellido   = $_POST['apellido'] ?? '';
$email      = $_POST['email'] ?? '';
$pass1      = $_POST['password1'] ?? '';
$pass2      = $_POST['password2'] ?? '';
$centro     = $_POST['centro'] ?? null;
$sector     = $_POST['sector'] ?? null;
$clase      = $_POST['clase'] ?? null;
$rol        = 2; 

if ($pass1 !== $pass2) {
    $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
    $_SESSION['tipo_mensaje'] = "danger";
    header('Location: ../index.php?section=registroProfesor');
    exit;
}

$user = new User(
    null,               
    $rol,               
    $nombre,
    $apellido,
    $email,
    $pass1,
    $centro,
    $sector,
    $clase,
    0,                  // puntuacionIndividual -> agregado
    null,               
    date('Y-m-d H:i:s') 
);

$bd = new AccesoBD_Admin();
$exito = $bd->registrarProfesor($user);

if ($exito) {
    $_SESSION['mensaje'] = "Profesor registrado de forma satisfactoria";
    $_SESSION['tipo_mensaje'] = "success";
    header("Location: ../../admin/index.php?section=gestionUsuarios");
    exit;
} else {
    $_SESSION['mensaje'] = "No se pudo registrar el profesor";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../../admin/index.php?section=registroProfesor");
    exit;
}
?>
