<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width = device-width, initial-scale=1.0">
   <title>Panel de administrador</title>
   <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="/restaurante_Cevicheria/css/style_admin.css" />
</head>

<body style="background: linear-gradient(135deg, #f5f7fa 0%, #031b34 100%);height: 990px;">
   <div id="loaderPagina" class="section_loader">
        <div class="loader">
                <div class="loader_1"></div>
                <div class="loader_2"></div>
        </div>
    </div>

<button class="boton-salir" onclick="location.href='/restaurante_Cevicheria/index.php'">SALIR</button>
<nav class="menu">
      <section class="menu_contenedor">
         <h1 class="menu_logo"> Panel administrativo</h1>
      </section>
   </nav>
   
      <div class="section-Gre">
         <h2>Gestion de reservas</h2>
         <a href="gestion_reservas/liberar_mesas.php">PULSE AQUI!</a>
      </div>

      <div class="section-Gu">
         <h2>Gestion de usuarios</h2>
         <a href="gestion_usuario/index.php">PULSE AQUI!</a>
      </div>

      <div class="section-Grese">
         <h2>Gestion de productos</h2>
         <a href="gestion_productos/admin-menu-panel.php">PULSE AQUI!</a>
      </div> 

      <div class="section-Gr">
         <h2>Gestion de reclamos</h2>
         <a href="gestion_reclamos/index.php">PULSE AQUI!</a>
      </div>

      <div class="section-dahs">
         <h2>DASHBOARD</h2>
         <a href="Dashboard/index.php">PULSE AQUI!</a>
      </div>

      <div class="section-contac">
         <h2>Gestion de contacto</h2>
      <a href="/restaurante_Cevicheria/Principal_admin/gestion_contacto/index.php">PULSE AQUI!</a>
      </div>
   <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>