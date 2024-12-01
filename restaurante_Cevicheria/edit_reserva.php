<?php
require('database/conexion.php');
$con = new Conexion();
$conexion = $con->getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idReserva = $_POST['idReserva'];
    $cantidadPersonas = mysqli_real_escape_string($conexion, $_POST['cantidad_personas']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $fechaReserva = mysqli_real_escape_string($conexion, $_POST['fecha_reserva']);
    $turno = mysqli_real_escape_string($conexion, $_POST['turno']);
    $horaReserva = mysqli_real_escape_string($conexion, $_POST['hora_reserva']);

    $sql = "UPDATE reservas 
            SET cantidad_personas = '$cantidadPersonas', 
                descripcion = '$descripcion', 
                telefono = '$telefono', 
                fecha_reserva = '$fechaReserva', 
                turno = '$turno', 
                hora_reserva = '$horaReserva' 
            WHERE id = '$idReserva'";

    $query = mysqli_query($conexion, $sql);

    if ($query) {
        echo "<script>alert('Reserva actualizada exitosamente'); window.location.href='/restaurante_Cevicheria/profile.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la reserva: " . mysqli_error($conexion) . "');</script>";
    }

    mysqli_close($conexion);
} else {
    if (isset($_GET['id'])) {
        $idReserva = $_GET['id'];
        $sql = "SELECT * FROM reservas WHERE id = '$idReserva'";
        $query = mysqli_query($conexion, $sql);

        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
        } else {
            echo "<script>alert('No se encontró la reserva.'); window.location.href='reservas.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('No se especificó una reserva.'); window.location.href='reservas.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/restaurante_Cevicheria/css/edit_reserva.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-reservation">
                    <h2 class="text-center mb-4">Editar Reserva</h2>
                    <form method="POST" action="">
                        <input type="hidden" name="idReserva" value="<?php echo $row['id']; ?>">
                        
                        <div class="mb-3">
                            <label for="cantidad_personas" class="form-label">Cantidad de personas:</label>
                            <input type="number" class="form-control" id="cantidad_personas" name="cantidad_personas" value="<?php echo $row['cantidad_personas']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $row['descripcion']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="fecha_reserva" class="form-label">Fecha de reserva:</label>
                            <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" value="<?php echo (date('Y-m-d', strtotime($row['fecha_reserva'])));  ?>">
                        </div>

                        <div class="mb-3">
                            <label for="turno" class="form-label">Turno:</label>
                            <select class="form-select" id="turno" name="turno">
                                <option value="Mañana" <?php echo $row['turno'] == 'Mañana' ? 'selected' : ''; ?>>Mañana/10:00-11:59</option>
                                <option value="Tarde" <?php echo $row['turno'] == 'Tarde' ? 'selected' : ''; ?>>Tarde/12:00-18:00</option>
                                <option value="Tarde" <?php echo $row['turno'] == 'Noche' ? 'selected' : ''; ?>>Noche/18:01-22:00</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="hora_reserva" class="form-label">Hora de reserva:</label>
                            <input type="time" class="form-control" id="hora_reserva" name="hora_reserva" value="<?php echo $row['hora_reserva']; ?>">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button type="submit" class="btn btn-primary me-md-2">Actualizar Reserva</button>
                            <a href="/restaurante_Cevicheria/profile.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>