<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '../src/PHPMailer.php';
require_once __DIR__ . '../src/SMTP.php';
require_once __DIR__ . '../src/Exception.php';

function enviarCorreoPago($correo,$monto,$estado){
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
        $mail->setFrom('juarezjarengamer@gmail.com', 'SOMAQ');
        $mail->addAddress($correo); // Email y nombre del destinatario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Estado de pago';
        $mail->Body = "Hola,<br><br>
                      Se actualizo el estado de tu pago.<br>
                      Detalles del pago:<br>
                      Estado: $estado<br>
                      Monto Total: $monto<br><br>
                      Gracias por preferirnos.<br><br>
                      Saludos,<br>
                      Tu equipo SOMAQ";

        $mail->send();
        echo 'El correo de verificación ha sido enviado correctamente a ' . $correo;
    } catch (Exception $e) {
        echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
    }
}
?>
