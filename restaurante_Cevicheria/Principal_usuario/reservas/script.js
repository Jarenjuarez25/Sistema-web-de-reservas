function abrirModalReserva(numero_mesa) {
    const mesaCard = document.querySelector(`.mesa-card[onclick="abrirModalReserva(${numero_mesa})"]`);
    const estadoMesa = mesaCard.querySelector('.card-text').textContent;
    // Validar si la mesa está ocupada
    if (estadoMesa === 'Ocupada') {
        alert('Esta mesa ya está reservada. Seleccione otra disponible.');
        return; // Salir de la función si la mesa está ocupada
    }

    document.getElementById('numeroMesa').value = numero_mesa;
    const reservaModal = new bootstrap.Modal(document.getElementById('reservaModal'));
    reservaModal.show();
}

function realizarReserva() {
    // Validar formulario antes de enviar
    const form = document.getElementById('reservaForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);
    formData.append('user_id', '<?php echo $_SESSION["user_id"] ?? ""; ?>');

    fetch('/restaurante_Cevicheria/controller/procesar_reserva.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Modal para mensajes
        const mensajeModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
        const modalMensajeBody = document.getElementById('modalMensajeBody');

        if (data.success) {
            modalMensajeBody.textContent = 'Reserva realizada con éxito, ve a mis reservas en Mi Perfil y procede con el pago!';
            mensajeModal.show();
            
            document.getElementById('mensajeModal').addEventListener('hidden.bs.modal', () => {
                window.location.reload();
            });
        } else {
            modalMensajeBody.textContent = data.message || 'Error al realizar la reserva';
            mensajeModal.show();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const mensajeModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
        const modalMensajeBody = document.getElementById('modalMensajeBody');
        modalMensajeBody.textContent = 'Error al procesar la reserva';
        mensajeModal.show();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Resetea el formulario cuando el modal se cierre
    const reservaModal = document.getElementById('reservaModal');
    const reservaForm = document.getElementById('reservaForm');

    if (reservaModal && reservaForm) {
        reservaModal.addEventListener('hidden.bs.modal', function () {
            reservaForm.reset(); // Limpia todos los campos del formulario
        });
    }
});


//filtro de horario
document.addEventListener('DOMContentLoaded', function() {
    const turnoSelect = document.getElementById('turno');
    const horaInput = document.getElementById('hora');

    // Define time ranges for each turn
    const turnRanges = {
        'Mañana': { min: '10:00', max: '11:59' },
        'Tarde': { min: '12:00', max: '18:00' },
        'Noche': { min: '18:01', max: '23:00' }
    };

    // Function to validate and set time input constraints
    function actualizarRangoHora() {
        const turnoSeleccionado = turnoSelect.value;
        
        if (turnoSeleccionado && turnRanges[turnoSeleccionado]) {
            const { min, max } = turnRanges[turnoSeleccionado];
            
            // Set min and max attributes
            horaInput.min = min;
            horaInput.max = max;

            // Clear previous input if it's outside the new range
            const horaActual = horaInput.value;
            if (horaActual) {
                const [horas, minutos] = horaActual.split(':').map(Number);
                const horaSeleccionada = horas * 60 + minutos;
                const [minHoras, minMinutos] = min.split(':').map(Number);
                const [maxHoras, maxMinutos] = max.split(':').map(Number);
                const minTime = minHoras * 60 + minMinutos;
                const maxTime = maxHoras * 60 + maxMinutos;

                if (horaSeleccionada < minTime || horaSeleccionada > maxTime) {
                    horaInput.value = ''; // Clear input if outside range
                }
            }
        } else {
            // Reset min and max if no turn is selected
            horaInput.min = '10:00';
            horaInput.max = '23:00';
        }
    }

    // Add event listener to turno select
    turnoSelect.addEventListener('change', actualizarRangoHora);

    // Initial validation on page load
    actualizarRangoHora();

    // Validation on hora input
    horaInput.addEventListener('input', function() {
        const turnoSeleccionado = turnoSelect.value;
        
        if (turnoSeleccionado && turnRanges[turnoSeleccionado]) {
            const { min, max } = turnRanges[turnoSeleccionado];
            const horaSeleccionada = this.value;
            
            // Check if selected time is within the turn's range
            if (horaSeleccionada < min || horaSeleccionada > max) {
                this.value = ''; // Clear input
                mostrarMensajeError(`La hora debe estar entre ${min} y ${max} para el turno de ${turnoSeleccionado}`);
            }
        }
    });

    // Function to show error message (assumes the existing modal is available)
    function mostrarMensajeError(mensaje) {
        const mensajeModal = document.getElementById('mensajeModal');
        const modalMensajeBody = document.getElementById('modalMensajeBody');
        
        modalMensajeBody.textContent = mensaje;
        
        // Use Bootstrap to show the modal
        var modal = new bootstrap.Modal(mensajeModal);
        modal.show();
    }
});