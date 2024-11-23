<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '../src/PHPMailer.php';
require_once __DIR__ . '../src/SMTP.php';
require_once __DIR__ . '../src/Exception.php';

function enviarRespuestaReclamacion($correo, $asunto, $mensaje, $respuesta) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'juarezjarengamer@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'xiek qjhe pdok ckip'; // Tu contraseña de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del remitente y destinatario
        $mail->setFrom('juarezjarengamer@gmail.com', 'Soporte ResCevicheria Luigys');
        $mail->addAddress($correo, $asunto); // Email y nombre del destinatario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Respuesta de reclamo.';
        $mail->Body = "Tu reclamo con el asunto: $asunto. Y el mensaje:<br><br>
        <p>$mensaje</p><br><br>
        Ya tiene una respuesta:<br><br>
        <p>$respuesta</p><br><br>
        Gracias por elegirnos como tu primera opcione!.<br><br>
        Saludos,<br> Soporte ResCevicheria Luigys";

        // Enviar correo
        $mail->send();
        echo 'El correo de verificación ha sido enviado correctamente a ' . $correo;
    } catch (Exception $e) {
        echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
    }
}
?>
