<?php
require_once '../database/conexion.php';

$con = new Conexion();

if (isset($_GET['id']) && isset($_GET['rol'])) {
    $id = intval($_GET['id']);
    $rol_actual = intval($_GET['rol']);
    $rol_id = ($rol_actual == 1) ? 2 : 1;

    try {
        if (!$con->Cambiar_Rol($id, $rol_id)) {
            // Log de errores
            error_log("Error al cambiar el rol del usuario con ID $id.");
        }
    } catch (Exception $e) {
        // Registro de la excepción
        error_log($e->getMessage());
    }
}

// Redirigir a la página de usuarios en todos los casos
header('Location: /restaurante_Cevicheria/Principal_admin/gestion_usuario/index.php');
exit;

?>
