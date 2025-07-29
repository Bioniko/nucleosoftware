<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];
    $celular = $_POST['celular'];

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.myprofessionalmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@nucleosoftware.com';
        $mail->Password   = '7534f1596076e9e9e6cf7a94506bf14c';
        $mail->SMTPSecure = 'ssl'; // o 'tls'
        $mail->Port       = 465;   // o 587 para TLS

        // Remitente y destinatario
        $mail->setFrom('info@nucleosoftware.com', 'Nucleo Software');
        $mail->addAddress('info@nucleosoftware.com');

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde la web';
        $mail->Body    = "
            <strong>Nombre:</strong> $nombre<br>
            <strong>Email:</strong> $email<br>
            <strong>Celular:</strong> $celular<br>
            <strong>Mensaje:</strong><br>$mensaje
        ";

        $mail->send();
        echo 'Mensaje enviado correctamente.';
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}
?>
