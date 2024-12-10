<?php

session_start();
require_once '../database/conexion.php';

$con = new Conexion();
$conexion = $con->getConexion();

$correo = $_POST['correo'];
$password = $_POST['contra'];

$_SESSION['correo'] = $correo;
$_SESSION['user_email'] = $correo;

$sql = "SELECT * FROM tbusuario WHERE correo='$correo' AND contrasenia='$password'";
$query = mysqli_query($conexion, $sql);

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9.-]+\.)?(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com|live\.com|icloud\.com|edu\.pe)$/', $correo)) {
    $_SESSION['mensaje'] = 'Por favor, ingrese un correo valido';
    $_SESSION['tipo_mensaje'] = 'error';
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
    exit();
}

if (!$con->isEmailRegistered($correo)) {
    $_SESSION['mensaje'] = "El correo electrónico no está registrado.";
    $_SESSION['tipo_mensaje'] = "error";
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
    exit();
}

// Verificar si el correo está verificado
if (!$con->isEmailVerified($correo)) {
    $_SESSION['mensaje'] = "El correo electrónico no está verificado. <br>
        Por favor, verifica tu correo electrónico.";
    $_SESSION['tipo_mensaje'] = "error";
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
    exit();
}

// Llamar a la función para verificar las credenciales
$login_exitoso = $con->loginUser($correo, $password);

if ($login_exitoso) {
    $_SESSION['loggedin'] = true;
    $_SESSION['mensaje'] = "Inicio de sesión exitoso.";
    $_SESSION['tipo_mensaje'] = "exito";

    $rol_id = $con->getUserRole($correo);

    if ($rol_id == 1) {
        header("Location: ../admin/index.php");
    } else {
        header("Location: ../profile.php");
    }
    exit();
} else {
    $_SESSION['mensaje'] = 'Correo o contraseña incorrectos';
    $_SESSION['tipo_mensaje'] = 'error';
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
}

mysqli_close($conexion);
