<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<?php

require('../../database\conexion.php');

$con = new Conexion();
$nombre = '';
if (isset($_SESSION['user_id'])) {
    $nombre = $con->getNombreByUserId($_SESSION['user_id']);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Ubicacion</title>
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style.css" />
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
                            <p><a href="/restaurante_Cevicheria/profile.php#profile-personal"><i class="fas fa-user-circle"></i> Mi perfil</a></p>
                            <p><a href="/restaurante_Cevicheria/controller/logout-user.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></p>
                        <?php else : ?>
                            <p><a href="/restaurante_Cevicheria/Principal_usuario/Login/index.php"><i class="fas fa-sign-in-alt"></i> Inicia sesión</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </ul>
        </nav>
    </div>

    
    <div class="seccion-1">
        <h2>NUESTRO LOCAL</h2>
        <p>Puedes visitar nuestro local en. Piura 26 de octubre, 1 etapa del condominio santa margarita. Asegurandote un
            ambiente acojedor
            ademas de amigable para ti y toda tu familia, amigos.
        </p>
        <div class="separador-1"></div>
        <a href="https://www.google.com/maps/place/Rest+CEVICHERIA+luigys/@-5.1686799,-80.6606591,20z/data=!4m6!3m5!1s0x904a1b813a27393f:0x2ec49b2e5608ff02!8m2!3d-5.1686832!4d-80.6606645!16s%2Fg%2F11q383_qmm?entry=ttu&g_ep=EgoyMDI0MTAyMi4wIKXMDSoASAFQAw%3D%3D"
            target="_blank">
            <video src="/restaurante_Cevicheria/videos/Video-Ubi.mp4" autoplay loop width="450"
                height="450"></video></a>
        <div class="ubicacion">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d496.6992947033847!2d-80.66078118048307!3d-5.168765337361663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x904a1b813a27393f%3A0x2ec49b2e5608ff02!2sRest%20CEVICHERIA%20luigys!5e0!3m2!1ses-419!2spe!4v1727167590610!5m2!1ses-419!2spe"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <script src="/restaurante_Cevicheria/js/drop.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
    </body>
  </html>