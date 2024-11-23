// Validación de teléfono con jQuery
$(document).ready(function() {
    const telefonoInput = $('#telefono');
    
    if (telefonoInput.length) {
        telefonoInput.on('input', function() {
            var telefono = $(this).val();
            var numDigitos = telefono.replace(/\D/g, '').length;

            if (numDigitos !== 9) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        telefonoInput.on('keypress', function(event) {
            if (event.key && !(/^\d$/.test(event.key))) {
                event.preventDefault();
            }
        });
    }
});