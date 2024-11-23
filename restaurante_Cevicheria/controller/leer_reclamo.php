<?php
require_once '../database/conexion.php';

$con = new Conexion();

$id = $_GET['id'];

$con->leer_reclamo($id);

header('Location: /restaurante_Cevicheria/Principal_admin/gestion_reclamos/index.php');
?>