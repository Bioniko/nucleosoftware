<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer debe estar instalado

$estado = ''; // éxito o error
$mensaje = ''; // contenido que se mostrará

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = $_POST['nombre'] ?? 'Invitado';
    $correo   = $_POST['correo'] ?? 'no-reply@tudominio.com';
    $mensajeTexto  = $_POST['mensaje'] ?? '';
    $celular  = $_POST['celular'] ?? '';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93a50b001@smtp-brevo.com'; // Tu SMTP user de Brevo
        $mail->Password   = 'EBCkFzHsp304ThKf';          // Tu clave SMTP
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
            <strong>Mensaje:</strong><br>$mensajeTexto
        ";

        $mail->send();
        $estado = 'exito';
        $mensaje = 'Tu mensaje ha sido enviado correctamente.';
    } catch (Exception $e) {
        $estado = 'error';
        $mensaje = 'Error al enviar el mensaje: ' . $mail->ErrorInfo;
    }
}
?>

<!-- HTML de alerta personalizada -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje</title>
    <style>
        body {
            background-color: #1e3968;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .alert-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        .alert-box h2 {
            color: <?= $estado === 'exito' ? '#1e3968' : '#dc3545' ?>;
            margin-bottom: 15px;
        }
        .alert-box p {
            font-size: 16px;
            margin-bottom: 25px;
        }
        .alert-box button {
            padding: 10px 20px;
            background-color: <?= $estado === 'exito' ? '#1e3968' : '#dc3545' ?>;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .alert-box button:hover {
            background-color: <?= $estado === 'exito' ? '#1e3968' : '#c82333' ?>;
        }
    </style>
</head>
<body>
    <div class="alert-box">
        <h2><?= $estado === 'exito' ? '¡Éxito!' : '¡Error!' ?></h2>
        <p><?= htmlspecialchars($mensaje) ?></p>
        <button onclick="window.location.href='/'">Volver al inicio</button>
    </div>
</body>
</html>
