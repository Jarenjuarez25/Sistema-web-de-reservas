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
         <h1 class="menu_logo"> Panel administrativo - RestCevicheria Luigy's</h1>
      </section>
   </nav>
   
      <div class="section-Gre">
         <h2>Reservas</h2>
         <a href="gestion_reservas/liberar_mesas.php">Ir a Gestión de Reservas</a>
      </div>

      <div class="section-Gu">
         <h2>Usuarios</h2>
         <a href="gestion_usuario/index.php">Ir a Gestión de Usuarios</a>
      </div>

      <div class="section-Grese">
         <h2>Productos</h2>
         <a href="gestion_productos/admin-menu-panel.php">Gestion de Productos</a>
      </div> 

      <div class="section-Gr">
         <h2>Reclamos</h2>
         <a href="gestion_reclamos/index.php">Ir a Gestión Reclamos</a>
      </div>

      <div class="section-dahs">
         <h2>DASHBOARD</h2>
         <a href="Dashboard/index.php">Ir a Gestión Reclamos</a>
      </div>

   <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>