<?php
require_once '../../database/conexion.php';
require_once '../library/enviar_rpta_reclamacion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = new Conexion();
    
    try {
 
        $sqlReclamo = "SELECT email, asunto, descripcion FROM lireclamos WHERE id = ?";
        $stmtReclamo = $con->prepare($sqlReclamo);
        $stmtReclamo->execute([$_POST['id_reclamo']]);
        $reclamo = $stmtReclamo->fetch(PDO::FETCH_ASSOC);
        
   
        $sql = "UPDATE lireclamos SET estado = 'Resuelto', respuesta = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$_POST['respuesta'], $_POST['id_reclamo']]);
        
        enviarRespuestaReclamacion(
            $reclamo['email'],
            $reclamo['asunto'],
            $reclamo['descripcion'],
            $_POST['respuesta']
        );
        
        echo "<script>
            alert('Respuesta enviada correctamente');
            window.location.href = '../admin/index.php';
        </script>";
        
    } catch (Exception $e) {
        echo "<script>
            alert('Error al enviar la respuesta: " . $e->getMessage() . "');
            window.location.href = '../admin/responder_reclamo.php?id=" . $_POST['id_reclamo'] . "';
        </script>";
    }
}
?>