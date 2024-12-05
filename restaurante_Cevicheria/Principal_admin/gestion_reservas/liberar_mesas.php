<?php
require_once '../../database/conexion.php';
$con = new Conexion();
$reservas = $con->Mostrar_Reservas();
$pagos = $con->Mostrar_Pagos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
    <title>Gestionar reservas</title>
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style_admin.css" />
</head>

<body class="bg-light">

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

    <!--Pago-->
    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-white">
                <h2 class="text-center mb-0 text-primary">
                    <i class="fas fa-calendar-check me-2"></i> Verificación de pagos
                </h2>
            </div>

            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover align-middle mb-0 table-fixed">
                        <thead>
                            <tr style="width: 400px">
                                <th style="width: 45px" class="text-center">Id</th>
                                <th style="width: 150px" class="text-center">Usuario</th>
                                <th style="width: 80px" class="text-center">Mesa N°</th>
                                <th style="width: 310px" class="text-center">Correo</th>
                                <th class="text-center" style="width: 155px">Monto Total</th>
                                <th class="text-center" style="width: 120px">Método de Pago</th>
                                <th class="text-center" style="width: 110px">N° de operación</th>
                                <th class="text-center" style="width: 114px">Fecha de registro</th>
                                <th class="text-center" style="width: 100px">Estado</th>
                                <th class="text-center" style="width: 160px">Acción</th>
                                <th class="text-center" style="width: 80px">Comprobante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagos as $pago) { ?>
                                <tr>
                                    <td style="width: 45px" class="text-center"><?php echo $pago['id']; ?></td>
                                    <td style="width: 150px" class="text-center"><?php echo ($pago['usuario']); ?></td>
                                    <td style="width: 80px" class="text-center"><?php echo $pago['numero_mesa']; ?></td>
                                    <td style="width: 310px" class="text-center"><?php echo ($pago['correo']); ?></td>
                                    <td class="text-center" style="width: 150px"><?php echo $pago['monto_total']; ?></td>
                                    <td class="text-center" style="width: 120px"><?php echo $pago['metodo_pago']; ?></td>
                                    <td class="text-center" style="width: 110px"><?php echo $pago['n_operacion']; ?></td>
                                    <td class="text-center" style="width: 114px"><?php echo $pago['fecha_pago']; ?></td>
                                    <td class="text-center" style="width: 120px; 
                                        <?php
                                        if ($pago['estado'] === 'pendiente') {
                                            echo 'color: red;';
                                        } if ($pago['estado'] === 'completado') {
                                            echo 'color: green;';
                                        } elseif ($pago['estado'] === 'fallido') {
                                            echo 'color: red;';
                                        }
                                        ?>">
                                        <?php echo htmlspecialchars($pago['estado']); ?>
                                    </td>
                                    <td class="text-center" style="width: 160px">
                                        <?php if ($pago['estado'] === 'pendiente') { ?>
                                            <!-- Botón para confirmar -->
                                            <a href="/restaurante_Cevicheria/controller/confirmar_pago_Admin.php?id=<?= $pago['id'] 
                                            ?>" class="btn btn-warning btn-sm" style="background: #198754; border: none; color: white">
                                                <i class="fa-regular fa-circle-check"></i> Confirmar
                                            </a>
                                            <br></br>
                                            <!-- Botón para rechazar -->
                                            <a href="/restaurante_Cevicheria/controller/denegar_pago_Admin.php?id=<?= $pago['id'] 
                                            ?>" class="btn btn-warning btn-sm" style="background: #d83838; border: none; color: white">
                                                <i class="bi bi-trash"></i> Rechazar
                                            </a>

                                            <?php } elseif ($pago['estado'] === 'fallido' || $pago['estado'] === 'completado') { ?>
                                                <span class="text-muted">No disponible</span>
                                            <?php } ?>
                                            </td>
                                            <td class="text-center" style="width: 50px">
                                                <?php if (!empty($pago['imagen']) && $pago['estado'] !== 'rechazado'): ?>
                                                    <a href="/restaurante_Cevicheria/uploads-comprobantes/<?php echo htmlspecialchars($pago['imagen']); ?>" target="_blank" class="btn btn-info btn-sm" style="background: #031b34; color: white; border: none;">
                                                        Ver
                                                </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-white">
                <h2 class="text-center mb-0 text-primary">
                    <i class="fas fa-calendar-check me-2"></i>Gestión de Reservas
                </h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover align-middle mb-0 table-fixed">
                        <thead>
                            <tr style="width: 400px">
                                <th style="width: 45px" class="text-center">Id</th>
                                <th style="width: 150px" class="text-center">Cliente</th>
                                <th style="width: 80px" class="text-center">Mesa N°</th>
                                <th class="text-center" style="width: 100px"></i>Personas</th>
                                <th class="text-center" style="width: 190px">Descripción</th>
                                <th class="text-center" style="width: 130px">Telefono</th>
                                <th class="text-center" style="width: 100px">Turno</th>
                                <th class="text-center" style="width: 100px">Hora reserva</th>
                                <th class="text-center" style="width: 180px">Fecha Reserva</th>
                                <th class="text-center" style="width: 100px">Fecha Registro</th>
                                <th class="text-center" style="width: 100px">Estado</th>
                                <th class="text-center" style="width: 100px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($reservas as $reserva): ?>
                                    <tr id="reserva-<?php echo $reserva['id']; ?>">
                                        <td style="width: 45px" class="text-center"><?php echo $reserva['id']; ?></td>
                                        <td style="width: 150px" class="text-center"><?php echo $reserva['nombre']; ?></td>
                                        <td style="width: 80px" class="text-center"><?php echo $reserva['numero_mesa']; ?></td>
                                        <td class="text-center" style="width: 100px"><?php echo $reserva['cantidad_personas']; ?></td>
                                        <td style="width: 190px" class="text-center"><?php echo $reserva['descripcion']; ?></td>
                                        <td style="width: 130px" class="text-center"><?php echo $reserva['telefono']; ?></td>
                                        <td style="width: 100px" class="text-center"><?php echo $reserva['turno']; ?></td>
                                        <td style="width: 100px" class="text-center"><?php echo $reserva['hora_reserva']; ?></td>
                                        <td class="text-center" style="width: 180px"><?php echo $reserva['fecha_reservacion']; ?></td>
                                        <td class="text-center" style="width: 100px"><?php echo $reserva['fecha_reserva']; ?></td>
                                        <td class="text-center estado-reserva" style="width: 100px; color:
                                            <?php
                                            switch (strtolower($reserva['estado'])) {
                                                case 'pendiente.':
                                                    echo 'red';
                                                    break;
                                                case 'en proceso':
                                                    echo 'blue';
                                                    break;
                                                case 'resuelto':
                                                    echo 'green';
                                                    break;
                                                case 'cancelado':
                                                    echo 'red';
                                                    break;
                                            }
                                            ?>">
                                            <?php echo htmlspecialchars($reserva['estado']); ?>
                                        </td>

                                        <td class="text-center acciones-reserva" style="width: 100px">
                                            <?php if ($reserva['estado'] === 'Pendiente'): ?>
                                                <!-- Botón para aceptar -->
                                                <button class="btn btn-primary btn-sm btn-aceptar" 
                                                    data-reserva-id="<?php echo $reserva['id']; ?>">
                                                    Aceptar
                                                </button>
                                            <?php elseif ($reserva['estado'] === 'En proceso'): ?>
                                                <!-- Botón para liberar -->
                                                <button class="btn btn-success btn-sm btn-liberar" 
                                                    data-reserva-id="<?php echo $reserva['id']; ?>">
                                                    Liberar
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted">No disponible</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-ver-imagen');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const imageUrl = this.getAttribute('data-imagen');
                    const modalImage = document.getElementById('imagenComprobante');
                    modalImage.src = imageUrl;
                    $('#imagenModal').modal('show');
                });
            });
        });
    </script>
    <script src="script.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>

</body>

</html>