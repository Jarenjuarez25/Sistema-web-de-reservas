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
