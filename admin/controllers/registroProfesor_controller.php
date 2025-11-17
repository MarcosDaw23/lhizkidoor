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
    header('Location: ../index.php?section=crearProfesor');
    exit;
}

$user = new User(
    null,               // id
    $rol,               // rol
    $nombre,            // nombre
    $apellido,          // apellido
    $email,             // email
    $pass1,             // password
    $centro,            // centro
    $sector,            // sector
    $clase,             // clase
    'español',          // idioma (por defecto español para profesores)
    0,                  // puntuacionIndividual
    null,               // token
    date('Y-m-d H:i:s') // fechaConfirmacion
);

$bd = new AccesoBD_Admin();
$exito = $bd->registrarProfesor($user);

if ($exito) {
    $_SESSION['mensaje'] = "Profesor registrado de forma satisfactoria";
    $_SESSION['tipo_mensaje'] = "success";
    header("Location: ../index.php?section=gestionUsuarios");
    exit;
} else {
    $_SESSION['mensaje'] = "No se pudo registrar el profesor";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../index.php?section=crearProfesor");
    exit;
}
?>
