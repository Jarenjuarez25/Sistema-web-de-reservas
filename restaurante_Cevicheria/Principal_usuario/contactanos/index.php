<?php

require_once '../../database/conexion.php';

$con = new Conexion();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactanos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>

<body>
    <div class="container mt-5 reclamaciones-form">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Contactanos</h2>
                <p>En nuestra empresa, nos importa mantenernos en comunicación contigo. Estamos aquí para brindarte el mejor servicio y resolver cualquier 
                    duda o consulta que tengas. Por favor, completa este formulario, y nos pondremos en contacto contigo lo antes posible. ¡Estamos para ayudarte!.</p>
            </div>
        </div>

        <form action="/restaurante_Cevicheria/controller/contactanos.php" class="mt-4" method="POST">
            <div class="form-row">

            <div class="form-group col-md-6">
                    <label for="nombre">Nombres.</label>
                    <input type="text" class="form-control" id="nombre" name="nombre_completo"p placeholder="Ingresa su nombre completo." 
                    title="Ingrese un nombre completo." required>
                </div>

                <div class="form-group col-md-6">
                    <label for="telefono">Apellidos.</label>
                    <input type="text" class="form-control" id="apellido" name="apellido_completo" placeholder="Ingresa un número de contacto." 
                    title="Ingrese un número valido." required>
                </div>


            <div class="form-group col-md-6">
                    <label for="telefono">Teléfono.</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9"
                        placeholder="Ingresa un número de contacto." pattern="9[0-9]{8}" title="Ingrese un número valido."
                        required>
                </div>

                <div class="form-group col-md-6">
                    <label for="correo">Correo.</label>
                    <input type="email" class="form-control" id="correo" name="correo"
                        placeholder="Ingresa un correo de contacto." title="Ingrese un correo valido."
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="asunto">Asunto.</label>
                    <input type="text" class="form-control" id="asunto" name="asunto" title="Ingrese su asunto" placeholder="Ingrese su asunto" required>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion">Mensaje.</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5"
                    placeholder="Escribe tu mensaje aquí" title="Ingrese un mensaje valido."
                    maxlength="255" required></textarea>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
