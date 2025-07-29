<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre  = strip_tags($_POST['nombre'] ?? '');
    $correo   = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);
    $mensaje = strip_tags($_POST['mensaje'] ?? '');
    $celular = strip_tags($_POST['celular'] ?? '');

    if (empty($nombre) || !filter_var($correo, FILTER_VALIDATE_EMAIL) || empty($mensaje)) {
        http_response_code(400);
        echo "Formulario inválido.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@nucleosoftware.com';
        $mail->Password   = '7534f1596076e9e9e6cf7a94506bf14c';
        $mail->SMTPSecure = 'tls'; // o 'tls' si usás puerto 587
        $mail->Port       = 587;

        // Detalles del correo
        $mail->setFrom('info@nucleosoftware.com', 'Nucleo Software');
        $mail->addAddress('info@nucleosoftware.com'); // destinatario
        $mail->addReplyTo($correo, $nombre); // por si quieren responder

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde el formulario de contacto';
        $mail->Body    = "
            <strong>Nombre:</strong> {$nombre}<br>
            <strong>Correo:</strong> {$correo}<br>
            <strong>Celular:</strong> {$celular}<br>
            <strong>Mensaje:</strong><br>
            " . nl2br($mensaje);

        $mail->send();
        echo "Mensaje enviado correctamente.";
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}
?>
