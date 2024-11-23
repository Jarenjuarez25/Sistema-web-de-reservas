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
                            <!-- If the user is logged in, show options -->
                            <p><a href="/restaurante_Cevicheria/controller/logout-user.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </ul>
        </nav>
    </div>

    <div class="container">
        <div class="profile-card">
            <div class="row" style="display: flex;">
                <div class="sidebar" style="flex: 0 0 250px;">
                    <a href="#" class="nav-link active" data-target="profile-personal">
                        <i class="fas fa-user-circle mr-2"></i> Mi perfil
                    </a>
                    <a href="#" class="nav-link" data-target="profile-reclamos">
                        <i class="fas fa-clipboard-list mr-2"></i> Mis reclamos
                    </a>
                </div>

                <div class="content-area" style="flex: 1;">
                    <!-- Datos Personales Tab -->
                    <div id="profile-personal" class="tab-content active">
                        <h2>Datos personales</h2>

                        <form>
                            <div class="form-group">
                                <label>Nombres:</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" readonly>
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

                    <!-- Reclamos Tab -->
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
                                                default:
                                                    echo 'black';
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

                </div>
            </div>
        </div>
    </div>
    <script src="/restaurante_Cevicheria/js/drop.js"></script>
    <script src="/restaurante_Cevicheria/js/profile.js"></script>
</body>

</html>