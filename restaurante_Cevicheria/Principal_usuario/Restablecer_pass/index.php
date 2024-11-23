<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="contenedor">
  <?php
        if (isset($_SESSION['mensaje'])) {
            $mensaje = $_SESSION['mensaje'];
            $tipo_mensaje = $_SESSION['tipo_mensaje'];
            echo "<div class='mensaje $tipo_mensaje'>$mensaje</div>";
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
        }
        ?>
    <h2>¿Has olvidado tu contraseña?</h2>
    <form action="/restaurante_Cevicheria/library/PHPMailer-master/reset-pass.php" method="post" class="formulario">
      <input type="email" id="email" name="email" placeholder="Email/Correo electronico" required>

      <div class="button-grupo">
        <button type="submit">Recuperar</button>
        <button type="button" class="btn-cancelar" onclick="window.location.href='/restaurante_Cevicheria/Principal_usuario/login/index.php'">Cancelar</button>
      </div>
    </form>
  </div>
  
  <script src="script.js"></script>
</body>

</html>