<?php
session_start();
require_once '../database/conexion.php';
require_once '../library/PHPMailer-master/enviar_pago.php';

$con = new Conexion();

$user_id = $_SESSION['user_id'];
$correo = $_SESSION['user_correo'];
$nombre = $_SESSION['user_nombre'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_pago'])) {
    $numero_mesa = $_POST['numero_mesa'];
    $monto_total = $_POST['monto_total']; 
    $metodo_pago = $_POST['opcion'];
    $n_operacion = $_POST['numero_operacion']; 
    $estado = 'pendiente'; 


    try {
        // Insertar el pago usando el método insertarPago
        if ($con->insertarPago($user_id, $nombre,$monto_total, $metodo_pago, $n_operacion, $estado)) {
            // Enviar correo de confirmación
            enviarCorreoPago($correo, $nombre ,$monto_total, $metodo_pago, $n_operacion, $estado);

          
            // Limpiar mensaje de sesión y redireccionar
            $_SESSION['mensaje'] = 'Pago exitoso. Verifique su correo o en Mis Pagos para más información.';
            $_SESSION['tipo_mensaje'] = 'exito';
            header("Location: /restaurante_Cevicheria/profile.php");
            exit();
        } else {
            // Error al insertar en la base de datos
            $_SESSION['mensaje'] = 'Error al confirmar el pago. Inténtalo nuevamente.';
            $_SESSION['tipo_mensaje'] = 'error';
            header("Location: /restaurante_Cevicheria/profile.php");
            exit();
        }
    } catch (Exception $e) {
        // Error al generar PDF u otro error
        $_SESSION['mensaje'] = 'Error al confirmar el pago: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
        header("Location: /restaurante_Cevicheria/profile.php");
        exit();
    }
} else {
    // Si el formulario no se envió correctamente, redireccionar o manejar el error según tu aplicación
    $_SESSION['mensaje'] = 'Error: El formulario no se envió correctamente.';
    $_SESSION['tipo_mensaje'] = 'error';
    header("Location: /restaurante_Cevicheria/profile.php");
    exit();
}
?>
