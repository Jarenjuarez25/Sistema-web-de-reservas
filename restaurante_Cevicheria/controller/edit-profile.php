<?php
session_start();
require_once '../database/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$con = new Conexion();
$user_id = $_SESSION['user_id'];

// Server-side validations
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $nombre)) {
        $errors[] = "El nombre solo debe contener letras";
    }

    $apellido_p = $_POST['apellido_p'];
    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $apellido_p)) {
        $errors[] = "El Apellido solo debe contener letras";
    }

    $dni = $_POST['dni'];
    if (!preg_match('/^\d{8}$/', $dni)) {
        $errors[] = "El DNI debe contener 8 dígitos y no debe tener letras o caracteres especiales";
    }

    if (empty($errors)) {
        $fecha_nacimiento = $_POST['telefono']; 

        $con->updatePersona($user_id, $nombre, $apellido_p, $dni, $fecha_nacimiento);
        // Actualizar el primer nombre en la tabla usuario
        $con->updateUsuarioNombre($user_id, $nombre);

        $_SESSION['mensaje'] = "Datos actualizados correctamente.";
        $_SESSION['tipo_mensaje'] = "exito";
        header("Location: /restaurante_Cevicheria/profile.php");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: /restaurante_Cevicheria/profile.php");
        exit();
    }
}
?>