<?php 
require_once '../../database/conexion.php';
$con = new Conexion();
$conexion  = $con->getConexion();


if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Consulta para eliminar el usuario
    $query = mysqli_query($conexion , "DELETE FROM tbusuario WHERE id = '$idUsuario'");

    if ($query) {
        // Redireccionar a la página de gestión de usuarios con un mensaje de éxito
        header("Location: ../gestion_usuario/index.php?mensaje=Usuario eliminado con éxito");
        exit();
    } else {
        // Redireccionar a la página de gestión de usuarios con un mensaje de error
        header("Location: ../gestion_usuario/index.php?mensaje=Error al eliminar el usuario");
        exit();
    }
} else {
    // Redireccionar a la página de gestión de usuarios si no se proporciona ID
    header("Location: ../gestion_usuario/index.php?mensaje=ID de usuario no proporcionado");
    exit();
}
?>