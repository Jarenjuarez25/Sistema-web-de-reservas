<?php
require_once '../../database/conexion.php';
$con = new Conexion();
$reclamo = $con->Mostrar_Reclamaciones();

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width = device-width, initial-scale=1.0">
   <title>Reclamos</title>
   <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
         <h1 class="menu_logo"> Panel administrativo - RestCevicheria Luigy's</h1>
      </section>
   </nav>

    <div class="main-container">
        <div class="col-md-4">
            <h2>Reclamaciones</h2>
            <div class="col-md-12 mt-4">
                <table class="table table-hover table-fixed">
                    <thead class="table-dark">
                        <tr style="width: 680px">
                            <th style="width: 50px">ID</th>
                            <th style="width: 247px">Correo</th>
                            <th style="width: 100px">Teléfono</th>
                            <th style="width: 180px">Asunto</th>
                            <th style="width: 150px">Mensaje</th>
                            <th style="width: 180px">Respuesta</th>
                            <th style="width: 90px">Estado</th>
                            <th style="width: 180px">Fecha de Reclamación</th>
                            <th style="width: 190px">Acción</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reclamo as $reclamos) { ?>
                        <tr style="width: 680px">
                            <td style="width: 50px"><?php echo $reclamos['id']; ?></td>
                            <td style="width: 247px"><?php echo $reclamos['correo']; ?></td>
                            <td style="width: 100px"><?php echo $reclamos['telefono']; ?></td>
                            <td style="width: 150px"><?php echo $reclamos['asunto']; ?></td>
                            <td style="width: 200px"><?php echo $reclamos['descripcion']; ?></td>
                            <td style="width: 180px"><?php echo $reclamos['respuesta']; ?></td>
                            <td style="width: 100px; color: 
                                <?php 
                                    switch (strtolower($reclamos['estado'])) {
                                        case 'pendiente':
                                            echo 'red';
                                            break;
                                        case 'en proceso':
                                            echo 'blue';
                                            break;
                                        case 'resuelto':
                                            echo 'green';
                                            break;
                                        default:
                                            echo 'black';
                                    }
                                ?>">
                                <?php echo htmlspecialchars($reclamos['estado']); ?>
                            </td>
                            <td><?php echo $reclamos['fecha_reclamo']; ?></td>
                            <?php if ($reclamos['estado'] === 'Resuelto') { ?>
                            <td><button class="btn btn-success btn-sm" disabled>Resuelto</button></td>
                            <?php } elseif ($reclamos['respuesta'] === null && $reclamos['estado'] == 'Pendiente') { ?>
                            <td>
                                <a href="/restaurante_Cevicheria/Principal_admin/gestion_reclamos/vistas/responder-reclamo.php?id=<?= $reclamos['id'] ?>"
                                    class="btn btn-warning">Responder</a>
                                <a href="/restaurante_Cevicheria/controller/leer_reclamo.php?id=<?=$reclamos['id']?>"
                                    class="btn btn-success">Aceptar</a>
                            </td>
                            <?php } else { ?>
                            <td>No disponible</td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>
