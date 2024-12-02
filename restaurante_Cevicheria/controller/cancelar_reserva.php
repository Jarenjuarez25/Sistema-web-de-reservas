<?php
require_once '../database/conexion.php';

if (isset($_GET['id'])) {
    $idReserva = intval($_GET['id']); 
    $conexion = (new Conexion())->getConexion();

    // Preparamos la consulta para actualizar el estado de la reserva
    $sql = "UPDATE reservas SET estado = 'Cancelado' WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idReserva);

    if ($stmt->execute()) {
        // Responder con éxito en formato JSON
        echo json_encode(['status' => 'success']);
    } else {
        // En caso de error, responder con error en formato JSON
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conexion->close();
} else {
    // Si no se proporciona un ID, responder con error
    echo json_encode(['status' => 'error']);
}
?>
