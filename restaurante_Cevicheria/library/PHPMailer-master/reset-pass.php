<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

//Conexion a la base para la verificacion
require_once '../../database/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (empty($email)) {
        $_SESSION['mensaje'] = "Por favor ingrese un correo electrónico";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: ../../Principal_usuario/Restablecer_pass/index.php");
        exit();
    }
    
    $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    
    // Crear instancia de conexión
    $conexion = new Conexion();
    
    // Verificar si el correo existe
    if (!$conexion->isEmailRegistered($email)) {
        $_SESSION['mensaje'] = "El correo electrónico no registrado";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: ../../Principal_usuario/Restablecer_pass/index.php");
        exit();
    }
    
    // Guardar el token en la base de datos
    if ($conexion->savePasswordResetToken($email, $token)) {
        try {
            $mail = new PHPMailer(true);
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'juarezjarengamer@gmail.com';
            $mail->Password = 'xiek qjhe pdok ckip';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Configuración del correo
            $mail->setFrom('juarezjarengamer@gmail.com', 'Soporte ResCevicheria Luigys');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            // Contenido del correo
            $mail->Subject = 'Código de restablecimiento de contraseña';
            $mail->Body = "
                <p>Tu código de verificación es: <strong>$token</strong></p><p>Este código expirará en 20 minutos.</p>
                <p>Gracias por confiar en nosotros, Soporte ResCevicheria Luigys!.</p>
            ";
            
            $mail->send();
            $_SESSION['reset_email'] = $email;
            $_SESSION['mensaje'] = "Se ha enviado un código de verificación a tu correo";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: ../../Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['mensaje'] = "Error al enviar el correo: " . $mail->ErrorInfo;
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: ../../Principal_usuario/Restablecer_pass/index.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "Error al generar el token de recuperación";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: ../../Principal_usuario/Restablecer_pass/index.php");
        exit();
    }
}