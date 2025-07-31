<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Incluye las clases si usas Composer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = $_POST['nombre'] ?? 'Invitado';
    $correo   = $_POST['correo'] ?? 'no-reply@tudominio.com';
    $mensaje  = $_POST['mensaje'] ?? '';
    $celular  = $_POST['celular'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Brevo (Sendinblue)
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93a50b001@smtp-brevo.com'; // Correo con el que te registraste en Brevo
        $mail->Password   = 'EBCkFzHsp304ThKf';        // Contraseña SMTP que generaste
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Información del mensaje
        $mail->setFrom('info@nucleosoftware.com', 'Nucleo Software');
        $mail->addAddress('info@nucleosoftware.com', 'Nucleo Software'); // Destinatario
        $mail->addReplyTo($correo, $nombre); // Para poder responder al cliente

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde el sitio web';
        $mail->Body = "
            <strong>Nombre:</strong> $nombre<br>
            <strong>Correo:</strong> $correo<br>
            <strong>Celular:</strong> $celular<br>
            <strong>Mensaje:</strong><br>$mensaje
        ";

        $mail->send();
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "¡Mensaje enviado!",
                    text: "Gracias por contactarnos. Te responderemos pronto.",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "/";
                });
            </script>
        ';
    } catch (Exception $e) {
        echo "<script>alert('Error al enviar: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>
