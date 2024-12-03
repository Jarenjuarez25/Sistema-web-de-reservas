<?php
session_start();
require_once '../database/conexion.php'; 
require_once '../library/PHPMailer-master/enviar_correo.php'; 
date_default_timezone_set('America/Lima'); // Establece la zona horaria a Perú Lima

if (!isset($_SESSION['user_id'])) {
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$con = new Conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['correo'])) {
        $email = $_POST['correo'];

        // Verificar si el correo electrónico es válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com)$/', $email)) {
            $_SESSION['mensaje'] = "Por favor, ingrese un correo válido.";
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: ../profile.php");
            exit();
        }

        // Verificar si el correo ya está registrado
        if ($con->isEmailRegistered($email)) {
            $_SESSION['mensaje'] = "El correo ya se encuentra registrado.";
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: ../profile.php");
            exit();
        }

        $token_verificacion = bin2hex(random_bytes(32));
        $token_verificacion_expira = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        $con->updateVerifiedEmail($user_id);
        $con->saveVerificationToken($user_id, $token_verificacion, $token_verificacion_expira);
        enviarCorreoVerificacion($email, $nombre, $token_verificacion);

        // Actualizar el correo electrónico del usuario
        if ($con->updateEmail($user_id, $email)) {
            $_SESSION['mensaje'] = "Email actualizado correctamente. Verificalo.";
            $_SESSION['tipo_mensaje'] = "exito";
            session_unset();
            session_destroy();
            header("Location: ../login.php");
        exit();
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el email.";
            $_SESSION['tipo_mensaje'] = "error";
        }

        header("Location: ../profile.php");
        exit();
    }

}

// Redirigir de vuelta a la página de perfil si no se reciben datos válidos por POST
header("Location: ../profile.php");
exit();
?>
