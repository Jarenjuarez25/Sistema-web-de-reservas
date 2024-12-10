<?php
session_start();
require_once '../database/conexion.php';
require_once '../library/PHPMailer-master/msj-contactanos.php';

$con = new Conexion();

if (isset($_POST['nombre_completo'],$_POST['apellido_completo'],$_POST['telefono'],$_POST['correo'], $_POST['asunto'], $_POST['descripcion'])) {
    $nombre_completo = $_POST['nombre_completo'];
    $apellido_completo = $_POST['apellido_completo'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];

    try {
        $con->insertContacto($nombre_completo,$apellido_completo,$telefono,$correo, $asunto, $descripcion);

        enviarCorreoReclamacion($nombre_completo,$apellido_completo,$telefono,$correo,  $asunto, $descripcion);

    echo "<script>
        alert('Mensaje enviado, muy pronto le responderemos!');
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/contactanos/index.php';
    </script>";
    exit();
    } catch (Exception $e) {
        $_SESSION['mensaje'] = 'Hubo un error al procesar tu reclamación. Por favor, intenta nuevamente.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: /restaurante_Cevicheria/Principal_usuario/contactanos/index.php');
        exit();
    }
} else {
    $_SESSION['mensaje'] = 'Por favor, completa todos los campos del formulario.';
    $_SESSION['tipo_mensaje'] = 'advertencia';
    header('Location: /restaurante_Cevicheria/Principal_usuario/contactanos/index.php');
    exit();
}
?>
