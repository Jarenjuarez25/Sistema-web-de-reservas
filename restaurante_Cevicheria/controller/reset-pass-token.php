<?php
session_start();
require_once '../database/conexion.php';

$con = new Conexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $email = $_SESSION['reset_email'];

    // Validar el token
    $result = $con->validateResetToken($email, $token);
    if ($result) {
        // Token válido
        echo json_encode(['success' => true]);
    } else {
        // Token inválido
        echo json_encode(['success' => false, 'message' => 'El token es incorrecto o ha expirado.']);
    }
}
?>
