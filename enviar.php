<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = $_POST['nombre'] ?? 'Invitado';
    $correo   = $_POST['correo'] ?? 'no-reply@tudominio.com';
    $mensaje  = $_POST['mensaje'] ?? '';
    $celular  = $_POST['celular'] ?? '';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93a50b001@smtp-brevo.com';
        $mail->Password   = 'EBCkFzHsp304ThKf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('info@nucleosoftware.com', 'Nucleo Software');
        $mail->addAddress('info@nucleosoftware.com', 'Nucleo Software');
        $mail->addReplyTo($correo, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde el sitio web';
        $mail->Body = "
            <strong>Nombre:</strong> $nombre<br>
            <strong>Correo:</strong> $correo<br>
            <strong>Celular:</strong> $celular<br>
            <strong>Mensaje:</strong><br>$mensaje
        ";

        $mail->send();

        echo <<<HTML
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: 'success',
            title: '¡Mensaje enviado!',
            text: 'Tu mensaje ha sido enviado correctamente.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = '/';
        });
        </script>
        HTML;

    } catch (Exception $e) {
        echo <<<HTML
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error al enviar',
            text: 'Error: {$mail->ErrorInfo}',
            confirmButtonText: 'Volver'
        }).then(() => {
            window.history.back();
        });
        </script>
        HTML;
    }
}
?>
