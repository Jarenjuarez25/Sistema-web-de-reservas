/*Registrarse*/
const modalADD1 = document.querySelector("#modalADD1");

const abrirModal1 = () => {
    modalADD1.style.display = "flex";
};

const cerrarModal1 = () => {
    modalADD1.style.display = "none";
    
    document.querySelectorAll("#modalADD1 input").forEach(input => input.value = '');
};

// Verificar parámetros URL para abrir modal automáticamente
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('openModal') === 'registro') {
      abrirModal1();
      
      window.history.replaceState({}, document.title, window.location.pathname);
  }
});

/*Login*/
const modalADD = document.querySelector("#modalADD");

const abrirModal = () => {
    modalADD.style.display = "flex";
};

const cerrarModal = () => {
    modalADD.style.display = "none";
    document.querySelectorAll("#modalADD input").forEach(input => input.value = '');
};

// Verificar parámetros URL para abrir modal automáticamente
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('openModal') === 'login') {
    abrirModal();
      
      window.history.replaceState({}, document.title, window.location.pathname);
  }
});

/*Validar identidad en registro*/
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


  const regexLongitud = /^.{9,}$/; // Al menos 9 caracteres
  const regexMayuscula = /[A-Z]/; // Al menos una letra mayúscula
  const regexNumero = /\d/;       // Al menos un número
  const regexEspecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?`~]/; // Al menos un carácter especial
  
  if (!regexLongitud.test(contraseña)) {
      alert('La contraseña debe tener al menos 9 caracteres.');
      return false;
  }
  
  if (!regexMayuscula.test(contraseña)) {
      alert('La contraseña debe incluir al menos una letra mayúscula');
      return false;
  }
  
  if (!regexNumero.test(contraseña)) {
      alert('La contraseña debe incluir al menos un número');
      return false;
  }
  
  if (!regexEspecial.test(contraseña)) {
      alert('La contraseña debe incluir al menos un carácter especial');
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


document.addEventListener("DOMContentLoaded", function() {
  var mensaje = document.querySelector(".mensaje");
  if (mensaje) {
      setTimeout(function() {
          mensaje.remove();
      }, 3000);
  }
});

