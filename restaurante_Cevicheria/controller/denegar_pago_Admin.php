<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante_Cevicheria/database/conexion.php';

$con = new Conexion();
$mysqli = $con->getConexion();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Actualizar el estado del pago a 'fallido'
    $query = "UPDATE pagos SET estado = 'fallido' WHERE id = ?";
    
    // Usar una declaración preparada para prevenir inyección SQL
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Actualización exitosa
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/restaurante_Cevicheria/Principal_admin/reservas.php?status=pago_denegado");
        exit();
    } else {
        // Error en la actualización
        header("Location: ../Principal_admin/reservas.php?error=pago_fallido");
        exit();
    }
} else {
    // No se proporcionó ID
    header("Location: ../Principal_admin/reservas.php?error=no_id");
    exit();
}
?>