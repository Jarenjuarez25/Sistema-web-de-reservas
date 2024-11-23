// reservas.js
document.addEventListener('DOMContentLoaded', function() {
    // Función para actualizar el estado de la reserva
    async function actualizarEstadoReserva(reservaId, nuevoEstado) {
        try {
            const response = await fetch(`/restaurante_Cevicheria/controller/actualizar_reserva.php?id=${reservaId}&estado=${encodeURIComponent(nuevoEstado)}`, {
                method: 'GET'
            });

            if (!response.ok) {
                throw new Error('Error al actualizar el estado');
            }

            // Actualizar la interfaz después de una actualización exitosa
            actualizarInterfazReserva(reservaId, nuevoEstado);
        } catch (error) {
            console.error('Error:', error);
            alert('Hubo un error al actualizar el estado de la reserva');
        }
    }

    // Función para actualizar la interfaz de una reserva
    function actualizarInterfazReserva(reservaId, nuevoEstado) {
        const fila = document.getElementById(`reserva-${reservaId}`);
        if (!fila) return;

        const tdEstado = fila.querySelector('.estado-reserva');
        const tdAcciones = fila.querySelector('.acciones-reserva');

        // Actualizar el texto del estado
        tdEstado.textContent = nuevoEstado;

        // Actualizar los botones según el nuevo estado
        tdAcciones.innerHTML = '';

        switch (nuevoEstado) {
            case 'En proceso':
                tdEstado.style.color = 'blue';
                tdAcciones.innerHTML = `
                    <button class="btn btn-success btn-sm btn-liberar" data-reserva-id="${reservaId}">
                        Liberar
                    </button>
                `;
                break;
            case 'Resuelto':
                tdEstado.style.color = 'green';
                tdAcciones.innerHTML = `
                    <button class="btn btn-success btn-sm" disabled>Resuelto</button>
                    <button class="btn btn-danger btn-sm btn-eliminar" data-reserva-id="${reservaId}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
                break;
            case 'Pendiente':
                tdEstado.style.color = 'red';
                tdAcciones.innerHTML = `
                    <button class="btn btn-primary btn-sm btn-aceptar" data-reserva-id="${reservaId}">
                        Aceptar
                    </button>
                `;
                break;
        }

        // Volver a agregar los event listeners a los nuevos botones
        agregarEventListeners();
    }

    // Función para eliminar una reserva
    async function eliminarReserva(reservaId) {
        if (!confirm('¿Está seguro de que desea eliminar esta reserva?')) {
            return;
        }

        try {
            const response = await fetch(`/restaurante_Cevicheria/controller/eliminar_reserva.php?id=${reservaId}`, {
                method: 'GET'
            });

            if (!response.ok) {
                throw new Error('Error al eliminar la reserva');
            }

            // Eliminar la fila de la tabla
            const fila = document.getElementById(`reserva-${reservaId}`);
            if (fila) {
                fila.remove();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Hubo un error al eliminar la reserva');
        }
    }

    // Función para agregar event listeners a los botones
    function agregarEventListeners() {
        // Event listeners para botones de aceptar
        document.querySelectorAll('.btn-aceptar').forEach(button => {
            button.addEventListener('click', function() {
                const reservaId = this.dataset.reservaId;
                actualizarEstadoReserva(reservaId, 'En proceso');
            });
        });

        // Event listeners para botones de liberar
        document.querySelectorAll('.btn-liberar').forEach(button => {
            button.addEventListener('click', function() {
                const reservaId = this.dataset.reservaId;
                actualizarEstadoReserva(reservaId, 'Resuelto');
            });
        });

        // Event listeners para botones de eliminar
        document.querySelectorAll('.btn-eliminar').forEach(button => {
            button.addEventListener('click', function() {
                const reservaId = this.dataset.reservaId;
                eliminarReserva(reservaId);
            });
        });
    }

    // Inicializar los event listeners cuando se carga la página
    agregarEventListeners();
});