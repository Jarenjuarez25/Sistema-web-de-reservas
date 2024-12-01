<?php
session_start();
require_once '../../database/conexion.php';

$con = new Conexion();

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
                
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <label for="telefono">Teléfono</label>
                        <div class="col-md-6 form-group">
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="cantidad_personas">Número de Personas</label>
                            <select type="number" class="form-control" id="cantidad_personas" name="cantidad_personas" min="10" required>
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
                            <small class="form-text text-muted">Mínimo 10 personas</small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="fecha_reserva">Fecha de Reserva</label>
                            <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="hora_reserva">Hora de Reserva</label>
                            <input type="time" class="form-control" id="hora_reserva" name="hora_reserva" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="turno">Turno</label>
                            <select class="form-control" id="turno" name="turno" required>
                                <option value="">Seleccione un turno</option>
                                <option value="Mañana">Mañana</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noche">Noche</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción Adicional</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Información adicional sobre su grupo o reserva (opcional)"></textarea>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check me-2"></i>Solicitar Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Optional: Add client-side validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const personasInput = document.getElementById('cantidad_personas');
            
            form.addEventListener('submit', function(event) {
                if (personasInput.value < 16) {
                    event.preventDefault();
                    alert('Para grupos mayores a 15 personas, use este formulario especial.');
                }
            });
        });
    </script>
</body>
</html>
