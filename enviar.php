<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP GoDaddy
    $mail->isSMTP();
    $mail->Host       = 'smtp.secureserver.net';  // SMTP de GoDaddy
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@nucleosoftware.com';  // Tu correo
    $mail->Password   = '7534f1596076e9e9e6cf7a94506bf14c';           // Tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // o PHPMailer::ENCRYPTION_SMTPS para SSL
    $mail->Port       = 587;                        // Puerto SMTP

    // Remitente y destinatario
    $mail->setFrom('info@nucleosoftware.com', 'Nucleo Software');
    $mail->addAddress('info@nucleosoftware.com', 'Nucleo Software'); // Destino

    // Contenido del mensaje
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje desde el formulario web';
    $mail->Body    = '
        <strong>Nombre:</strong> ' . htmlspecialchars($_POST['nombre']) . '<br>
        <strong>Email:</strong> ' . htmlspecialchars($_POST['correo']) . '<br>
        <strong>Mensaje:</strong><br>' . nl2br(htmlspecialchars($_POST['mensaje'])) . '
    ';

    $mail->send();
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}
