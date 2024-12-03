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
    if ($result && $current_password === $result['contrasenia']) {
        // Validar si las nuevas contraseñas coinciden
        if ($new_password !== $confirm_password) {
            $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
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
