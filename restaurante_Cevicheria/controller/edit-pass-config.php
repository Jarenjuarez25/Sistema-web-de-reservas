<?php
session_start();
require_once '../database/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$con = new Conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar la contraseña actual
    $result = $con->getUserDetails($user_id);
    if ($result && password_verify($current_password, $result['contrasenia'])) {
        // Validar si las nuevas contraseñas coinciden
        if ($new_password !== $confirm_password) {
            $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: ../profile.php");
            exit();
        }

                // Validar la fortaleza de la contraseña
                if (strlen($new_password) < 8) {
                    $_SESSION['mensaje'] = "La contraseña debe tener al menos 8 caracteres.";
                    $_SESSION['tipo_mensaje'] = "error";
                    header("Location: ../profile.php");
                    exit();
                } elseif (!preg_match('/[A-Z]/', $new_password)) {
                    $_SESSION['mensaje'] = "La contraseña debe tener al menos una letra mayúscula.";
                    $_SESSION['tipo_mensaje'] = "error";
                    header("Location: ../profile.php");
                    exit();
                } elseif (!preg_match('/\d/', $new_password)) {
                    $_SESSION['mensaje'] = "La contraseña debe tener al menos un número.";
                    $_SESSION['tipo_mensaje'] = "error";
                    header("Location: ../profile.php");
                    exit();
                } elseif (!preg_match('/[!@#$%^&*()\-_=+{}\[\]:;"\'<>,.?\/|\\\`~¡¿]/', $new_password)) {
                    $_SESSION['mensaje'] = "La contraseña debe tener al menos un carácter especial.";
                    $_SESSION['tipo_mensaje'] = "error";
                    header("Location: ../profile.php");
                    exit();
                }
                
        // Actualizar la contraseña del usuario (sin hashear)
        if ($con->updateUserPasswordById($user_id, $new_password)) {
            $_SESSION['mensaje'] = "Contraseña actualizada correctamente.";
            $_SESSION['tipo_mensaje'] = "exito";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar la contraseña.";
            $_SESSION['tipo_mensaje'] = "error";
        }
    } else {
        $_SESSION['mensaje'] = "La contraseña actual es incorrecta.";
        $_SESSION['tipo_mensaje'] = "error";
    }

    header("Location: ../profile.php");
    exit();
}

// Redirigir de vuelta a la página de perfil si no se reciben datos válidos por POST
header("Location: ../profile.php");
exit();

?>
