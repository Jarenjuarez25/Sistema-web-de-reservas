document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const tabContents = document.querySelectorAll('.tab-content');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Remove active class from all links and tabs
            navLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked link
            link.classList.add('active');
            
            // Show corresponding tab content
            const targetId = link.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const mostrarFormPagoBtn = document.getElementById('mostrar-form-pago');
    const confirmarPagoForm = document.getElementById('confirmar-pago-form');
    const numeroOperacionInput = document.getElementById('numero_operacion');

    mostrarFormPagoBtn.addEventListener('click', function() {
        confirmarPagoForm.style.display = 'block';
        mostrarFormPagoBtn.style.display = 'none';
    });

    const opcionesRadios = document.querySelectorAll('input[type="radio"]');
    opcionesRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            const imagenesOpciones = document.querySelectorAll('.opcion-imagen');
            imagenesOpciones.forEach(function(imagen) {
                imagen.style.display = 'none';
            });

            const imagenMostrar = this.parentNode.querySelector('.opcion-imagen');
            imagenMostrar.style.display = 'inline-block';

            // Cambiar el placeholder del input numero_operacion según la opción seleccionada
            if (this.value === 'Yape') {
                numeroOperacionInput.placeholder = 'Ingrese el número de operación de Yape';
            } else if (this.value === 'Plin') {
                numeroOperacionInput.placeholder = 'Ingrese el número de operación de Plin';
            }
        });
    });
});
