<?php 

session_start();
require_once '../database/conexion.php';

$con = new Conexion();
$conexion = $con->getConexion();

$correo = $_POST['correo'];
$password = $_POST['contra'];

$_SESSION['correo'] = $correo;
$_SESSION['user_email'] = $correo; 

$sql = "SELECT * FROM tbusuario WHERE correo='$correo' AND contrasenia='$password'";
$query = mysqli_query($conexion, $sql);

if(!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9.-]+\.)?(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com|live\.com|icloud\.com|edu\.pe)$/', $correo) ){
    $_SESSION['mensaje'] = 'Por favor, ingrese un correo valido';
    $_SESSION['tipo_mensaje'] = 'error';
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
    exit();
}

    if (!$con->isEmailRegistered($correo)) {
        $_SESSION['mensaje'] = "El correo electrónico no está registrado.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
        exit();
    }

    // Verificar si el correo está verificado
if (!$con->isEmailVerified($correo)) {
        $_SESSION['mensaje'] = "El correo electrónico no está verificado. <br>
        Por favor, verifica tu correo electrónico.";
        $_SESSION['tipo_mensaje'] = "error";
        header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
        exit();
}

if($query && mysqli_num_rows($query) > 0) {
    // Obtener los datos del usuario
    $usuario = mysqli_fetch_assoc($query);

                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_nombre'] = $usuario['nombre'];
                $_SESSION['user_correo'] = $usuario['correo'];
                $_SESSION['user_email'] = $usuario['correo'];
                $_SESSION['user_cargo_id'] = $usuario['cargo_id'];
    
    if ($usuario['cargo_id'] == 1) { //usuario administrador
        Header("Location: /restaurante_Cevicheria/Principal_admin/index.php");
    } elseif($usuario['cargo_id'] == 2) { //cliente
        header("Location: /restaurante_Cevicheria/index.php");
        
}
    
} else {
    $_SESSION['mensaje'] = 'Correo o contraseña incorrectos';
    $_SESSION['tipo_mensaje'] = 'error';
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php?openModal=login");
}

mysqli_close($conexion);
?>