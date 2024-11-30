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
}

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

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

    <div class="container">
        <?php
            if (isset($_SESSION['mensaje'])) {
                $mensaje = $_SESSION['mensaje'];
                $tipo_mensaje = $_SESSION['tipo_mensaje'];
                echo "<div class='mensaje $tipo_mensaje'>$mensaje</div>";
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo_mensaje']);
            }
        ?>
        <div class="profile-card">
            <div class="row" style="display: flex;">
                <div class="sidebar" style="flex: 0 0 250px;">
                    <a href="#" class="nav-link active" data-target="profile-personal">
                        <i class="fas fa-user-circle mr-2"></i> Mi perfil
                    </a>
                    <a href="#" class="nav-link" data-target="profile-reclamos">
                        <i class="fas fa-clipboard-list mr-2"></i> Mis reclamos
                    </a>

                    <a href="#" class="nav-link" data-target="profile-reservas">
                        <i class="fas fa-clipboard-list mr-2"></i> Mis reservas
                    </a>

                    <a href="#" class="nav-link" data-target="profile-Pagos">
                        <i class="fas fa-clipboard-list mr-2"></i> Mis Pagos
                    </a>



                </div>

                <div class="content-area" style="flex: 1;">
                    <!-- Datos Personales -->
                    <div id="profile-personal" class="tab-content active">
                        <h2>Datos personales</h2>

                        <form>
                            <div class="form-group">
                                <label>Nombres:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" name='nombre' class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" readonly>
                                    <span class="edit-icon">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Apellidos:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" class="form-control" id="apellido_p"
                                        name="apellido_p"
                                        value="<?php echo htmlspecialchars($persona['apellidos']); ?>" readonly>
                                    <span class="edit-icon">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Dni:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="tel" class="form-control" id="dni" name="dni"
                                        value="<?php echo htmlspecialchars($persona['dni']); ?>" readonly>
                                    <span class="edit-icon">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Fecha Nacimiento:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="tel" class="form-control" id="telefono" name="telefono"
                                        value="<?php echo htmlspecialchars($persona['fechaNacimiento']); ?>" readonly>
                                    <span class="edit-icon">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- Reclamos -->
                    <div id="profile-reclamos" class="tab-content">
                        <h2>Mis reclamos</h2>
                        <table class="table">
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

                    <!-- reservas -->
                     <div id="profile-reservas" class="tab-content">
                        <h2>Mis reservas</h2>
                     <div class="table-container" style="max-height: 400px; overflow-y: auto; position: relative;">
                        
                        <table class="table" style="width: 100%; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                                <tr>
                                        <th>Numero de mesa</th>
                                        <th>Cantidad de personas</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Fecha reserva</th>
                                        <th>Telefono</th>
                                        <th>Turno</th>
                                        <th>Hora de reserva</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pagos as $pago): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($pago['numero_mesa']); ?></td>
                                        <td><?php echo htmlspecialchars($pago['cantidad_personas']); ?></td>
                                        <td><?php echo htmlspecialchars($pago['descripcion']); ?></td>
                                        <td style="color: 
                                            <?php
                                            switch (strtolower($pago['estado'])) {
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
                                            <?php echo htmlspecialchars($pago['estado']); ?>
                                            <td><?php echo htmlspecialchars($pago['fecha_reserva']); ?></td>
                                            <td><?php echo htmlspecialchars($pago['telefono']); ?></td>
                                            <td><?php echo htmlspecialchars($pago['turno']); ?></td>
                                            <td><?php echo htmlspecialchars($pago['hora_reserva']); ?></td>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>



                    <!-- pago -->
                    <div id="profile-Pagos" class="tab-content">
                        <h2>Mis Pagos</h2>
                        <div class="table-container" style="max-height: 400px; overflow-y: auto; position: relative;">
                            <table class="table" style="width: 100%; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                                    <tr>
                                        <th>Numero de mesa</th>
                                        <th>Cantidad de personas</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Turno</th>
                                        <th>Hora de reserva</th>
                                        <th>Pago</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($reservas as $reserva): ?>
                                        <tr>

                                            <td><?php echo htmlspecialchars($reserva['numero_mesa']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['cantidad_personas']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['descripcion']); ?></td>
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
                                            <td><?php echo htmlspecialchars($reserva['fecha_reserva']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['turno']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['hora_reserva']); ?></td>
                                            <td><?php echo htmlspecialchars($reserva['pago']); ?></td>
                                        </tr>
                                        <?php
                                        $subtotal = $reserva['pago'] + $reserva['pago'];
                                        $totalGeneral += $subtotal;
                                        ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">Total a pagar:</td>
                                        <td id="total-general-confirmacion" class="font-weight-bold">S/ <?php echo number_format($totalGeneral, 2); ?> PEN</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                        
                        <div class="text-center mt-4">
                            <form id="confirmar-pago-form" action="/restaurante_Cevicheria/controller/confirmar_pago.php" method="POST" style="display: none;">
                                <div class="form-group">
                                    <p>Selecciona un método de pago:</p>
                                    <div class="form-check">


                                        <label class="form-check-label" for="opcion1">
                                            <br>Yape
                                            <img src="/restaurante_Cevicheria/Images/yape.jpg" alt="Opción 1" class="opcion-imagen" style="display: none;">
                                        </label>
                                        <input class="form-check-input" type="radio" value="Yape" id="opcion1" name="opcion" required>
                                    </div>

                                    <div class="form-check" style=" margin-top: -86px; margin-left: 50%;">

                                        <label class="form-check-label" for="opcion2">
                                            <br>Plin
                                            <img src="/restaurante_Cevicheria/Images/yape.jpg" alt="Opción 2" class="opcion-imagen" style="display: none;">
                                        </label>
                                        <input class="form-check-input" type="radio" value="Plin" id="opcion2" name="opcion" required>



                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="numero_operacion">Número de Operación:</label>
                                    <input type="text" class="form-control" id="numero_operacion" name="numero_operacion" placeholder="Ingrese el número de operación" maxlength="8" required>
                                </div>
                                <input type="hidden" name="monto_total" value="<?php echo $totalGeneral; ?>">
                                <button type="submit" class="btn btn-success" name="confirmar_pago">Confirmar pago</button>
                            </form>
                            <button id="mostrar-form-pago" class="btn btn-primary">Confirmar pago</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/restaurante_Cevicheria/js/drop.js"></script>
    <script src="/restaurante_Cevicheria/js/profile.js"></script>
    <style>
        .mt-5 {
            padding-top: 5px;
        }

        .confirmar-tit {
            padding-top: 10px;
        }

        .opcion-imagen {
            display: none;
            /* Imágenes ocultas por defecto */
            max-width: 300px;
            /* Tamaño máximo ajustable según necesidades */
            margin-top: 5px;
            /* Espacio entre la imagen y el texto */
        }
    </style>
</body>

</html>