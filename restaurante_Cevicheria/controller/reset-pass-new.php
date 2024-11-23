<?php
session_start();
require_once '../database/conexion.php';

$con = new Conexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contrasena = $_POST['contrasenia'];
    $confirm_contrasena = $_POST['confirm_contrasenia'];
    $email = $_SESSION['reset_email'];

    // Validar si las contraseñas coinciden
    if ($contrasena !== $confirm_contrasena) {
        $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    }

    // Validar la fortaleza de la contraseña
    if (strlen($contrasena) < 8) {
        $_SESSION['mensaje'] = "La contraseña debe tener al menos 8 caracteres.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    } elseif (!preg_match('/\d/', $contrasena)) {
        $_SESSION['mensaje'] = "La contraseña debe tener al menos un número.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Restablecer_pass/restablecer-pass-formularion.php");
        exit();
    }

    // Actualizar la contraseña en la base de datos
    if ($con->updateUserPassword($email, $contrasena)) {
        // Eliminar el token después de restablecer la contraseña
        $con->deletePasswordResetToken($email);

        // Eliminar el email de la sesión
        unset($_SESSION['reset_email']);
        unset($_SESSION['valid_token']);

        $_SESSION['mensaje'] = "Tu contraseña ha sido restablecida exitosamente.";
        $_SESSION['tipo_mensaje'] = "exito";
        header("Location: /restaurante_Cevicheria/Principal_usuario/actuali_pass/exitosa.html");
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al restablecer la contraseña.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/actuali_pass/error.html");
        exit();
    }
}
?>
