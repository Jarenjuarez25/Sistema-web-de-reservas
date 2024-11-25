<?php 
session_start(); 
require_once '../database/conexion.php'; 
require_once '../library/PHPMailer-master/enviar_correo.php'; 

date_default_timezone_set('America/Lima');

$con = new Conexion();

// Recibir datos del formulario
$nombre = $_POST['nombre']; 
$apellidos = $_POST['apellidos']; 
$dni = $_POST['dni']; 
$correo = $_POST['correo']; 
$contrasenia = $_POST['contraseña']; 
$confirmarContrasenia = $_POST['confirmarContraseña']; 
$genero = $_POST['genero']; 
$fechaNacimiento = $_POST['fechaNacimiento'];

// Verificar si el correo ya está registrado
if ($con->isEmailRegistered($correo)) {
    echo "<script>
        alert('El correo ya está registrado');
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=registro';
    </script>";
    exit();
} else {
    // Proceder con el registro si el correo no existe
    $sql_usuario = $con->insertUser($nombre, $apellidos, $dni, $correo, $contrasenia, $genero, $fechaNacimiento);
    
    // Generar token de verificación
    $token_verificacion = bin2hex(random_bytes(20));
    $token_verificacion_expira = date('Y-m-d H:i:s', strtotime('+20 minutes'));
    
    // Actualizar tbusuario con el token
    $con->saveVerificationToken($sql_usuario, $token_verificacion, $token_verificacion_expira);
    
    enviarCorreoVerificacion($correo, $nombre, $token_verificacion);
    
    // Redirigir al login con un mensaje
    echo "<script>
        alert('Registro exitoso. Por favor, verifica tu correo.');
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/Login/index.php';
    </script>";
    exit();
}

?>