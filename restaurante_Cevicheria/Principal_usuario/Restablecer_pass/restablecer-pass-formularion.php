<?php 
session_start();  
if (!isset($_SESSION['reset_email'])) {     
    header("Location: /restaurante_Cevicheria/Principal_usuario/Login/index.php");     
    exit(); 
}  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="l-container">
            <?php
            if (isset($_SESSION['mensaje'])) {
                $mensaje = $_SESSION['mensaje'];
                $tipo_mensaje = $_SESSION['tipo_mensaje'];
                echo "<div class='mensaje $tipo_mensaje'>$mensaje</div>";
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo_mensaje']);
            }
            ?>
            <form id="token-form" action="/restaurante_Cevicheria/controller/reset-pass-token.php" method="post" class="formulario">
                <h4 class="login-title">Ingresa el código de verificación:</h4>
                <div class="token-container">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                    <input type="text" id="token<?= $i ?>" name="token[]" class="token-input" maxlength="1" required onkeypress="return isNumberKey(event)" oninput="moveToNextInput(event, <?= $i ?>)">
                    <?php endfor; ?>
                </div>
                    <input type="submit" value="Validar Token" class="validar-submit">
            </form>

            <form id="password-form" action="/restaurante_Cevicheria/controller/reset-pass-new.php" method="post" class="nuevo_contraseña" style="display: none;">
                <h4 class="login-title">Nueva contraseña</h4><br>

                <div class="login-group">
                    <label for="contrasenia" class="login-label">Nueva contraseña:</label>
                    <div class="password-input-container">
                        <input type="password" id="contrasenia" name="contrasenia" class="login-input" 
                        oninput="togglePasswordIconVisibility('contrasenia')"required>
                       
                        <span class="password-toggle" id="contrasenaia-toggle"
                        onclick="togglePasswordVisibility('contrasenia')">
                        <i id="contrasenia-toggle-icon" class="fa fa-eye-slash" style="display: none;"></i>
                    </span>

                    </div>
                </div>

                <div class="login-group">
                    <label for="confirm_contrasenia" class="login-label">Confirmar contraseña:</label>
                    <div class="password-input-container">
                        <input type="password" id="confirm_contrasenia" name="confirm_contrasenia" class="login-input" 
                        required oninput="togglePasswordIconVisibility('confirm_contrasenia')" required>

                        <span class="password-toggle" id="confirm_contrasena-toggle"
                        onclick="togglePasswordVisibility('confirm_contrasenia')">
                        <i id="confirm_contrasenia-toggle-icon" class="fa fa-eye-slash" style="display: none;"></i>
                        </span>

                    </div>
                </div>
                <input type="submit" value="Restablecer contraseña" class="login-submit">
            </form>
        </div>
    </div>
    
    <script>
// Validación del formulario de token
document.getElementById('token-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var token = '';
    var isValid = true;
    
    // Validar que todos los campos del token estén llenos
    for (var i = 1; i <= 6; i++) {
        var tokenInput = document.getElementById('token' + i);
        if (!tokenInput.value) {
            isValid = false;
            tokenInput.classList.add('error');
        } else {
            token += tokenInput.value;
            tokenInput.classList.remove('error');
        }
    }
    
    if (!isValid) {
        mostrarMensaje('Por favor complete todos los dígitos del código', 'error');
        return;
    }

    // Verificar el token con el servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", form.action, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status == 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById('password-form').style.display = 'block';
                    document.getElementById('token-form').style.display = 'none';
                    mostrarMensaje('Código verificado correctamente', 'success');
                } else {
                    mostrarMensaje(response.message || 'Error al verificar el código', 'error');
                }
            } catch (e) {
                mostrarMensaje('Error al procesar la respuesta del servidor', 'error');
            }
        } else {
            mostrarMensaje('Error en la conexión con el servidor', 'error');
        }
    };
    xhr.onerror = function() {
        mostrarMensaje('Error en la conexión con el servidor', 'error');
    };
    xhr.send('token=' + token);
});

