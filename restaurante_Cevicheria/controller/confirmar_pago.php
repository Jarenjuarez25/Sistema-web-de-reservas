<?php
session_start();
require_once '../database/conexion.php';
require_once '../library/PHPMailer-master/enviar_pago.php';

$con = new Conexion();

$user_id = $_SESSION['user_id'];
$correo = $_SESSION['user_correo'];
$nombre = $_SESSION['user_nombre'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_pago'])) {
    $numero_mesa = intval($_POST['numero_mesa']);
    $monto_total = $_POST['monto_total'];
    $metodo_pago = $_POST['opcion'];
    $n_operacion = $_POST['numero_operacion'];
    $nuevo_estado = "Pendiente.";
    $estado = 'Pendiente';
    $imagen = '';

    try {
        // Subida de la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception('Solo se permiten imágenes de formato (JPG, JPEG, PNG).');
            }

            $maxFileSize = 10 * 1024 * 1024;
            if ($_FILES['imagen']['size'] > $maxFileSize) {
                throw new Exception('El tamaño del archivo es demasiado grande. (Máximo 10MB)');
            }

            $uploadDir = __DIR__ . '../../uploads-comprobantes/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid('comprobante_', true) . '.' . $fileExtension;
            $uploadFile = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                throw new Exception('Error al subir el comprobante de pago.');
            }

            $imagen = $fileName;
        }

        // Insertar el pago
        if (!$con->insertarPago($user_id, $numero_mesa,$nombre, $monto_total, $metodo_pago, $n_operacion, $estado, $imagen)) {
            throw new Exception('Error al registrar el pago.');
        }

        // Actualizar estado de la reserva
        if (!$con->actualizarEstadoReserva1($user_id, $numero_mesa, $nuevo_estado)) {
            throw new Exception('No se encontró ninguna reserva para actualizar.');
        }

        // Enviar correo
        enviarCorreoPago($correo, $nombre, $monto_total, $metodo_pago, $n_operacion, $estado);

        $_SESSION['mensaje'] = 'Pago exitoso. Verifique su correo o en Mis Pagos para más información!.';
        $_SESSION['tipo_mensaje'] = 'exito';
        header("Location: /restaurante_Cevicheria/profile.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['mensaje'] = 'Error: ' . $e->getMessage();
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
