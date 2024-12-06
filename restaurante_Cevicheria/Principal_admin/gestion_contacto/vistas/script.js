document.getElementById('respuestaForm').addEventListener('submit', function(event) {
    var respuesta = document.getElementById('respuesta').value.trim();
    if (respuesta === '') {
        event.preventDefault();
        alert('La respuesta no puede estar vacía.');
    } else {
        // Cambia el estado a "Respondido" y actualiza la clase del input de estado
        document.getElementById('estado').value = 'Resuelto';
        document.getElementById('estado').classList.remove('estado-pendiente');
        document.getElementById('estado').classList.add('estado-resuelto');
        document.getElementById('estadoInput').value = 'Resuelto';
    }
});