<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $mostrarModal = true;
} else {
    $mostrarModal = false;
}

require_once '../../database/conexion.php';
$con = new Conexion();

$nombre = '';
if (isset($_SESSION['user_id'])) {
    $nombre = $con->getNombreByUserId($_SESSION['user_id']);
}

$total_mesas = 40;
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Reserva de Mesas</title>
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="loaderPagina" class="section_loader">
                <div class="loader">
                    <div class="loader_1"></div>
                    <div class="loader_2"></div>
            </div>
        </div>

    <div class="navbar-container">
        <a 
        style="padding-left: 20px;"
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
                            <p><a href="/restaurante_Cevicheria/profile.php#profile-personal"><i class="fas fa-user-circle"></i> Mi perfil</a></p>
                            <p><a href="/restaurante_Cevicheria/controller/logout-user.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></p>
                        <?php else : ?>
                            <p><a href="/restaurante_Cevicheria/Principal_usuario/Login/index.php"><i class="fas fa-sign-in-alt"></i> Inicia sesión</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </ul>
        </nav>
    </div>

</head>
<body>

<?php if ($mostrarModal): ?>
    <div class="modal-backdrop-sesion" id="modalSesionBackdrop">
        <div class="modal-content-sesion">
            <h2>¡Inicia sesión!</h2>
            <p>Debes iniciar sesión para hacer una reserva.</p>
            <button class="modal-btn-sesion" onclick="redireccionarLogin()">Iniciar sesión</button>
        </div>
    </div>
<?php endif; ?>


    <div class="container my-5">
        <h2 class="titel">Reserva tu Mesa aa</h2>
        
        <div class="row g-4">
            <?php for($i = 1; $i <= $total_mesas; $i++) { 
              $estado = isset($mesas[$i]) ? $mesas[$i] : 'Disponible';    
            ?>
                
            <div class="col-md-3">
                <div class="card mesa-card" onclick="abrirModalReserva(<?php echo $i; ?>)">
                    <img src="/restaurante_Cevicheria/Images/mesa.png" class="card-img-top mesa-imagen" alt="Mesa <?php echo $i; ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title">Mesa <?php echo $i; ?></h5>
                        <p class="card-text"><?php echo $estado == 'ocupada' ? 'Ocupada' : 'Disponible'; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>


    <div class="modal fade" id="reservaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Realizar Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="reservaForm">
                        <input type="hidden" id="numeroMesa" name="numeroMesa">
                        <div class="mb-3">
                            <label for="cantidadPersonas" class="form-label">Cantidad de Personas</label>
                            <input type="number" class="form-control" id="cantidadPersonas" name="cantidadPersonas" min="1" max="10" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción/Notas</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="realizarReserva()">Confirmar Reserva</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($mostrarModal): ?>
            const modalSesionBackdrop = document.getElementById('modalSesionBackdrop');
            modalSesionBackdrop.style.display = 'flex';
        <?php endif; ?>
    });

    function redireccionarLogin() {
        window.location.href = '/restaurante_Cevicheria/Principal_usuario/Login/index.php';
    }

    function actualizarEstadoMesas() {
        console.log('Actualizando estado de las mesas...');
        fetch('/restaurante_Cevicheria/controller/obtener_estado_mesas.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(mesa => {
                    const elementoMesa = document.querySelector(`.mesa-card[onclick="abrirModalReserva(${mesa.numero_mesa})"]`);
                    if (elementoMesa) {
                        const estadoTexto = elementoMesa.querySelector('.card-text');
                        estadoTexto.textContent = (mesa.estado === 'Pendiente' || mesa.estado === 'En proceso') ? 'Ocupada' : 'Disponible';
                    }
                });
            })
            .catch(error => console.error('Error al obtener el estado de las mesas:', error));
    };
    actualizarEstadoMesas();

    setInterval(actualizarEstadoMesas, 5000);
</script>
<script src="/restaurante_Cevicheria/js/drop.js"></script>
<script src="/restaurante_Cevicheria/js/loader.js"></script>
<script src="script.js"></script>
</body>
</html>