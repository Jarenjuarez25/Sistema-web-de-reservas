<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Código</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="l-container">
        <h2 class="h2">Ingresa el Código de Verificación</h2>
        <form id="token-form" action="verificar-token.php" method="post">
            <div class="token-inputs">
                <input type="text" id="token1" maxlength="1" required onkeypress="return isNumberKey(event)" class="token-input">
                <input type="text" id="token2" maxlength="1" required onkeypress="return isNumberKey(event)" class="token-input">
                <input type="text" id="token3" maxlength="1" required onkeypress="return isNumberKey(event)" class="token-input">
                <input type="text" id="token4" maxlength="1" required onkeypress="return isNumberKey(event)" class="token-input">
                <input type="text" id="token5" maxlength="1" required onkeypress="return isNumberKey(event)" class="token-input">
                <input type="text" id="token6" maxlength="1" required onkeypress="return isNumberKey(event)" class="token-input">
            </div>
            <button type="submit">Verificar Código</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Función para mover al siguiente input del token
            function moveToNextInput(event, index) {
                var currentInput = document.getElementById('token' + index);

                // Solo permitir números
                if (!/^\d*$/.test(currentInput.value)) {
                    currentInput.value = currentInput.value.replace(/[^\d]/g, '');
                    return;
                }

                if (currentInput.value.length === 1 && index < 6) {
                    var nextInput = document.getElementById('token' + (index + 1));
                    if (nextInput) {
                        nextInput.focus();
                    }
                } else if (currentInput.value.length === 0 && index > 1) {
                    // Permitir retroceder con backspace
                    var prevInput = document.getElementById('token' + (index - 1));
                    if (prevInput) {
                        prevInput.focus();
                    }
                }
            }

            for (var i = 1; i <= 6; i++) {
                var input = document.getElementById('token' + i);
                input.addEventListener('keydown', function(event) {
                    moveToNextInput(event, parseInt(this.id.replace('token', '')));
                });
            }
        });
    </script>
</body>
</html>
