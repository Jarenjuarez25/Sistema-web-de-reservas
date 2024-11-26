<?php

require('../../database\conexion.php');

$con = new Conexion();

if (isset($_SESSION['user_id'])) {
    $datos = $con->getNombreByUserId($_SESSION['user_id']);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Reclamaciones</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>

<body>
    <div class="container mt-5 reclamaciones-form">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Libro de Reclamaciones</h2>
                <p>En nuestra empresa, nos tomamos muy en serio las quejas de nuestros clientes. Nos esforzamos por brindar
                    un servicio excepcional y estamos comprometidos a mejorar continuamente. Si tienes alguna inquietud, por
                    favor llena este formulario y nos comunicaremos contigo a la brevedad.</p>
            </div>
        </div>

        <form action="/restaurante_Cevicheria/controller/insert-reclamaciones.php" class="mt-4" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="9"
                        placeholder="Ingresa un número de contacto." pattern="9[0-9]{8}" title="Ingrese un número valido."
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="asunto">Asunto</label>
                    <select class="form-control" id="asunto" name="asunto" required>
                        <option value="">Selecciona un asunto</option>
                        <option value="Calidad del producto">Calidad del producto</option>
                        <option value="Servicio al cliente">Servicio al cliente</option>
                        <option value="Compra">Problemas con mi compra</option>
                        <option value="Página Web">Conflictos en la página web</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion">Mensaje</label>
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
