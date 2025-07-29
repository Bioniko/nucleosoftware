<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar la librería de SendGrid
require __DIR__ . '/vendor/autoload.php';
use SendGrid\Mail\Mail;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = $_POST['nombre'] ?? 'Invitado';
    $email   = $_POST['correo'] ?? 'info@nucleosoftware.com';
    $mensaje = $_POST['mensaje'] ?? 'Mensaje vacío';

    $emailSend = new Mail();
    $emailSend->setFrom("info@nucleosoftware.com", "Nucleo Software");
    $emailSend->setSubject("Nuevo mensaje desde el formulario web");
    $emailSend->addTo("info@nucleosoftware.com", "Nucleo Software");
    $emailSend->setReplyTo($email, $nombre);
    $emailSend->addContent(
        "text/html",
        "<strong>Nombre:</strong> $nombre<br><strong>Email:</strong> $email<br><strong>Mensaje:</strong><br>$mensaje"
    );

    $sendgrid = new \SendGrid('SG.4xWjvXaNQm6vNFnzaqKLZQ.qQ0_OwqEXAMPLEVsgSVCZqTVmIkjMk');

    try {
        $response = $sendgrid->send($emailSend);
        echo "Respuesta: " . $response->statusCode();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