// Validación del formulario de contraseña
document.getElementById('password-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var contrasenia = document.getElementById('contrasenia');
    var confirmContrasenia = document.getElementById('confirm_contrasenia');
    
    // Limpiar mensajes de error previos
    contrasenia.classList.remove('error');
    confirmContrasenia.classList.remove('error');
    
    // Validar contraseña
    var errorMessage = validatePassword(contrasenia.value, confirmContrasenia.value);
    if (errorMessage) {
        mostrarMensaje(errorMessage, 'error');
        contrasenia.classList.add('error');
        confirmContrasenia.classList.add('error');
        return;
    }

    // Si todo está bien, enviar el formulario
    this.submit();
});

// Función para validar la contraseña
function validatePassword(contrasena, confirmContrasena) {
    if (contrasena !== confirmContrasena) {
        return "Las contraseñas no coinciden.";
    }
    if (contrasena.length < 8) {
        return "La contraseña debe tener al menos 8 caracteres.";
    }
    if (!/[A-Z]/.test(contrasena)) {
        return "La contraseña debe tener al menos una letra mayúscula.";
    }
    if (!/\d/.test(contrasena)) {
        return "La contraseña debe tener al menos un número.";
    }
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(contrasena)) {
        return "La contraseña debe tener al menos un carácter especial.";
    }
    return null; // Sin errores
}

// Agregar validación en tiempo real para los campos de contraseña y confirmación de contraseña
document.querySelectorAll('#contrasenia, #confirm_contrasenia').forEach(input => {
    input.addEventListener('input', function(e) {
        var valor = this.value;
        
    });
});


// Función para mostrar mensajes
function mostrarMensaje(mensaje, tipo) {
    var mensajeDiv = document.createElement('div');
    mensajeDiv.className = 'mensaje ' + tipo;
    mensajeDiv.textContent = mensaje;

    // Remover mensaje anterior si existe
    var mensajeAnterior = document.querySelector('.mensaje');
    if (mensajeAnterior) {
        mensajeAnterior.remove();
    }

    // Insertar nuevo mensaje
    var container = document.querySelector('.l-container');
    container.insertBefore(mensajeDiv, container.firstChild);

    // Remover mensaje después de 3 segundos
    setTimeout(function() {
        mensajeDiv.remove();
    }, 3000);
}


// Función para mover al siguiente input
function moveToNextInput(event, currentInputNumber) {
  const input = event.target;
  const maxLength = parseInt(input.getAttribute('maxlength'));
  let nextInput;

  // Si el input actual está lleno, mover al siguiente
  if (input.value.length >= maxLength) {
      nextInput = document.getElementById(`token${currentInputNumber + 1}`);
      if (nextInput) {
          nextInput.focus();
      }
  }

  // Si se presiona Backspace y el input está vacío, mover al anterior
  if (event.inputType === 'deleteContentBackward' && input.value.length === 0) {
      const prevInput = document.getElementById(`token${currentInputNumber - 1}`);
      if (prevInput) {
          prevInput.focus();
      }
  }
}

// Función para pegar el código completo
document.addEventListener('DOMContentLoaded', function() {
  const tokenInputs = document.querySelectorAll('.token-input');

  tokenInputs.forEach(input => {
      input.addEventListener('paste', function(e) {
          e.preventDefault();
          const pastedData = e.clipboardData.getData('text');
          const digits = pastedData.replace(/\D/g, '').split('');

          tokenInputs.forEach((input, index) => {
              if (digits[index]) {
                  input.value = digits[index];
                  // Disparar el evento input para activar moveToNextInput
                  const event = new Event('input', {bubbles: true});
                  input.dispatchEvent(event);
              }
          });
      });
  });
});

//togle que es el ojito para ver la contraseña
function togglePasswordVisibility(inputId) {
    var passwordInput = document.getElementById(inputId);
    var toggleIcon = document.getElementById(inputId + '-toggle-icon');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
}

// Función para mostrar u ocultar el icono basado en la longitud del valor
function togglePasswordIconVisibility(inputId) {
    var passwordInput = document.getElementById(inputId);
    var toggleIcon = document.getElementById(inputId + '-toggle-icon');

    if (passwordInput.value.length > 0) {
        toggleIcon.style.display = "block";
    } else {
        toggleIcon.style.display = "none";
    }
}

// Agregar evento para llamar a la función al escribir en el input contraseña
document.getElementById('contrasenia').addEventListener('input', function() {
    togglePasswordIconVisibility('contrasenia');
});




</script>

</body>
</html>