<?php
session_start();
require_once '../database/conexion.php';
require_once __DIR__ . '/../library/PHPMailer-master/reset-pass.php';


$con = new Conexion();

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

if ($accion == 'accion') {
    $email = $_POST['correo'];
    // Verificar si el correo está registrado
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9.-]+\.)?(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com|live\.com|icloud\.com|edu\.pe)$/', $email)) {
        $_SESSION['mensaje'] = "Por favor, ingrese un correo válido.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    }
    
    // Verificar si el correo está registrado
    if (!$con->isEmailRegistered($email)) {
        $_SESSION['mensaje'] = "El correo electrónico no está registrado.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    }

    // Verificar si el correo está verificado
    if (!$con->isEmailVerified($email)) {
        $_SESSION['mensaje'] = "El correo electrónico no está verificado.";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    }
    // Generar un token único para restablecer contraseña y almacenarlo en la base de datos
    $token = mt_rand(100000, 999999); // Genera un número aleatorio de 6 dígitos

    if ($con->savePasswordResetToken($email, $token)) {
        $_SESSION['reset_email'] = $email;
        enviarCorreoRecuperacionPass($email, $token);
        $_SESSION['mensaje'] = "El código de recuperación ha sido enviado a tu correo, expirará en 45 minutos.";
        $_SESSION['tipo_mensaje'] = "exito";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al generar el token de restablecimiento.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    }
}
?>
