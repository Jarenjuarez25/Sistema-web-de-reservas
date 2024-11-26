<?php
session_start();
require_once '../database/conexion.php';

$con = new Conexion();

$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($token) {
    $usuario_id = $con->verifyToken($token);
    if ($usuario_id) {
        $con->verifyEmail($usuario_id);
        header("Location: /restaurante_Cevicheria/Principal_usuario/Verifi-interfa/exitosa.html");
        exit();
    } else {
        header("Location: /restaurante_Cevicheria/Principal_usuario/Verifi-interfa/error.html");
        exit();
    }
} else {
    header("Location: /restaurante_Cevicheria/Principal_usuario/Verifi-interfa/error.html");
    exit();
}
?>
