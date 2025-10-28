<?php  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; 
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
$rol        = 3; 

if ($pass1 !== $pass2) {
    $_SESSION['mensaje'] = "Las contraseñas no coinciden, vuelva a introducirlas porfavor";
    $_SESSION['tipo_mensaje'] = "danger";
    header('Location: ../index.php?section=registro');
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
    null,
    bin2hex(random_bytes(16)), // token
    null              
);

$bd = new AccesoBD_Auth();
$token = $bd->registrarUsuario($user);

if ($token) {
    $link = "http://localhost/php/lhizkidoor/auth/index.php?section=confirmarCuenta&token=$token";

    $mailer = new PHPMailer(true);

    try {
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'paquiconfirmador@gmail.com';
        $mailer->Password = 'oulm imam iqpk yjlw';
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Port = 587;

        $mailer->setFrom('paquiconfirmador@gmail.com', 'LHizkiDoor');
        $mailer->addAddress($email, "$nombre $apellido");

        $mailer->isHTML(true);
        $mailer->Subject = 'Confirma tu cuenta en LHizkiDoor';
        $mailer->Body = "
            <p>Hola <b>{$nombre}</b>,</p>
            <p>Gracias por registrarte en <b>LHizkiDoor</b>. Para activar tu cuenta, confirma tu correo haciendo clic en el siguiente enlace:</p>
            <p><a href='$link'>$link</a></p>
            <br>
            <p>Esperamos que tu aprendizaje sea divertido</p>
        ";

        $mailer->send();

        $_SESSION['mensaje'] = "Tu cuenta ha sido creada, pero falta lconfirmarla, revisa tu correo gmail";
        $_SESSION['tipo_mensaje'] = "success";
        header("Location: ../index.php?section=confirmarCuenta");
        exit;

    } catch (Exception $e) {
        $_SESSION['mensaje'] = "Error al enviar el correo: {$mailer->ErrorInfo}";
        $_SESSION['tipo_mensaje'] = "danger";
        header("Location: ../index.php?section=registro");
        exit;
    }
} else {
    $_SESSION['mensaje'] = "No se pudo registrar el usuario, ya sea por fallo o porque ya existe";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../index.php?section=registro");
    exit;
}
?>
