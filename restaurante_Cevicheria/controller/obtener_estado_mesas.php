<?php
    require_once '../database/conexion.php';
    header('Content-Type: application/json');

    $con = new Conexion();
    $conexion = $con->getConexion();

    $query = "SELECT numero_mesa, estado FROM reservas";
    $result = mysqli_query($conexion, $query);
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
    
    $mesas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $mesas[] = ['numero_mesa' => $row['numero_mesa'], 'estado' => $row['estado']];
    }
    
    // Retorna los datos como JSON.
    header('Content-Type: application/json');
    echo json_encode($mesas);

    
?>
