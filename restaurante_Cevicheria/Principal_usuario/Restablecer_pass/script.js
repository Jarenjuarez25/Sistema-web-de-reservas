document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.formulario');
    const emailInput = document.getElementById('email');

    form.addEventListener('submit', function (event) {
        const email = emailInput.value.trim();
        
        const regex = /^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9.-]+\.)?(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com|live\.com|icloud\.com|edu\.pe)$/;

        if (!email) {
            alert('Por favor, ingresa un correo electrónico.');
            event.preventDefault();
            return;
        }

        if (!regex.test(email)) {
            alert('El correo electrónico no es válido');
            event.preventDefault(); 
            return;
        }

    });
});

document.addEventListener("DOMContentLoaded", function() {
    var mensaje = document.querySelector(".mensaje");
    if (mensaje) {
        setTimeout(function() {
            mensaje.remove();
        }, 2000);
    }
});

