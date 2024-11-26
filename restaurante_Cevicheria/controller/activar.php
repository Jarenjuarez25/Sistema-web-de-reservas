<?php 
require_once '../database/conexion.php';
$con = new Conexion();

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $con->Activar_Usuario($id);
  header('Location: /restaurante_Cevicheria/Principal_admin/gestion_usuario/index.php');
} else {
  echo "<script>
  alert('Id no proporcionado');
  window.location = '/restaurante_Cevicheria/Principal_admin/gestion_usuario/index.php';
</script>";
}

?>