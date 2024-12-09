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
                    <p>Debes Registrarte e Iniciar sesion para realizar una reserva!.</p>
                    <button class="modal-btn-sesion" onclick="redireccionarLogin()">Iniciar sesión</button>
                </div>
            </div>
        <?php endif; ?>


        <div class="container my-5">
            <h2 class="titel">Reserva tu Mesa</h2>

            <div class="row g-4">
                <?php for ($i = 1; $i <= $total_mesas; $i++) {
                    $estado = isset($mesas[$i]) ? $mesas[$i] : 'Disponible';
                ?>
                    <div class="col-md-3">
                        <div class="card mesa-card"
                            data-numero-mesa="<?php echo $i; ?>"
                            onclick="abrirModalReserva(<?php echo $i; ?>); seleccionarMesaParaReservasGrandes(<?php echo $i; ?>);">
                            <img src="/restaurante_Cevicheria/Images/mesa.png"
                                class="card-img-top mesa-imagen"
                                alt="Mesa <?php echo $i; ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title">Mesa <?php echo $i; ?></h5>
                                <p class="card-text">
                                    <?php echo $estado == 'ocupada' ? 'Ocupada' : 'Disponible'; ?>
                                </p>
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
                                <label for="cantidadPersonas" class="form-label is-required">Cantidad de Personas</label>
                                <select class="form-select" id="cantidadPersonas" name="cantidadPersonas" title="Seleccione un numero de personas maximo 10" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label is-required">Descripción/Notas</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" title="Ingrese una descripción o nota (opcional)" placeholder="Ingrese una descripcion acerca de su reservacion (opcional)"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label is-required">Telefono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9" title="Ingrese un telefono de contacto" required>
                            </div>

                            <div class="mb-3">
                                <label for="turno" class="form-label is-required">Turno</label>
                                <select class="form-select turno" id="turno" name="turno" required title="Seleccione un turno">
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="Mañana">Mañana/10:00-11:59</option>
                                    <option value="Tarde">Tarde/12:00-18:00</option>
                                    <option value="Noche">Noche/18:01-22:00</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="hora" class="form-label hora is-required">Hora de reserva</label>
                                <input type="time" class="form-control hora" id="hora" name="hora" min="10:00" max="23:00" title="Ingrese una hora de reserva" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_reserva" class="fecha is-required">Fecha de Reserva</label>
                                <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" title="Seleccione una fecha de su reserva" required>
                            </div>

                            <style>
                                abel.fecha_reserva.fecha {
                                    position: absolute;
                                    top: 67%;
                                    left: 51%;
                                }

                                label.form-label.hora {
                                    position: absolute;
                                    top: 58%;
                                    left: 51%;
                                }

                                input#hora {
                                    width: 46%;
                                    position: absolute;
                                    top: 63%;
                                    left: 50%;
                                    height: 36px;
                                }
                            </style>

                            <div class="mb-3">
                                <div class="custom-button">
                                    <a id="botonReservasGrandes">
                                        <span>Para reservas o eventos de más de 15 personas, pulse aquí</span>
                                    </a>
                                </div>
                            </div>


                            <script>
                                function seleccionarMesaParaReservasGrandes(numeroMesa) {
                                    const boton = document.getElementById('botonReservasGrandes');
                                    if (boton) {
                                        boton.href = `/restaurante_Cevicheria/Principal_usuario/reservas/plus_person.php?numeroMesa=${numeroMesa}`;
                                    }
                                }
                            </script>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="realizarReserva()">Confirmar Reserva</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para mensajes -->
        <div id="mensajeModal" class="modal fade" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="margin-left: 5%;; margin-top: -25%; background-color: #f6f6f6;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mensajeModalLabel">Mensaje</h5>
                    </div>
                    <div class="modal-body" id="modalMensajeBody">
                        <!-- El mensaje dinámico -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

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
                            const elementoMesa = document.querySelector(`.mesa-card[data-numero-mesa="${mesa.numero_mesa}"]`);
                            if (elementoMesa) {
                                const estadoTexto = elementoMesa.querySelector('.card-text');
                                estadoTexto.textContent = (mesa.estado === 'En tramite' || mesa.estado === 'Pendiente' || mesa.estado === 'En proceso') ? 'Ocupada' : 'Disponible';

                                // Cambiar las clases según el estado
                                if (mesa.estado === 'En tramite' || mesa.estado === 'Pendiente' || mesa.estado === 'En proceso') {
                                    elementoMesa.classList.add('ocupada');
                                    elementoMesa.classList.remove('disponible');
                                    elementoMesa.style.pointerEvents = 'none'; // Deshabilitar el clic en mesas ocupadas
                                } else {
                                    elementoMesa.classList.add('disponible');
                                    elementoMesa.classList.remove('ocupada');
                                    elementoMesa.style.pointerEvents = 'auto'; // Habilitar el clic en mesas disponibles
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error al obtener el estado de las mesas:', error));
            }


            actualizarEstadoMesas();

            setInterval(actualizarEstadoMesas, 5000);
        </script>
        <script src="/restaurante_Cevicheria/js/drop.js"></script>
        <script src="/restaurante_Cevicheria/js/loader.js"></script>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>