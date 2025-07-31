<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$estado = '';
$mensaje = '';

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
            <strong>Mensaje:</strong><br>$mensajeTexto
        ";

        $mail->send();
        $estado = 'exito';
        $mensaje = 'Tu mensaje ha sido enviado correctamente. Estaremos en contacto contigo.';
    } catch (Exception $e) {
        $estado = 'error';
        $mensaje = 'Error al enviar el mensaje: ' . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mensaje</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .alert-box {
            background-color: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 420px;
            width: 100%;
        }
        .alert-box h2 {
            color: #1e3968;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }
        .alert-box p {
            font-size: 1.1rem;
            margin-bottom: 25px;
            color: #333;
            line-height: 1.4;
        }
        .alert-box button {
            padding: 12px 28px;
            background-color: #1e3968;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .alert-box button:hover {
            background-color: #163060;
        }
        /* Responsividad */
        @media (max-width: 480px) {
            .alert-box {
                padding: 25px 15px;
                max-width: 320px;
            }
            .alert-box h2 {
                font-size: 1.5rem;
            }
            .alert-box p {
                font-size: 1rem;
            }
            .alert-box button {
                width: 100%;
                padding: 14px 0;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="alert-box">
        <h2><?= $estado === 'exito' ? '¡Éxito!' : '¡Error!' ?></h2>
        <p><?= htmlspecialchars($mensaje) ?></p>
        <button onclick="window.location.href='/'">Volver al inicio</button>
    </div>

    <script>
        // Redirige automáticamente después de 5 segundos
        setTimeout(() => {
            window.location.href = '/';
        }, 5000);
    </script>
</body>
</html>
