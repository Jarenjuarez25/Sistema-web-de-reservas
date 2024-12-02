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
            } if (this.value === 'Plin') {
                numeroOperacionInput.placeholder = 'Ingrese el número de operación de Plin';
            }else if (this.value === 'Cuenta') {
                numeroOperacionInput.placeholder = 'Ingrese el número de operación';
            }
        });
    });
});


//funcion para la seleccion de tablas independientes
const selectAllCheckbox = document.querySelector('.select-all');
const selectRowCheckboxes = document.querySelectorAll('.select-row');
const totalPago = document.getElementById('total-pago');

let totalGeneralPago = 0;

// Función para actualizar el total a pagar
function updateTotalPago() {
    totalGeneralPago = 0;
    selectRowCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            totalGeneralPago += parseFloat(checkbox.dataset.pago);
        }
    });
    totalPago.textContent = totalGeneralPago.toFixed(2);
}

// Evento para seleccionar/deseleccionar todas las filas
selectAllCheckbox.addEventListener('change', () => {
    selectRowCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateTotalPago();
});

// Evento para actualizar el total a pagar cuando se selecciona/deselecciona una fila
selectRowCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateTotalPago);
});


//validaciones para cambiar datos usuarios
function validarFormularioRegister() {
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellidos').value;
    const dni = document.getElementById('dni').value;
    const contraseña = document.getElementById('contraseña').value;
    const confirmarContraseña = document.getElementById('confirmarContraseña').value;
    const correo = document.getElementById('correo').value;
  
    const regexNombre = /^[a-zA-ZÀ-ÿ\s]+$/;
    if (!regexNombre.test(nombre)){
        alert("El nombre solo debe contener letras");
        return false;
    }
  
    const regexApellido = /^[a-zA-ZÀ-ÿ\s]+$/;
    if (!regexApellido.test(apellido)){
        alert("El Apellido solo debe contener letras");
        return false;
    }
  
  
    const regexDni = /^\d{8}$/;
    if (!regexDni.test(dni)) {
        alert("El DNI no debe contener letras o caracteres especiales");
        return false;
    }
  
    const regexCorreo = /^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9.-]+\.)?(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com|live\.com|icloud\.com|edu\.pe)$/;
    if (!regexCorreo.test(correo)) {
        alert('El correo electrónico no es válido');
        return false;
    }
  
  
    const regexContraseña = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$/;
    if (!regexContraseña.test(contraseña)) {
      alert('La contraseña debe incluir al menos 9 digitos, una letra mayúscula, un número y un carácter especial.');
      return false;
    }
  
    if (contraseña !== confirmarContraseña) {
        alert('Las contraseñas no coinciden');
        return false;
    }
  
  }
  
  function togglePasswordVisibility(fieldId, iconId) {
    const passwordInput = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
  
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.src = '/restaurante_Cevicheria/Images/ojo.png';
    } else {
      passwordInput.type = 'password';
      icon.src = '/restaurante_Cevicheria/Images/ojo.png';
    }
  }
  
  function toggleIconVisibility(fieldId, iconId) {
    const passwordInput = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
  
    if (passwordInput.value) {
      icon.style.display = 'inline'; // Mostrar el ícono cuando hay texto
    } else {
      icon.style.display = 'none'; // Ocultar el ícono cuando el campo está vacío
    }
  }
  
  // Añadir los listeners de eventos para ambos campos de contraseña
  document.getElementById('contraseña').addEventListener('input', function() {
    toggleIconVisibility('contraseña', 'pass-icon');
  });
  
  document.getElementById('confirmarContraseña').addEventListener('input', function() {
    toggleIconVisibility('confirmarContraseña', 'pass-icon2');
  });
  document.getElementById('contra').addEventListener('input', function() {
    toggleIconVisibility('contra', 'pass-icon3');
  });
  
  
  