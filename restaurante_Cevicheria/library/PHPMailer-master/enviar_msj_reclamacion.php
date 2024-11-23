<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';
require __DIR__ . '/src/Exception.php';

function enviarCorreoReclamacion($correo, $telefono, $asunto, $descripcion) {
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
        $mail->setFrom('juarezjarengamer@gmail.com', 'Soporte ResCevicheria Luigys');
        $mail->addAddress($correo, $asunto);
        
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Reclamacion enviada';
        $mail->Body    = "Hemos registrado correctamente tu reclamación con el asunto $asunto, te estaremos contactactando al número $telefono<br>
                        <br>La razón de tu reclamación es:<br><br>
                        <p>$descripcion</p><br><br>
                      Te responderemos lo antes posible, revisa el estado de tu reclamación en Mis Reclamaciones desde Mi perfil en la pagina Web.<br><br>Saludos,<br>Soporte ResCevicheria Luigys";

        // Enviar correo
        $mail->send();
    } catch (Exception $e) {
        echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
    }
}
?>
