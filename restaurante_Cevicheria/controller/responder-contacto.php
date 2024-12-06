<?php
require_once '../database/conexion.php';
$enviar_rpta_path = realpath(__DIR__ . '../../library/PHPMailer-master/enviar_rpta_contacto.php');

if ($enviar_rpta_path === false) {
    die('Error: No se pudo resolver la ruta absoluta. Verifique la ruta: ' . __DIR__ . '../../library/PHPMailer-master/enviar_rpta_contacto.php');
}
if (!file_exists($enviar_rpta_path)) {
    die('Error: El archivo no existe en la ruta: ' . $enviar_rpta_path);
}

require_once $enviar_rpta_path;

$con = new Conexion();

$id = $_POST['id'];
$correo = $_POST['gmail'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['descripcion'];
$respuesta = $_POST['respuesta'];

$con->update_contact($id,$respuesta);
enviarRespuestaReclamacion($nombres, $apellidos, $correo, $asunto, $mensaje, $respuesta);
echo "Respuesta confirmada y enviada a correo.";
header('Location: /restaurante_Cevicheria/Principal_admin/gestion_contacto/index.php?msg=respuesta_enviada');
?>