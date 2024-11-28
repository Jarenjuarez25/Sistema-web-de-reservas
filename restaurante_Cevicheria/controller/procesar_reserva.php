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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = new Conexion();
    
    $numero_mesa = $_POST['numeroMesa'];
    $cantidad_personas = $_POST['cantidadPersonas'];
    $descripcion = $_POST['descripcion'];
    $telefono = $_POST['telefono'];
    $turno = $_POST['turno'];
    $hora = $_POST['hora'];
    
    try {
        $sql = "INSERT INTO reservas (usuario_id, numero_mesa, cantidad_personas, descripcion, estado, telefono, turno, hora_reserva, pago) 
                VALUES (?, ?, ?, ?, 'Pendiente',?,?,?,'10')";
        
        $stmt = $con->getConexion()->prepare($sql);
        $stmt->bind_param("iiissss", $user_id, $numero_mesa, $cantidad_personas, $descripcion, $telefono, $turno, $hora);
        
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
