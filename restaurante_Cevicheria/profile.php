<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<?php

require('database/conexion.php');

$con = new Conexion();

if (!isset($_SESSION['user_id'])) {
    $nombre = $con->getNombreByUserId($_SESSION['user_id']);
    exit();
}

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

$correo = $con->getUserDetails($user_id);
$persona = $con->getPersonaByUserId($user_id);
$usuario = $con->getNombreByUserId($user_id);
$reclamos = $con->getReclamosByUserId($user_id);
$reservas = $con->getReservasByUserId($user_id);
$pagos = $con->getPagosByUserId($user_id);
$totalGeneral = 0; // Inicializa el total general
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RestCevicheria Luigy's</title>
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico" />
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/profile-style.css" />
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="navbar-container">
        <a
            style="    padding-left: 20px;"
            href="/restaurante_Cevicheria/index.php"><img src="/restaurante_Cevicheria/Images/Logo.png" class="logo"></a>
        <nav class="navbar">
            <ul>
                <li><a href="/restaurante_Cevicheria/index.php">INICIO</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/menu/index.php">MENÚ</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/nosotros/index.php">NOSOTROS</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/reservas/index.php">RESERVAS</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/ubicacion/index.php">UBICACION</a></li>


                <?php if (isset($_SESSION['user_cargo_id']) && $_SESSION['user_cargo_id'] == 1) : ?>
                    <li>
                        <a href="/restaurante_Cevicheria/Principal_admin/index.php">ADMIN</a>
                    </li>
                <?php endif; ?>

                <li style="text-transform: uppercase;">
                    <a href="">
                        <?php if (isset($_SESSION['user_nombre'])) : ?>
                            <span class="usuario-nombre"><?php echo $_SESSION['user_nombre']; ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <div class="sm-usuario">
                    <a href="#" class="usuario-toggle">
                        <img src="/restaurante_Cevicheria/Images/usuario.png" class="usuario-img">
                    </a>

                    <div class="usuario-dropdown">
                        <?php if (isset($_SESSION['user_nombre'])) : ?>
                            <p><a href="/restaurante_Cevicheria/controller/logout-user.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </ul>
        </nav>
    </div>
    <?php
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        $tipo_mensaje = $_SESSION['tipo_mensaje'];

        // Default icons based on message type
        $icon = ($tipo_mensaje == 'exito')
            ? '<i class="bi bi-check-circle-fill"></i>'
            : '<i class="bi bi-exclamation-triangle-fill"></i>';

        echo "<div class='mensaje $tipo_mensaje'>$icon<span>$mensaje</span></div>";
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
    }

    // Error messages
    if (isset($_SESSION['errors'])) {
        echo "<div class='mensaje error'>";
        echo '<i class="bi bi-x-circle-fill"></i>';
        echo "<span>" . implode(', ', $_SESSION['errors']) . "</span>";
        echo "</div>";
        unset($_SESSION['errors']);
    }

    ?>
    <div class="container">
        <div class="profile-card">
            <div class="row" style="display: flex;">
                <div class="sidebar" style="flex: 0 0 250px;">

                    <a href="#" class="nav-link active" data-target="profile-personal">
                        <i class="fas fa-user-circle mr-2"></i> Mi perfil
                    </a>

                    <a href="#" class="nav-link" data-target="profile-config">
                        <i class="fas fa-cogs mr-2"></i> Configuraciones
                    </a>

                    <a href="#" class="nav-link" data-target="profile-reclamos">
                        <i class="fas fa-exclamation-circle mr-2"></i> Mis reclamos
                    </a>

                    <a href="#" class="nav-link" data-target="profile-reservas1">
                        <i class="fas fa-calendar-alt mr-2"></i> Mis reservas
                    </a>

                    <a href="#" class="nav-link" data-target="profile-reservas">
                        <i class="fas fa-credit-card mr-2"></i> Pagos
                    </a>

                    <a href="#" class="nav-link" data-target="profile-Pagos">
                        <i class="fas fa-wallet mr-2"></i> Mis Pagos
                    </a>


                </div>

                <div class="content-area" style="flex: 1;">
                    <div id="profile-personal" class="tab-content active">
                        <h2>Datos personales</h2>
                        <form method="post" action="/restaurante_Cevicheria/controller/edit-profile.php">
                            <div class="form-group">
                                <label>Nombres:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" name='nombre' id="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Apellidos:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" class="form-control" id="apellido_p"
                                        name="apellido_p"
                                        value="<?php echo htmlspecialchars($persona['apellidos']); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Dni:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="tel" class="form-control" id="dni" name="dni"
                                        value="<?php echo htmlspecialchars($persona['dni']); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Fecha Nacimiento:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="date" class="form-control" id="telefono" name="telefono"
                                        value="<?php echo htmlspecialchars($persona['fechaNacimiento']); ?>">
                                </div>
                            </div>
                            <button class="boton2" id="updateButton1"><i class="bi bi-pencil-square"></i> Actualizar</button>

                        </form>
                    </div>

                    <!--Config-->
                    <div id="profile-config" class="tab-content">
                        <h2>Configuración de cuenta</h2>
                        <form method="POST" action="/restaurante_Cevicheria/controller/edit-email-config.php">
                            <div class="form-group">
                                <label for="correo">Correo:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="email" name='correo' id="correo" class="form-control" 
                                    value="<?php echo htmlspecialchars($correo['correo']); ?>" readonly>
                                    <span class="edit-icon" data-target="correo"><i class="fas fa-edit"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="boton2" id="updateConfEmailButton" disable> <i class="bi bi-pencil-square"></i>Actualizar</button>
                        </form>

                        <form method="POST" action="/restaurante_Cevicheria/controller/edit-pass-config.php">
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <div class="d-flex align-items-center">
                                    <input type="password" class="form-control" value="******************" id="password"
                                        readonly>
                                    <span class="edit-icon" data-target="password"><i class="fas fa-edit"></i></span>
                                </div>
                            </div>

                            <div id="password-fields" style="display:none;">
                                <div class="form-group">
                                    <label for="current_password">Contraseña Actual:</label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required>
                                        <span class="password-toggle" id="current_password-toggle"
                                            onclick="togglePasswordVisibility('current_password')">
                                            <i id="current_password-toggle-icon" class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="new_password">Nueva Contraseña:</label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                        <span class="password-toggle" id="new_password-toggle"
                                            onclick="togglePasswordVisibility('new_password')">
                                            <i id="new_password-toggle-icon" class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" required>
                                        <span class="password-toggle" id="confirm_password-toggle"
                                            onclick="togglePasswordVisibility('confirm_password')">
                                            <i id="confirm_password-toggle-icon" class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="boton2" id="updateConfPassButton"
                                disable><i class="bi bi-pencil-square"></i>Actualizar</button>
                        </form>
                    </div>

                    <!-- Reclamos -->

                    <div id="profile-reclamos" class="tab-content">
                        <h2>Mis reclamos</h2>
                        <div class="table-container" style="max-height: 400px; overflow-y: auto; position: relative;"></div>
                        <table class="table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Asunto</th>
                                    <th>Mensaje</th>
                                    <th>Estado</th>
                                    <?php if (!empty($reclamos) && isset($reclamos[0]['respuesta'])): ?>
                                        <th>Respuesta</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reclamos as $reclamo): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($reclamo['fecha_reclamo']); ?></td>
                                        <td><?php echo htmlspecialchars($reclamo['asunto']); ?></td>
                                        <td><?php echo htmlspecialchars($reclamo['descripcion']); ?></td>
                                        <td style="color: 
                                            <?php
                                            switch (strtolower($reclamo['estado'])) {
                                                case 'pendiente':
                                                    echo 'red';
                                                    break;
                                                case 'en proceso':
                                                    echo 'blue';
                                                    break;
                                                case 'resuelto':
                                                    echo 'green';
                                                    break;
                                            }
                                            ?>">
                                            <?php echo htmlspecialchars($reclamo['estado']); ?>
                                            <?php if (isset($reclamo['respuesta']) && $reclamo['respuesta'] !== null): ?>
                                        <td><?php echo htmlspecialchars($reclamo['respuesta']); ?></td>
                                    <?php endif; ?> </td>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!--Reservas unicamente-->
                    <div id="profile-reservas1" class="tab-content">
                        <h2 class="si">Mis reservas</h2>
                        <div class="table-container" style="max-height: 400px; overflow-y: auto; position: relative;">
                            <table class="table" style="width: 100%; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                                    <tr>
                                        <th>Numero de mesa</th>
                                        <th>Cantidad de personas</th>
                                        <th>Descripcion</th>
                                        <th>Telefono</th>
                                        <th>Fecha</th>
                                        <th>Turno</th>
                                        <th>Hora</th>
                                        <th>Pago</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservas as $reserva): ?>
                                        <tr data-id="<?php echo htmlspecialchars($reserva['id']); ?>">
                                            <td><?php echo htmlspecialchars($reserva['numero_mesa']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['cantidad_personas']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['descripcion']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['telefono']); ?></td>
                                            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($reserva['fecha_reserva']))); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['turno']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['hora_reserva']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['pago']); ?></td>
                                            <td style="color: 
                                            <?php
                                            switch (strtolower($reserva['estado'])) {
                                                case 'pendiente':
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
                                            }
                                            ?>">
                                                <?php echo htmlspecialchars($reserva['estado']); ?>
                                            </td>
                                            <td>
                                                <a href="/restaurante_Cevicheria/edit_reserva.php?id=<?php echo ($reserva['id']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Editar</a><br>
                                                <a href="/restaurante_Cevicheria/controller/cancelar_reserva.php?id=<?php echo ($reserva['id']); ?>"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Cancelar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagos -->
                    <div id="profile-reservas" class="tab-content">
                        <h2>Pagos</h2>
                        <div class="table-container" style="max-height: 400px; overflow-y: auto; position: relative;">
                            <table class="table" style="width: 100%; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                                    <tr>
                                        <th>Numero de mesa</th>
                                        <th>Cantidad de personas</th>
                                        <th>Descripcion</th>
                                        <th>Fecha reserva</th>
                                        <th>Turno</th>
                                        <th>Hora</th>
                                        <th>Pago</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalGeneral = 0;
                                    foreach ($reservas as $reserva):
                                        $totalGeneral += (float)$reserva['pago'];
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($reserva['numero_mesa']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['cantidad_personas']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['descripcion']); ?></td>
                                            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($reserva['fecha_reserva']))); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['turno']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['hora_reserva']); ?></td>
                                            <td>S/ <?php echo number_format($reserva['pago'], 2); ?></td>
                                            <td style="color: 
                        <?php
                                        switch (strtolower($reserva['estado'])) {
                                            case 'pendiente':
                                                echo 'red';
                                                break;
                                            case 'en proceso':
                                                echo 'blue';
                                                break;
                                            case 'resuelto':
                                                echo 'green';
                                                break;
                                        }
                        ?>">
                                                <?php echo htmlspecialchars($reserva['estado']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-right font-weight-bold">Total a pagar:</td>
                                        <td colspan="2" class="font-weight-bold">S/ <?php echo number_format($totalGeneral, 2); ?> PEN</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-center mt-4">
                            <form id="confirmar-pago-form" action="/restaurante_Cevicheria/controller/confirmar_pago.php" method="POST" style="display: none;" enctype="multipart/form-data">
                                <div class="form-group">
                                    <p>Selecciona un método de pago:</p>
                                    <div class="form-check">
                                        <label class="form-check-label" for="opcion1">
                                            <br>Yape
                                            <img src="/restaurante_Cevicheria/Images/yape.jpg" alt="Opción 1" class="opcion-imagen" style="display: none;">
                                        </label>
                                        <input class="form-check-input" type="radio" value="Yape" id="opcion1" name="opcion" required>
                                    </div>

                                    <div class="form-check" style="margin-top: -86px; margin-left: 50%;">
                                        <label class="form-check-label" for="opcion2">
                                            <br>Plin
                                            <img src="/restaurante_Cevicheria/Images/yape.jpg" alt="Opción 2" class="opcion-imagen" style="display: none;">
                                        </label>
                                        <input class="form-check-input" type="radio" value="Plin" id="opcion2" name="opcion" required>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label" for="opcion3">
                                            <br>Deposito a cuenta
                                        </label>
                                        <input class="form-check-input" type="radio" value="Cuenta Bancaria" id="opcion3" name="opcion" required><br>
                                        <p alt="Opción 3" class="opcion-imagen" style="display: none;">Bcp:<br> N° de cuenta: 53595951438062 <br> Lesly Tatiana Oliva Huaman</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="numero_operacion">Número de Operación:</label>
                                    <input type="text" class="form-control" id="numero_operacion" name="numero_operacion" placeholder="Ingrese el número de operación" maxlength="8" required>
                                </div>

                                <div>
                                    <!--cap de pago-->
                                    <label for="imagen">Subir imagen de comprobante:</label>
                                    <input type="file" id="imagen" name="imagen" class="form-control-file" accept="image/*" required>
                                </div>

                                <input type="hidden" name="monto_total" value="<?php echo number_format($totalGeneral, 2); ?>">
                                <button type="submit" class="boton2" name="confirmar_pago"><i class="bi bi-check-circle"></i>Confirmar pago</button>
                            </form>
                            <button id="mostrar-form-pago" class="btn btn-primary"><i class="bi bi-check-circle"></i>Confirmar</button>
                        </div>
                    </div>


                    <!-- pago -->
                    <div id="profile-Pagos" class="tab-content">
                        <h2>Mis Pagos</h2>
                        <div class="table-container" style="max-height: 400px; overflow-y: auto; position: relative;">

                            <table class="table" style="width: 100%; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                                    <tr>
                                        <th>Id pago</th>
                                        <th>Fecha y hora pago</th>
                                        <th>Numero de operacion</th>
                                        <th>Metodo Pago</th>
                                        <th>Monto total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pagos as $pago): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($pago['id']); ?></td>
                                            <td><?php echo htmlspecialchars($pago['fecha_pago']); ?></td>
                                            <td><?php echo htmlspecialchars($pago['n_operacion']); ?></td>
                                            <td><?php echo htmlspecialchars($pago['metodo_pago']); ?></td>
                                            <td><?php echo htmlspecialchars($pago['monto_total']); ?></td>
                                            <td style="color: 
                                            <?php
                                            switch (strtolower($pago['estado'])) {
                                                case 'completado':
                                                    echo 'green';
                                                    break;
                                                case 'pendiente':
                                                    echo 'red';
                                                    break;
                                                case 'fallido':
                                                    echo 'red';
                                                    break;
                                            }
                                            ?>">
                                                <?php echo htmlspecialchars($pago['estado']); ?>


                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="/restaurante_Cevicheria/js/drop.js"></script>
    <script src="/restaurante_Cevicheria/js/profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Selecciona la tabla de reservas en la sección de pagos
            const paymentTable = document.querySelector("#profile-reservas .table tbody");
            const mostrarFormPagoButton = document.getElementById("mostrar-form-pago");

            function updatePaymentButtonVisibility() {
                const tableRows = paymentTable.querySelectorAll("tr");

                if (tableRows.length === 0) {
                    // Oculta el botón de confirmación si no hay filas
                    mostrarFormPagoButton.style.display = "none";
                } else {
                    // Muestra el botón de confirmación
                    mostrarFormPagoButton.style.display = "block";
                }
            }

            // Verifica la visibilidad del botón cuando se carga la página
            updatePaymentButtonVisibility();

            // Observa cambios en la tabla (por si se eliminan reservas dinámicamente)
            const observer = new MutationObserver(updatePaymentButtonVisibility);
            observer.observe(paymentTable, {
                childList: true
            });
        });
    </script>
</body>

</html>