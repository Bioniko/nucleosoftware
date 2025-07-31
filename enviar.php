<?php
// Mostrar errores por si algo falla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate que estás usando Composer y que PHPMailer esté instalado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = $_POST['nombre'] ?? 'Invitado';
    $correo   = $_POST['correo'] ?? 'no-reply@tudominio.com';
    $mensaje  = $_POST['mensaje'] ?? '';
    $celular  = $_POST['celular'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP de Brevo (Sendinblue)
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93a50b001@smtp-brevo.com'; // Tu correo SMTP de Brevo
        $mail->Password   = 'EBCkFzHsp304ThKf';          // Tu contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Remitente y destinatario
        $mail->setFrom('info@nucleosoftware.com', 'Nucleo Software');
        $mail->addAddress('info@nucleosoftware.com', 'Nucleo Software');
        $mail->addReplyTo($correo, $nombre);

        // Contenido del mensaje
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde el sitio web';
        $mail->Body = "
            <strong>Nombre:</strong> $nombre<br>
            <strong>Correo:</strong> $correo<br>
            <strong>Celular:</strong> $celular<br>
            <strong>Mensaje:</strong><br>$mensaje
        ";

        $mail->send();

        // Mostrar alerta de éxito
        echo <<<HTML
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: 'success',
            title: '¡Mensaje enviado!',
            text: 'Tu mensaje ha sido enviado correctamente.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = 'index.html';
        });
        </script>
        HTML;

    } catch (Exception $e) {
        // Mostrar alerta de error
        $errorMsg = addslashes($mail->ErrorInfo); // Escapa comillas para evitar errores JS
        echo <<<HTML
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error al enviar',
            text: 'Error: {$errorMsg}',
            confirmButtonText: 'Volver'
        }).then(() => {
            window.history.back();
        });
        </script>
        HTML;
    }
}
?>
