<?php
require __DIR__ . '/vendor/autoload.php';

use SendGrid\Mail\Mail;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = htmlspecialchars($_POST['nombre'] ?? '');
    $correo   = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);
    $celular  = htmlspecialchars($_POST['celular'] ?? '');
    $mensaje = htmlspecialchars($_POST['mensaje'] ?? '');

    if (empty($nombre) || !filter_var($correo, FILTER_VALIDATE_EMAIL) || empty($mensaje)) {
        http_response_code(400);
        echo "Formulario inválido.";
        exit;
    }

    $emailSend = new Mail();
    $emailSend->setFrom("info@nucleosoftware.com", "Nucleo Software");
    $emailSend->setSubject("Nuevo mensaje desde la web");
    $emailSend->addTo("info@nucleosoftware.com");
    $emailSend->addReplyTo($correo, $nombre);
    $emailSend->addContent("text/html", "
        <strong>Nombre:</strong> {$nombre}<br>
        <strong>Email:</strong> {$correo}<br>
        <strong>Nombre:</strong> {$celular}<br>
        <strong>Mensaje:</strong><br>" . nl2br($mensaje)
    );

    $sendgrid = new \SendGrid('4SRZWKNUN6R4DEX67QW3T2TR'); // <- pega aquí tu API key

    try {
        $response = $sendgrid->send($emailSend);
        if ($response->statusCode() >= 200 && $response->statusCode() < 300) {
            echo "Mensaje enviado correctamente.";
        } else {
            echo "Error al enviar: Código " . $response->statusCode();
        }
    } catch (Exception $e) {
        echo 'Excepción: ' . $e->getMessage();
    }
}
?>
