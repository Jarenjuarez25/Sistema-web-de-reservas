document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-link');
    const tabContents = document.querySelectorAll('.tab-content');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            navLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(t => t.classList.remove('active'));

            link.classList.add('active');

            const targetId = link.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const mostrarFormPagoBtn = document.getElementById('mostrar-form-pago');
    const confirmarPagoForm = document.getElementById('confirmar-pago-form');
    const numeroOperacionInput = document.getElementById('numero_operacion');

    mostrarFormPagoBtn.addEventListener('click', function () {
        confirmarPagoForm.style.display = 'block';
        mostrarFormPagoBtn.style.display = 'none';
    });

    const opcionesRadios = document.querySelectorAll('input[type="radio"]');
    opcionesRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            const imagenesOpciones = document.querySelectorAll('.opcion-imagen');
            imagenesOpciones.forEach(function (imagen) {
                imagen.style.display = 'none';
            });

            const imagenMostrar = this.parentNode.querySelector('.opcion-imagen');
            imagenMostrar.style.display = 'inline-block';

            // Cambiar el placeholder del input numero_operacion según la opción seleccionada
            if (this.value === 'Yape') {
                numeroOperacionInput.placeholder = 'Ingrese el número de operación de Yape';
            } if (this.value === 'Plin') {
                numeroOperacionInput.placeholder = 'Ingrese el número de operación de Plin';
            } else if (this.value === 'Cuenta') {
                numeroOperacionInput.placeholder = 'Ingrese el número de operación';
            }
        });
    });
});

//para el ojito osea ver la contra
document.addEventListener('DOMContentLoaded', function () {
    var current_password = document.getElementById('current_password');
    var new_password = document.getElementById('new_password');
    var confirm_password = document.getElementById('confirm_password');
    var current_passwordToggle = document.getElementById('current_password-toggle');
    var new_passwordToggle = document.getElementById('new_password-toggle');
    var confirm_passwordToggle = document.getElementById('confirm_password-toggle');


    current_password.addEventListener('input', function () {
        togglePasswordIconVisibility(current_password.value, current_passwordToggle);
    });
    new_password.addEventListener('input', function () {
        togglePasswordIconVisibility(new_password.value, new_passwordToggle);
    });
    confirm_password.addEventListener('input', function () {
        togglePasswordIconVisibility(confirm_password.value, confirm_passwordToggle);
    });

    // Ocultar los íconos al cargar la página si los campos están vacíos inicialmente
    togglePasswordIconVisibility(current_password.value, current_passwordToggle);
    togglePasswordIconVisibility(new_password.value, new_passwordToggle);
    togglePasswordIconVisibility(confirm_password.value, confirm_passwordToggle);
});

function togglePasswordIconVisibility(value, icon) {
    if (icon) {
        if (value.length > 0) {
            icon.style.display = 'inline-block';
        } else {
            icon.style.display = 'none';
        }
    }
}

function togglePasswordVisibility(fieldId) {
    var field = document.getElementById(fieldId);
    var icon = document.getElementById(fieldId + '-toggle-icon');

    if (field && icon) {
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
}

$(document).ready(function () {
    var originalEmail = $('#correo').val();
    var originalValues = {};
    $('#updateConfPassButton,#updateConfEmailButton,#updateButton,#cancelButton').prop('disabled', true);
    // Función para activar la edición al hacer clic en el icono
    $('.edit-icon,#ciudad,#fecha_nacimiento').click(function () {
        var targetId = $(this).data('target');
        var $targetInput = $('#' + targetId);

        // Almacenar el valor original antes de editar
        if (!(targetId in originalValues)) {
            originalValues[targetId] = $targetInput.val();
        }
        $targetInput.removeClass('readonly').prop('readonly', false).focus();
        $('#updateButton,#cancelButton').prop('disabled', false);
    });

    $('.edit-icon[data-target="password"]').click(function () {
        $('#password').prop('readonly', true);
        $('#correo').prop('readonly', true);
        $('#password-fields').show();
        passwordFieldsVisible = true;
        $('#updateConfPassButton, #cancelButton').prop('disabled', false);
    });
    $('.edit-icon[data-target="correo"]').click(function () {
        $('#password').prop('readonly', true);
        $('#correo').prop('readonly', false);
        $('#password-fields').hide();
        passwordFieldsVisible = true;
        $('#updateConfEmailButton, #cancelButton').prop('disabled', false);
    });

    // Evitar envío del formulario al presionar Enter en campos editables
    $('.editable').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') { // Tecla Enter
            event.preventDefault();
        }
    });


    $('#cancelButton').click(function () {
        if (passwordFieldsVisible) {
            $('#password-fields').hide();
            passwordFieldsVisible = false;
            $('#current_password, #new_password, #confirm_password').val('');
        }
    });
});

//para el tiempo de la alerta
document.addEventListener("DOMContentLoaded", function () {
    var mensaje = document.querySelector(".mensaje");
    if (mensaje) {
        setTimeout(function () {
            mensaje.remove();
        }, 3000);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.btn-danger').forEach(function (cancelButton) {
        cancelButton.addEventListener('click', function (event) {
            event.preventDefault();

            const reservationRow = this.closest('tr');
            const reservationId = reservationRow.getAttribute('data-id');
            const url = this.getAttribute('href');

            const cancelUrl = url + "?id=" + reservationId;

            fetch(cancelUrl, {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        reservationRow.remove();
                        alert('Reserva cancelada exitosamente');
                        location.reload();
                    } else {
                        alert('No se pudo cancelar la reserva');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al cancelar la reserva');
                });
        });
    });
});