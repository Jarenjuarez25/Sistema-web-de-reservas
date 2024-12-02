<?php
session_start();
require_once '../database/conexion.php';
require_once '../library/PHPMailer-master/enviar_pago.php';

$con = new Conexion();

$user_id = $_SESSION['user_id'];
$correo = $_SESSION['user_correo'];
$nombre = $_SESSION['user_nombre'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_pago'])) {
    $monto_total = $_POST['monto_total'];
    $metodo_pago = $_POST['opcion'];
    $n_operacion = $_POST['numero_operacion'];
    $estado = 'pendiente';
    $imagen = '';

    try {
        //subida de la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            // Validar tipo de archivo (solo imágenes)
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        
            if (!in_array($fileExtension, $allowedExtensions)) {
                $_SESSION['mensaje'] = 'Error: Solo se permiten imágenes de formato (JPG, JPEG, PNG).';
                $_SESSION['tipo_mensaje'] = 'error';
                header("Location: /restaurante_Cevicheria/profile.php");
                exit();
            }
        
            // Validar tamaño del archivo
            $maxFileSize = 10 * 1024 * 1024;
            if ($_FILES['imagen']['size'] > $maxFileSize) {
                $_SESSION['mensaje'] = 'Error: El tamaño del archivo es demasiado grande. (Máximo 10MB)';
                $_SESSION['tipo_mensaje'] = 'error';
                header("Location: /restaurante_Cevicheria/profile.php");
                exit();
            }
        
            // Directorio donde se guardarán las imágenes
            $uploadDir = __DIR__ . '../../uploads-comprobantes/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
        
            // nombre único para la imagen
            $fileName = uniqid('comprobante_', true) . '.' . $fileExtension;
            $uploadFile = $uploadDir . $fileName;
        
            // Mover el archivo al directorio de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                $imagen = $fileName;
            } else {
                $_SESSION['mensaje'] = 'Error al subir el comprobante de pago.';
                $_SESSION['tipo_mensaje'] = 'error';
                header("Location: /restaurante_Cevicheria/profile.php");
                exit();
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
