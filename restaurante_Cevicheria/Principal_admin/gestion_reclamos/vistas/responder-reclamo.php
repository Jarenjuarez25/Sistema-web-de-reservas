<?php
require_once '../../../database/conexion.php';
$con = new Conexion;

$id = $_GET['id'];

$reclamo = $con->ReclamosCod($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Reclamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style_admin.css" />
</head>
<body>
    <div id="loaderPagina" class="section_loader">
        <div class="loader">
                <div class="loader_1"></div>
                <div class="loader_2"></div>
        </div>
    </div>

    <div class="container mt-5">
        <button onclick="history.back()" class="btn btn-secondary mb-3" style="margin-top: -22px;"><i class="fas fa-arrow-left"></i> Regresar</button>
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-reply"></i> Responder</h2>
            </div>
            <div class="card-body">
                <form id="respuestaForm" method="post" action="/restaurante_Cevicheria/controller/responder.php">
                    <input hidden type="text" value="<?=$reclamo[0]['id'] ?? '' ?>" name="id">
                    <input hidden type="text" id="estadoInput" value="Pendiente" name="estado">
                    
                    <div class="form-group">
                        <label for="gmail"><i class="fas fa-envelope"></i> Gmail</label>
                        <input type="text" class="form-control" id="gmail" value="<?=$reclamo[0]['correo'] ?? '' ?>" name="gmail" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                        <input type="text" class="form-control" id="telefono" value="<?=$reclamo[0]['telefono'] ?? '' ?>" name="telefono" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="asunto"><i class="fas fa-tag"></i> Asunto</label>
                        <input type="text" class="form-control" id="asunto" value="<?=$reclamo[0]['asunto'] ?? '' ?>" name="asunto" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="mensaje"><i class="fas fa-comment"></i> Reclamo</label>
                        <textarea class="form-control" id="mensaje" name="descripcion" rows="4" readonly><?=$reclamo[0]['descripcion'] ?? '' ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="respuesta"><i class="fas fa-edit"></i> Respuesta</label>
                        <textarea class="form-control" id="respuesta" name="respuesta" rows="4"><?=$reclamo[0]['respuesta'] ?? '' ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <input type="hidden" class="form-control <?php echo ($reclamo[0]['estado'] == 'Pendiente') ? 'estado-pendiente' : 'estado-resuelto'; ?>" id="estado" value="<?=$reclamo[0]['estado'] ?? 'Pendiente' ?>" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top: 30px;"><i class="fas fa-paper-plane"></i> Enviar Respuesta</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/f474cdaeab.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>
