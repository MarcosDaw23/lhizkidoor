<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../models/AccesoBD_class.php';
require_once __DIR__ . '/../../vendor/autoload.php'; 

session_start();

// Verifica acceso del profesor
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 2) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEvento = trim($_POST['nombre'] ?? '');
    $num_preguntas = intval($_POST['num_preguntas'] ?? 10);
    $clases = $_POST['clases'] ?? [];

    if ($nombreEvento && $clases) {
        $profesor_id = $_SESSION['user']['id'];
        $db = new AccesoBD_Profesor();

        // Crear evento
        $evento_id = $db->crearEvento($nombreEvento, $profesor_id, $num_preguntas, $clases);

        if ($evento_id) {
            $usuarios = $db->obtenerUsuariosEvento($clases);

            foreach ($usuarios as $u) {
                $email = $u['mail'];
                $nombre = $u['nombre'];
                $apellido = $u['apellido'];

                $link = "http://localhost/php/lhizkidoor/usuario/index.php?section=partidaEvento&evento=$evento_id";

                $mailer = new PHPMailer(true);

                try {
                    $mailer->isSMTP();
                    $mailer->Host = 'smtp.gmail.com';
                    $mailer->SMTPAuth = true;
                    $mailer->Username = 'paquiconfirmador@gmail.com';
                    $mailer->Password = 'oulm imam iqpk yjlw'; // ⚠️ RECOMENDACIÓN: usa variable de entorno
                    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mailer->Port = 587;

                    $mailer->setFrom('paquiconfirmador@gmail.com', 'LHizkiDoor');
                    $mailer->addAddress($email, "$nombre $apellido");

                    $mailer->isHTML(true);
                    $mailer->Subject = "Nuevo evento disponible: $nombreEvento";
                    $mailer->Body = "
                        <p>Hola <b>{$nombre}</b>,</p>
                        <p>Tu profesor ha creado un nuevo evento en <b>LHizkiDoor</b>.</p>
                        <p>Este evento contiene <b>{$num_preguntas}</b> preguntas y está disponible en el siguiente enlace:</p>
                        <p><a href='$link'>$link</a></p>
                        <br>
                        <p>Solo podrás participar si has recibido esta invitación.</p>
                        <p>¡Mucha suerte!</p>
                    ";

                    $mailer->send();

                } catch (Exception $e) {
                    error_log("Error al enviar correo a $email: {$mailer->ErrorInfo}");
                }
            }

            $_SESSION['mensaje'] = "Evento creado y correos enviados correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al crear el evento en la base de datos.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "Debes completar todos los campos y seleccionar al menos una clase o sector.";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    header("Location: ../index.php?section=CrearEventos");
    exit;
}
?>
