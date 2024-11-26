<?php
require_once '../database/conexion.php';
$enviar_rpta_path = realpath(__DIR__ . '../../library/PHPMailer-master/enviar_rpta_reclamacion.php');

if ($enviar_rpta_path === false) {
    die('Error: No se pudo resolver la ruta absoluta. Verifique la ruta: ' . __DIR__ . '../../library/PHPMailer-master/enviar_rpta_reclamacion.php');
}
if (!file_exists($enviar_rpta_path)) {
    die('Error: El archivo no existe en la ruta: ' . $enviar_rpta_path);
}

require_once $enviar_rpta_path;

$con = new Conexion();

$id = $_POST['id'];
$correo = $_POST['gmail'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['descripcion'];
$respuesta = $_POST['respuesta'];
$estado = $_POST['estado'];

$con->edit_reclamo($id,$respuesta,$estado);
enviarRespuestaReclamacion($correo,$asunto,$mensaje,$respuesta);
echo "Respuesta confirmada y enviada a correo.";
header('Location: /restaurante_Cevicheria/Principal_admin/gestion_reclamos/index.php?msg=respuesta_enviada');
?>