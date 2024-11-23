<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<?php

require('../../database\conexion.php');

$con = new Conexion();
$nombre = ''; // Inicializa $nombre con un valor predeterminado
//var_dump($_SESSION);
//exit("1");
if (isset($_SESSION['user_id'])) {
    $nombre = $con->getNombreByUserId($_SESSION['user_id']);
    //var_dump($nombre);
    //exit("");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Nosotros</title>
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico" />
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div id="loaderPagina" class="section_loader">
                <div class="loader">
                    <div class="loader_1"></div>
                    <div class="loader_2"></div>
            </div>
    </div>

    <div class="navbar-container">
        <a 
        style="    padding-left: 20px;"
        href="/restaurante_Cevicheria/index.php"><img src="/restaurante_Cevicheria/Images/Logo.png" class="logo"></a>
        <nav class="navbar">
            <ul>
                <li><a href="/restaurante_Cevicheria/index.php">INICIO</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/menu/index.php">MENÚ</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/nosotros/index.php">NOSOTROS</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/reservas/index.php">RESERVAS</a></li>
                <li><a href="/restaurante_Cevicheria/Principal_usuario/ubicacion/index.php">UBICACION</a></li>
                

                <?php if (isset($_SESSION['user_cargo_id']) && $_SESSION['user_cargo_id'] == 1) : ?>
                    <li>
                        <a href="/restaurante_Cevicheria/Principal_admin/index.php">ADMIN</a>
                    </li>
                <?php endif; ?>

                <li style="text-transform: uppercase;">
                    <a href="">
                        <?php if (isset($_SESSION['user_nombre'])) : ?>
                            <span class="usuario-nombre"><?php echo $_SESSION['user_nombre']; ?></span>
                        <?php endif; ?>
                    </a>          
                </li>

                <div class="sm-usuario">
                    <a href="#" class="usuario-toggle">
                        <img src="/restaurante_Cevicheria/Images/usuario.png" class="usuario-img">
                    </a>

                    <div class="usuario-dropdown">
                    <?php if (isset($_SESSION['user_nombre'])) : ?>
                            <!-- If the user is logged in, show options -->
                            <p><a href="/restaurante_Cevicheria/profile.php#profile-personal"><i class="fas fa-user-circle"></i> Mi perfil</a></p>
                            <p><a href="/restaurante_Cevicheria/controller/logout-user.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></p>
                        <?php else : ?>
                            <!-- If the user is not logged in, show login option -->
                            <p><a href="/restaurante_Cevicheria/Principal_usuario/Login/index.php"><i class="fas fa-sign-in-alt"></i> Inicia sesión</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </ul>
        </nav>
    </div>
<!-- Nosotros Section -->
<div class="nosotros">
  <div class="container">
      <h2>CONOCE UN POCO MAS DE ESTA LINDA FAMILIA!</h2>
      
      <p class="intro">Descubre nuestra historia, nuestra misión y nuestra pasión por ofrecer el mejor ceviche y platos marinos en un ambiente acogedor y auténtico.</p>
      
      <div class="content">
          <div class="about-text">
              <h3>Misión</h3>
              <p>Entregar a los consumidores productosde excelencia altamente nutricionales, con materias primas, aportando ala calidad de vida de las personas.</p>
              
              <h3>Visión</h3>
              <p>Ser una empresa lider en elabiracion de platos tipicos, marinos y criollos, entregando soluciones alas necesidades de nuestros clientes.</p>
              
              <h3>Objetivos generales</h3>
              <p>Brindar una gastronomía unica e inolvidable, creda con nuetsro sabor y creatividad.</p>

              <h3>Objetivos especificos</h3>
              <p>- Poseer ambientes cómodos para un mejor servicio. <br>
                - Buscar innovar y satisfacer al gusto de nuetsros comensales. <br>
                - Contar con los mejores proveedores de alimentos para asi ofrecer una mejor calidad en nuestros PLATILLOS.</p>

              <div class="about-image">
                <img src="/restaurante_Cevicheria/Images/equipo.png" alt="Foto de nuestro equipo en el restaurante">
            </div>

          </div>
        </div>
  </div>
</div>
    <script src="/restaurante_Cevicheria/js/drop.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
    </body>
</hmtl>
