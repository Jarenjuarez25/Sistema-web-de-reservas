<?php 
session_start(); 
require_once '../database/conexion.php'; 
require_once '../library/PHPMailer-master/enviar_correo.php'; 

date_default_timezone_set('America/Lima');

$con = new Conexion();

$nombre = $_POST['nombre']; 
$apellidos = $_POST['apellidos']; 
$dni = $_POST['dni']; 
$correo = $_POST['correo']; 
$contrasenia = $_POST['contraseña']; 
$confirmarContrasenia = $_POST['confirmarContraseña']; 
$genero = $_POST['genero']; 
$fechaNacimiento = $_POST['fechaNacimiento'];

if ($con->isEmailRegistered($correo)) {
    echo "<script>
        alert('El correo ya está registrado');
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=registro';
    </script>";
    exit();
} else {
    $sql_usuario = $con->insertUser($nombre, $apellidos, $dni, $correo, $contrasenia, $genero, $fechaNacimiento);
    
    $token_verificacion = bin2hex(random_bytes(20));
    $token_verificacion_expira = date('Y-m-d H:i:s', strtotime('+20 minutes'));
    
    $con->saveVerificationToken($sql_usuario, $token_verificacion, $token_verificacion_expira);
    
    enviarCorreoVerificacion($correo, $nombre, $token_verificacion);
    
    echo "<script>
        alert('Registro exitoso. Por favor, verifica tu correo.');
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/Login/index.php';
    </script>";
    exit();
}

?>