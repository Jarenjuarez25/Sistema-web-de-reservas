<?php
session_start();
require_once '../database/conexion.php';
header('Content-Type: application/json');
$con = new Conexion();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$user_id = $_SESSION['user_id'];
$verificacion = $con->verificarSiExiste($user_id);
if ($verificacion['error']) {
    echo json_encode(['success' => false, 'message' => $verificacion['message']]);
    exit;
}
if ($verificacion['tieneReservas']) {
    echo json_encode(['success' => false, 'message' => 'Ya tienes una reserva activa.']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = new Conexion();
    
    $numero_mesa = $_POST['numeroMesa'];
    $cantidad_personas = $_POST['cantidadPersonas'];
    $descripcion = $_POST['descripcion'];
    
    try {
        $sql = "INSERT INTO reservas (usuario_id, numero_mesa, cantidad_personas, descripcion, estado) 
                VALUES (?, ?, ?, ?, 'Pendiente')";
        
        $stmt = $con->getConexion()->prepare($sql);
        $stmt->bind_param("iiis", $user_id, $numero_mesa, $cantidad_personas, $descripcion);
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Reserva creada exitosamente',
                'estado' => 'Reservado'
            ]);
        } else {
            throw new Exception('Error al insertar la reserva');
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
