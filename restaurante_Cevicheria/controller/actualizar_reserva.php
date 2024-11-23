<?php
require_once '../database/conexion.php';

$con = new Conexion();

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado = $_GET['estado'];

    $resultado = $con->actualizarEstadoReserva($id, $estado);

    if ($resultado) {
        header("Location: ../index.php?msg=estado_actualizado");
    } else {
        header("Location: ../index.php?msg=error");
    }
} else {
    header("Location: ../index.php?msg=datos_incompletos");
}
?>