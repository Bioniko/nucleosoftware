<?php
$host = 'smtp.secureserver.net';
$port = 587;
$timeout = 10;

$connection = @fsockopen($host, $port, $errno, $errstr, $timeout);

if ($connection) {
    echo "Conexión exitosa a $host en puerto $port";
    fclose($connection);
} else {
    echo "No se pudo conectar a $host en puerto $port. Error $errno: $errstr";
}
/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

header('Content-Type: text/plain; charset=utf-8');

$mail = new PHPMailer(true);

try {
    // Configuración SMTP GoDaddy
    $mail->isSMTP();
    $mail->Host       = 'smtp.secureserver.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@nucleosoftware.com'; // Cambia por tu correo
    $mail->Password   = '7534f1596076e9e9e6cf7a94506bf14c';          // Cambia por tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587;

    // Configurar remitente y destinatario
    $mail->setFrom('info@nucleosoftware.com', 'Nucleo Software');
    $mail->addAddress('info@nucleosoftware.com', 'Nucleo Software');

    // Contenido
    $nombre  = $_POST['nombre'] ?? 'Invitado';
    $correo  = $_POST['correo'] ?? 'no-reply@nucleosoftware.com';
    $mensaje = $_POST['mensaje'] ?? 'Mensaje vacío';

    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje desde el formulario web';
    $mail->Body    = "<strong>Nombre:</strong> " . htmlspecialchars($nombre) .
                     "<br><strong>Email:</strong> " . htmlspecialchars($correo) .
                     "<br><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje));

    // Tiempo máximo para conectar SMTP
    $mail->Timeout = 15; 

    $mail->send();
    echo "Mensaje enviado correctamente.";
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}
