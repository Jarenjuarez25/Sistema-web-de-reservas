<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../library/PHPMailer-master/src/PHPMailer.php';
require '../library/PHPMailer-master/src/SMTP.php';
require '../library/PHPMailer-master/src/Exception.php';

function enviarCorreoVerificacion($email, $nombreUsuario, $token) {
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
        $mail->addAddress($email, $nombreUsuario); // Email y nombre del destinatario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Registro Rescevicheria';
        $mail->Body = "Hola $nombreUsuario,<br><br>Por favor, haz clic en el siguiente enlace para verificar tu correo:<br><br>
        <a href='http://localhost:3000/restaurante_Cevicheria/controller/verificar-email.php?token=$token'>Verificar mi correo</a><br><br>
        Este enlace expirará en 20 minutos.<br><br>Saludos,<br>Soporte RestCevicheria Luigys";

        // Enviar correo
        $mail->send();
        echo "<script>
        alert('El correo de verificación ha sido enviado correctamente a $email')
        window.location = '/restaurante_Cevicheria/Principal_usuario/Login/index.php';
      </script>";
          exit();    
    } catch (Exception $e) {
        echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
        
    }
    
}

?>
