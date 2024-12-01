<?php
session_start();
require_once '../database/conexion.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$con = new Conexion();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $dni = $_POST['dni'];
    $fecha_nacimiento = $_POST['telefono'];

    // Validar y actualizar datos de la tabla persona
    $con->updatePersona($user_id, $nombre, $apellido_p, $dni, $fecha_nacimiento);
    // Actualizar el primer nombre en la tabla usuario
    $con->updateUsuarioNombre($user_id, $nombre);

    $_SESSION['mensaje'] = "Datos actualizados correctamente.";
    $_SESSION['tipo_mensaje'] = "exito";
    header("Location: /restaurante_Cevicheria/profile.php");
    exit();
}
?>
