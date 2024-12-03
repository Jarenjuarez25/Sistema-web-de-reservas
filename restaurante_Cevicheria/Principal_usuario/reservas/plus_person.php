<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../database/conexion.php';
$con = new Conexion();

$numeroMesa = isset($_GET['numeroMesa']) && !empty($_GET['numeroMesa']) ? $_GET['numeroMesa'] : null;

//var_dump($numeroMesa);

if (isset($_SESSION['user_id'])) {
    $nombre = $con->getNombreByUserId($_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva para Grupos Grandes - RestCevicheria Luigy's</title>
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/sstyle-plus.css" />
    <style>
        body {
            background-color: #f4f6f9;
        }
        .reservation-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 reservation-container">
                <h2 class="text-center mb-4 text-primary">
                    <i class="fas fa-users me-2"></i>Reserva para Grupos Grandes
                </h2>
                
                <?php if(isset($mensaje)): ?>
                    <div class="alert alert-<?php echo $mensaje_tipo; ?>" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>
                
                <form id="reservaForm">
                <input type="hidden" id="numeroMesa" name="numeroMesa" value="<?php echo htmlspecialchars($numeroMesa); ?>">
                    
                    <div class="row">
                        <label for="telefono">Teléfono</label>
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="cantidadPersonas">Número de Personas</label>
                            <select class="form-control" id="cantidadPersonas" name="cantidadPersonas" required>
                                <option value="">Seleccione una cantidad</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                            </select>
                            <small class="form-text text-muted" min="20">Mínimo 20 personas</small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="fecha_reserva">Fecha de Reserva</label>
                            <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="turno">Turno</label>
                            <select class="form-select" id="turno" name="turno" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="Mañana">Mañana/10:00-11:59</option>
                                <option value="Tarde">Tarde/12:00-18:00</option>
                                <option value="Noche">Noche/18:01-22:00</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="hora_reserva">Hora de Reserva</label>
                        <input type="time" class="form-control" id="hora" name="hora" min="10:00" max="23:00" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Información adicional sobre su grupo o reserva (opcional)"></textarea>
                    </div>


                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.href='/restaurante_Cevicheria/Principal_usuario/reservas/index.php';">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="realizarReserva()">Confirmar Reserva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal para mensajes -->
    <div id="mensajeModal" class="modal fade" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"  style="margin-left: 10%; margin-top: -25%; background-color: #f6f6f6;">
                <div class="modal-header">
                    <h5 class="modal-title" id="mensajeModalLabel">Mensaje</h5>
                </div>
                <div class="modal-body" id="modalMensajeBody">
                    <!-- El mensaje dinámico -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function realizarReserva() {
            const formulario = document.getElementById('reservaForm');
            if (!formulario.checkValidity()) {
                alert('Por favor, completa todos los campos correctamente.');
                return;
            }

            // Aquí puedes agregar la lógica para enviar el formulario
            formulario.submit(); // O usar AJAX si prefieres no recargar la página
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

                    // Cambiar las clases según el estado
                    if (mesa.estado === 'Pendiente' || mesa.estado === 'En proceso') {
                        elementoMesa.classList.add('ocupada');
                        elementoMesa.classList.remove('disponible');
                    } else {
                        elementoMesa.classList.add('disponible');
                        elementoMesa.classList.remove('ocupada');
                    }
                }
            });
        })
        .catch(error => console.error('Error al obtener el estado de las mesas:', error));
}

    actualizarEstadoMesas();

    setInterval(actualizarEstadoMesas, 5000);

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/restaurante_Cevicheria/Principal_usuario/reservas/script.js"></script>
</body>
</html>
