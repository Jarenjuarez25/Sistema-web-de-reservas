<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../library/PHPMailer-master/src/PHPMailer.php';
require '../library/PHPMailer-master/src/SMTP.php';
require '../library/PHPMailer-master/src/Exception.php';

function enviarCorreoPago($correo, $nombre ,$monto_total, $metodo_pago, $n_operacion, $estado){
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
        $mail->setFrom('juarezjarengamer@gmail.com', 'Soporte RestCevicheria Luigys');
        $mail->addAddress($correo, $metodo_pago); // Email y nombre del destinatario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Confirmacion de pago';
        $mail->Body = "Hola $nombre,<br><br>
                      Hemos registrado tu pago de tu reserva correctamente, puedes verificar el estado de aceptacion en Mis pagos!.<br>
                      Detalles del pago:<br>
                      Método de pago: $metodo_pago<br>
                      N° de operación: $n_operacion<br>
                      Estado: $estado<br>
                      Monto Total: $monto_total<br><br>
                      Gracias por tu compra.<br><br>
                      Saludos,<br>
                      Soporte RestCevicheria Luigys";

        // Enviar correo
        $mail->send();
        echo 'El correo de confirmación de pago ha sido enviado correctamente a ' . $correo;
    } catch (Exception $e) {
        echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
    }
}