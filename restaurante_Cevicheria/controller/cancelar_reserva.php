<?php
session_start();
require_once '../database/conexion.php';

if (isset($_GET['id'])) {
    $idReserva = intval($_GET['id']); 
    $conexion = (new Conexion())->getConexion();

    $sql = "UPDATE reservas SET estado = 'Cancelado' WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idReserva);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Reserva cancelada exitosamente.";
        $_SESSION['tipo_mensaje'] = "exito";
        echo json_encode(['status' => 'success']);
    } else {
        $_SESSION['mensaje'] = "Error al cancelar la reserva.";
        $_SESSION['tipo_mensaje'] = "error";
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conexion->close();
} else {
    $_SESSION['mensaje'] = "No se especificó una reserva para cancelar.";
    $_SESSION['tipo_mensaje'] = "error";

    echo json_encode(['status' => 'error']);
}
?>
