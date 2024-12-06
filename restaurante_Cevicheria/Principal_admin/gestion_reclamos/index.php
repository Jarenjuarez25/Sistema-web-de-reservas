<?php
require_once '../../database/conexion.php';
$con = new Conexion();
$reclamo = $con->Mostrar_Reclamaciones();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reclamos</title>
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <button class="boton-salir" onclick="location.href='/restaurante_Cevicheria/Principal_admin/index.php'">SALIR</button>
    <nav class="menu">
        <section class="menu_contenedor">
            <h1 class="menu_logo"> Panel administrativo</h1>
        </section>
    </nav>

    <div class="container my-4">
        <h2 class="text-center">Reclamos</h2>
        <div class="table-container border rounded p-3 shadow-sm">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Nombre y apellidos</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Telefono</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reclamo as $reclamos) { ?>
                        <tr>
                            <td class="text-center"><?php echo $reclamos['id']; ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($reclamos['nombre'] . ' ' . $reclamos['apellidos']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($reclamos['correo']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($reclamos['telefono']); ?></td>
                            <?php ($reclamos['asunto']); ?>
                            <?php ($reclamos['descripcion']); ?>
                            <?php ($reclamos['respuesta']); ?>
                            
                            <td class="text-center text-<?php echo $reclamos['estado'] === 'Pendiente' ? 'danger' : ($reclamos['estado'] === 'Resuelto' ? 'success' : 'warning'); ?>">
                                <?php echo htmlspecialchars(ucfirst($reclamos['estado'])); ?>
                            </td>
                            <td class="text-center">
                                <!-- Botón "Ver detalles" -->
                                <button
                                    class="btn btn-view-details btn-sm mb-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    onclick="showDetails('<?php echo htmlspecialchars(json_encode($reclamos)); ?>')">
                                    Ver detalles
                                </button>

                                <!-- Mostrar botones según el estado -->

                                <?php } if ($reclamos['estado'] === 'En proceso') { ?>
                                    <!-- Botones para reclamos pendientes -->
                                    <a href="/restaurante_Cevicheria/Principal_admin/gestion_reclamos/vistas/responder-reclamo.php?id=<?= $reclamos['id']; ?>"
                                        class="btn btn-warning btn-sm mb-1">
                                        <i class="bi bi-reply"></i> Responder
                                    </a>

                                    <?php } elseif ($reclamos['estado'] === 'Pendiente') { ?>
                                    <a href="/restaurante_Cevicheria/controller/leer_reclamo.php?id=<?= $reclamos['id']; ?>"
                                        class="btn btn-success btn-sm mb-1">
                                        <i class="bi bi-check-circle"></i> Aceptar
                                    </a>

                                    <?php } else { ?>
                                <td>No disponible</td>
                            <?php } ?>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Detalles -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailModalLabel">Detalles del Reclamo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Usuario:</strong> <span id="detail-usuario"></span></li>
                        <li class="list-group-item"><strong>Asunto:</strong> <span id="detail-asunto"></span></li>
                        <li class="list-group-item"><strong>Mensaje:</strong> <span id="detail-mensaje"></span></li>
                        <li class="list-group-item"><strong>Respuesta:</strong> <span id="detail-respuesta"></span></li>
                        <li class="list-group-item"><strong>Fecha de Registro:</strong> <span id="detail-fecha"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
    <script src="script.js"></script>
</body>

</html>