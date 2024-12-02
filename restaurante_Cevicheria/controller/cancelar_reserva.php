<?php
require_once '../database/conexion.php';

if (isset($_GET['id'])) {
    $idReserva = intval($_GET['id']); 
    $conexion = (new Conexion())->getConexion();

    $sql = "UPDATE reservas SET estado = 'Cancelado' WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idReserva);

    if ($stmt->execute()) {
        header("Location: /restaurante_Cevicheria/profile.php?mensaje=cancelado");
    } else {
        header("Location: /restaurante_Cevicheria/profile.php?mensaje=error");
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "<script>
        alert('Id no proporcionado');
        window.location = '/restaurante_Cevicheria/index.php';
    </script>";
    exit;
}

if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];
    
    // Perform cancellation logic
    $result = $con->cancelReservation($reservationId);
    
    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit();
}


?>
