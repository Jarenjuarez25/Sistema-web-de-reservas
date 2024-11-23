<?php 

session_start();
require_once '../../database/conexion.php';

$con = new Conexion();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width = device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div id="loaderPagina" class="section_loader">
              <div class="loader">
                   <div class="loader_1"></div>
                  <div class="loader_2"></div>
            </div>
      </div>
    <narvar class="navbar-container">
        <a href="/restaurante_Cevicheria/index.php" ><img src="/restaurante_Cevicheria/Images/Logo.png" class="logo"></a>
        <nav class="navbar">
            <ul>
              <li><a href="/restaurante_Cevicheria/index.php">INICIO</a></li>
              <li><a href="/restaurante_Cevicheria/Principal_usuario/menu/index.php">MENÚ</a></li>
              <li><a href="/restaurante_Cevicheria/Principal_usuario/nosotros/index.php">NOSOTROS</a></li>
              <li><a href="/restaurante_Cevicheria/Principal_usuario/reservas/index.php">RESERVAS</a></li>
              <li><a href="/restaurante_Cevicheria/Principal_usuario/ubicacion/index.php">UBICACION</a></li>
              <div class="botones">
                <a href="/restaurante_Cevicheria/Principal_usuario/Login/index.php" class="btn-2">
                  <img src="/restaurante_Cevicheria/Images/usuario.png">
                </a>
              </div>
            </ul>
          </nav>
    </narvar>

  <div>
    <button class="registrarBoton" onclick="abrirModal1()">REGISTRATE AQUI</button>
  </div>

  <div class="modal1" id="modalADD1">
    <div class="modal1-contenedor">
      <div class="cerrarModal1" onclick="cerrarModal1()">x</div>
      <section>
        <div class="contenedor1">
          
          <h1>REGISTRO</h1>

          <form action="/restaurante_Cevicheria/controller/registro_usuario.php" method="POST" onsubmit="return validarFormularioRegister()">
            <br></br>
            <input type="text" id="nombre" name="nombre" class="input-Nombre" placeholder="Nombre*" required>
            <input type="text" id="apellidos" name="apellidos" class="input-Apellido" placeholder="Apellido*" required>
            <input type="text" id="dni" name="dni" class="input-Dni" placeholder="Dni*" maxlength="8" minlength="8" required>
            <input type="email" id="correo" name="correo" class="input-Correo" placeholder="Correo electrónico*" required>
            <input type="password" id="contraseña" name="contraseña" class="input-contrasenaa" placeholder="Contraseña*" maxlength="9" minlength="9" required>
            <img src="/restaurante_Cevicheria/Images/ojo.png" class="pass-icon" onclick="togglePasswordVisibility('contraseña', 'pass-icon')" id="pass-icon" style="display: none;"></img>
            
            <input type="password" id="confirmarContraseña" name="confirmarContraseña" class="input-confirmarContrasena" placeholder="Repetir contraseña*" maxlength="9" minlength="9" required>
            <img src="/restaurante_Cevicheria/Images/ojo.png" class="pass-icon2" onclick="togglePasswordVisibility('confirmarContraseña', 'pass-icon2')" id="pass-icon2" style="display: none;"></img>

            <label class="lb-Genero">Género*</label>
            <select id="genero" name="genero" class="input-Genero" required>
              <option value="">Seleccionar</option>
              <option value="masculino">Masculino</option>
              <option value="femenino">Femenino</option>
            </select>

            <label class="lb-fechaNacimiento">Fecha de Nacimiento*</label>
            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="input-fechaNacimiento" required>

            <button type="submit">Registrar</button>
        </form>
        </div>
      </section>
    </div>
  </div>
  
  <div>
    <button class="loginBoton" onclick="abrirModal()">INICIAR SESION</button>
  </div>

  <div class="modal" id="modalADD">
    <div class="modal-contenedor">
      <div class="cerrarModal" onclick="cerrarModal()">x</div>
      <section>
        <div class="Contenedor">
          <img class="icono-login" src="/restaurante_Cevicheria/Images/perfil-del-usuario.png">
          <br><br>
              <?php
                if (isset($_SESSION['mensaje'])) {
                    $mensaje = $_SESSION['mensaje'];
                    $tipo_mensaje = $_SESSION['tipo_mensaje'];
                    echo "<div class='mensaje $tipo_mensaje'>$mensaje</div>";
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo_mensaje']);
                }
                ?>
          <h1>INICIAR SESION</h1>
              <form method="POST" action="/restaurante_Cevicheria/controller/login_usuario.php">
                <br><br>
                <label class="lb-correo">Correo*</label>
                <input type="email" id="correo" class="input-correo" name="correo" placeholder="Ingresa tu correo" required>
                <label class="lb-Contrasena">Contraseña*</label>
                <input type="password" id="contra" class="input-Contrasena" name="contra" placeholder="Ingrese contraseña" maxlength="9" required>
                <img src="/restaurante_Cevicheria/Images/ojo.png" class="pass-icon3" onclick="togglePasswordVisibility('contra', 'pass-icon3')" id="pass-icon3" style="display: none;"></img>
                <button type="submit">INGRESAR</button>
                
            </form>
            <a href="/restaurante_Cevicheria/Principal_usuario/Restablecer_pass/index.php" class="login-olvi">Olvidé mi contraseña</a>
        </div>
      </section>


    </div>
  </div>

  <script src="script.js"></script>
  <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>

</html>
