<?php
session_start();
require_once '../database/conexion.php';


$con = new Conexion();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $con->liberar_mesa($id);
    header('Location: /restaurante_Cevicheria/Principal_admin/gestion_reservas/liberar_mesas.php');
    exit();
}
?>