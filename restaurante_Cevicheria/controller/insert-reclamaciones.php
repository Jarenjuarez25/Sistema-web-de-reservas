<?php
session_start();
require_once '../database/conexion.php';
require_once '../library/PHPMailer-master/enviar_msj_reclamacion.php';

$con = new Conexion();


if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Necesitas iniciar sesión para enviar una reclamación.');
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/Login/index.php';
    </script>";
    exit();
}


$user_id = $_SESSION['user_id'];
$email = $_SESSION['user_email'];


if (isset($_POST['telefono'], $_POST['asunto'], $_POST['descripcion'])) {
    $telefono = $_POST['telefono'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];

    try {
        $con->insertReclamaciones($user_id, $telefono, $asunto, $descripcion);
        
        enviarCorreoReclamacion($email, $telefono, $asunto, $descripcion);

        echo "<script>
            alert('¡Reclamación enviada exitosamente! Mira tu reclamo en tu correo o en Mis Reclamos');
            window.location.href = '/restaurante_Cevicheria/index.php';
        </script>";
        exit();
    } catch (Exception $e) {
        echo "<script>
            alert('Hubo un error al procesar tu reclamación. Por favor, intenta nuevamente.');
            window.location.href = '/restaurante_Cevicheria/Principal_usuario/reclamos/index.php';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('Por favor, completa todos los campos del formulario.');
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/reclamos/index.php';
    </script>";
    exit();
}
?>