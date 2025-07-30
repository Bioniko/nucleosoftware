<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir autoload de Composer
require __DIR__ . '/vendor/autoload.php';

use SendGrid\Mail\Mail;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre  = $_POST['nombre'] ?? 'Invitado';
    $correo  = $_POST['correo'] ?? 'sin@correo.com';
    $mensaje = $_POST['mensaje'] ?? 'Mensaje vacío';
    $celular = $_POST['celular'] ?? 'No proporcionado';

    // Crear el correo
    $email = new Mail();
    $email->setFrom("info@nucleosoftware.com", "Nucleo Software");
    $email->setSubject("Nuevo mensaje desde el formulario web");
    $email->addTo("info@nucleosoftware.com", "Nucleo Software");

    // Opcional: permitir responder al usuario que llenó el formulario
    $email->setReplyTo($correo, $nombre);

    // Contenido HTML del correo
    $contenido = "
        <strong>Nombre:</strong> $nombre<br>
        <strong>Correo:</strong> $correo<br>
        <strong>Celular:</strong> $celular<br>
        <strong>Mensaje:</strong><br>$mensaje
    ";
    $email->addContent("text/html", $contenido);

    // Instancia SendGrid
    $sendgrid = new \SendGrid('AQUI_VA_TU_API_KEY');

    // Enviar
    try {
        $response = $sendgrid->send($email);
        if ($response->statusCode() >= 200 && $response->statusCode() < 300) {
            echo "Mensaje enviado correctamente.";
        } else {
            echo "Error al enviar. Código: " . $response->statusCode();
        }
    } catch (Exception $e) {
        echo 'Excepción capturada: ' . $e->getMessage();
    }
}
