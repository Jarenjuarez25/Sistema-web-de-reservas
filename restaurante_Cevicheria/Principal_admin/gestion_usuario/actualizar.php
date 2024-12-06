<?php
require_once '../../database/conexion.php';
$con = new Conexion();
$conexion = $con->getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario = $_POST['idUsuario'];  
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];


    $sql = "UPDATE tbusuario SET dni = '$dni', nombre = '$nombre', apellidos = '$apellidos', correo = '$correo' WHERE id = '$idUsuario'";
    $query = mysqli_query($conexion, $sql);
    
    if ($query) {
        echo "<script>
                alert('Usuario actualizado exitosamente');
                window.location = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al actualizar el usuario');
                window.location = 'index.php';
              </script>";
    }
    mysqli_close($conexion);
} else {
    if (isset($_GET['id'])) {
        $idUsuario = $_GET['id'];


        $sql = "SELECT * FROM tbusuario WHERE id= '$idUsuario'";
        $query = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($query);
        
        if (!$row) {
            echo "<script>
            alert('Usuario no encontrado');
            window.location = 'index.php';
          </script>";
    exit;
}
    } else {
        echo "<script>
        alert('ID no proporcionado');
        window.location = 'index.php';
      </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Actualizar Usuario</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style_admin.css" />
</head>
<body>
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style_admin.css" />    <div id="loaderPagina" class="section_loader">
        <div class="loader">
                <div class="loader_1"></div>
                <div class="loader_2"></div>
        </div>
    </div>

<div class="container mt-5">
    <h1>Actualizar Usuario</h1>
    <form action="actualizar.php?id=<?php echo $idUsuario; ?>" method="POST" onsubmit="return validarFormularioRegister()";>

        <input type="hidden" name="idUsuario" value="<?php echo ($row['id']); ?>">
        
        <label>DNI:</label>
        <input type="text" id="dni" class="form-control mb-3" name="dni" value="<?php echo ($row['dni'] ?? ''); ?>" placeholder="Dni*" maxlength="8" minlength="8" required>
        
        <label>Nombre:</label>
        <input type="text" id="nombre" class="form-control mb-3" name="nombre" value="<?php echo ($row['nombre'] ?? ''); ?>" placeholder="Nombre*"required>
        
        <label>Apellidos:</label>
        <input type="text" id="apellidos" class="form-control mb-3" name="apellidos" value="<?php echo ($row['apellidos'] ?? ''); ?>" placeholder="Apellidos*"required>
        
        <label>Correo:</label>
        <input type="email" id="correo" class="form-control mb-3" name="correo" value="<?php echo ($row['correo'] ?? ''); ?>" readonly placeholder="Correo*">
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

    <script src="script.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>
