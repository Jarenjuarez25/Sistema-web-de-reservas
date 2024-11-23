function validarFormularioRegister() {
    const nombre = document.getElementById('nombre').value;
    const dni = document.getElementById('dni').value;
    const apellido = document.getElementById('apellidos').value;
    const correo = document.getElementById('correo').value;

    // Validar formato del correo
    const regexCorreo = /^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9.-]+\.)?(gmail\.com|yahoo\.com|hotmail\.com|outlook\.com|live\.com|icloud\.com|edu\.pe)$/;
    if (!regexCorreo.test(correo)) {
        alert('El correo electrónico no es válido');
        return false;
    }

    // Validar DNI (solo números, 8 dígitos)
    const regexDni = /^\d{8}$/;
    if (!regexDni.test(dni)) {
        alert("El DNI debe contener 8 dígitos numéricos y no debe incluir letras o caracteres especiales.");
        return false;
    }

    // Validar nombre (solo letras)
    const regexNombre = /^[a-zA-ZÀ-ÿ\s]+$/;
    if (!regexNombre.test(nombre)) {
        alert("El nombre solo debe contener letras");
        return false;
    }

    // Validar apellidos (solo letras)
    const regexApellido = /^[a-zA-ZÀ-ÿ\s]+$/;
    if (!regexApellido.test(apellido)) {
        alert("Los apellidos solo deben contener letras");
        return false;
    }

    return true; // Form passes all validations
}