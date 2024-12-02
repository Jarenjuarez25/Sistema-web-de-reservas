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
    $imagen = ''; 

    try {
        // Manejar la subida de la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $uploadDir = __DIR__ . '../../uploads-comprobantes/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); 
            }
            $fileExtension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $fileExtension; 
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                $imagen = $fileName;
            }
        }

        if ($con->insertarPago($user_id, $nombre, $monto_total, $metodo_pago, $n_operacion, $estado, $imagen)) {
            enviarCorreoPago($correo, $nombre, $monto_total, $metodo_pago, $n_operacion, $estado);

            $_SESSION['mensaje'] = 'Pago exitoso. Verifique su correo o en Mis Pagos para más información.';
            $_SESSION['tipo_mensaje'] = 'exito';
            header("Location: /restaurante_Cevicheria/profile.php");
            exit();
        } else {
            $_SESSION['mensaje'] = 'Error al confirmar el pago. Inténtalo nuevamente.';
            $_SESSION['tipo_mensaje'] = 'error';
            header("Location: /restaurante_Cevicheria/profile.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['mensaje'] = 'Error al confirmar el pago: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
        header("Location: /restaurante_Cevicheria/profile.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = 'Error: El formulario no se envió correctamente.';
    $_SESSION['tipo_mensaje'] = 'error';
    header("Location: /restaurante_Cevicheria/profile.php");
    exit();
}
?>
