<?php
session_start();
require_once '../database/conexion.php';
require_once '../library/PHPMailer-master/enviar_correo.php'; 
date_default_timezone_set('America/Lima'); // Establece la zona horaria a Perú Lima

if (!isset($_SESSION['user_id'])) {
    echo "No hay sesión iniciada";
    exit();
}

$user_id = $_SESSION['user_id'];
$con = new Conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['correo'])) {
        $correo = $_POST['correo'];

        // Verificar si el correo electrónico es válido
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com)$/', $correo)) {
            $_SESSION['mensaje'] = "Por favor, ingrese un correo válido.";
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: /restaurante_Cevicheria/profile.php");
            exit();
        }

        // Verificar si el correo ya está registrado
        if ($con->isEmailRegistered($correo)) {
            $_SESSION['mensaje'] = "El correo ya se encuentra registrado.";
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: /restaurante_Cevicheria/profile.php");
            exit();
        }
            // Obtener el nombre del usuario
            $usuario = $con->getUserDetails($user_id);

            if ($usuario && isset($usuario['nombre'])) {
                $nombreUsuario = $usuario['nombre']; 
            } else {
               echo "Error al obtener el nombre del usuario.";
            }

        $token_verificacion = bin2hex(random_bytes(20));
        $token_verificacion_expira = date('Y-m-d H:i:s', strtotime('+20 minutes'));
        $con->updateVerifiedEmail($user_id);
        $con->saveVerificationToken($user_id, $token_verificacion, $token_verificacion_expira);
        
        enviarCorreoVerificacion($correo, $nombreUsuario, $token_verificacion);

        // Actualizar el correo electrónico del usuario
        if ($con->updateEmail($user_id, $correo)) {
            $_SESSION['mensaje'] = "Correo actualizado correctamente.";
            $_SESSION['tipo_mensaje'] = "exito";
            session_unset();
            session_destroy();
            header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
            exit();
        } else {
            $_SESSION['mensaje'] = "No se pudo actualizar el correo.";
            $_SESSION['tipo_mensaje'] = "error";
            echo "Error al actualizar el correo.";
        header("Location: /restaurante_Cevicheria/profile.php");
        exit();

        }
    }

}

// Redirigir de vuelta a la página de perfil si no se reciben datos válidos por POST
header("Location: /restaurante_Cevicheria/profile.php");
exit();
?>
