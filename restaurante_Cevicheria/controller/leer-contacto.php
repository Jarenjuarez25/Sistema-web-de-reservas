<?php
require_once '../database/conexion.php';

$con = new Conexion();

$id = $_GET['id'];

$con->aceptar_contacto($id);

header('Location: /restaurante_Cevicheria/Principal_admin/gestion_contacto/index.php');
?>