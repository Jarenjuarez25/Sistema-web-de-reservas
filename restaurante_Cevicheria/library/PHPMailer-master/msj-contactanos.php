<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';
require __DIR__ . '/src/Exception.php';

function enviarCorreoReclamacion($nombre_completo,$apellido_completo, $telefono,$correo, $asunto, $descripcion) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'juarezjarengamer@gmail.com';
        $mail->Password = 'xiek qjhe pdok ckip';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Configuración del remitente y destinatario
        $mail->setFrom('juarezjarengamer@gmail.com', 'Soporte RestCevicheria Luigys');
        $mail->addAddress($correo, $asunto);
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Mensaje recibido';
        $mail->Body    = "Hola!, $nombre_completo $apellido_completo <br>
                        Hemos registrado correctamente tu Mensaje con el asunto $asunto, te estaremos contactactando al número $telefono<br>
                        <br>La razón de tu mensaje es:<br>
                        <p>$descripcion</p><br>
                        Te responderemos lo antes posible,Soporte RestCevicheria Luigys";

        // Enviar correo
        $mail->send();
    } catch (Exception $e) {
        echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
    }
}
?>
