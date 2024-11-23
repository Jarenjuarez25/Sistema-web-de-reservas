function abrirModalReserva(numero_mesa) {
    document.getElementById('numeroMesa').value = numero_mesa;
    const reservaModal = new bootstrap.Modal(document.getElementById('reservaModal'));
    reservaModal.show();
  }
  
  function realizarReserva() {
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
        if (data.success) {
            alert('Reserva realizada con éxito');
            window.location.reload();
        } else {
            alert(data.message || 'Error al realizar la reserva');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la reserva');
    });
  }
  
