<?php
session_start();
require_once '../database/conexion.php';

$con = new Conexion();

$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($token) {
    $usuario_id = $con->verifyToken($token);
    if ($usuario_id) {
        // Token válido y no expirado
        $con->verifyEmail($usuario_id);
        header("Location: /restaurante_Cevicheria/Principal_usuario/Verifi-interfa/exitosa.html");
        exit();
    } else {
        // Token inválido o expirado
        header("Location: /restaurante_Cevicheria/Principal_usuario/Verifi-interfa/expirado.html");
        exit();
    }
} else {
    header("Location: /restaurante_Cevicheria/Principal_usuario/Verifi-interfa/error.html");
    exit();
}
?>
