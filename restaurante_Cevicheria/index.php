<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<?php

require('database/conexion.php');

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
    <title>RestCevicheria Luigy's</title>
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

    <div class="inic-video">
        <video src="/restaurante_Cevicheria/videos/Video-cabezera.mp4" autoplay loop></video>
    </div>

    <div class="seccion-1">
        <div class="separador-4"></div>
        <h2>IS A PARTY!</h2>
        <br>
        <p>
            Sabores del Mar es una fiesta de la frescura y el sabor peruano.
            Es un homenaje a nuestras costas, donde el ceviche y los frutos
            del mar son protagonistas de una propuesta que honra lo mejor
            de nuestra tradición gastronómica.
        </p>
        <div class="awa">

        </div>

    </div>
    
    <div class="seccion-2">
        <h1>RestCevicheria Luigy's</h1>
        <div class="cards-container">
            
    <div class="card pilares">
        <a href="/restaurante_Cevicheria/Principal_usuario/nosotros/index.php" alt="Leer-mas">
            <img src="Images/carta.jpg" alt="Pilares" style="color: black">
        <div class="card-content">
            <h3 class="card-title" style="color: white">PILARES</h3>
            <div class="card-text" >
                <p style="color: white">Nuestro restaurante presenta como principales pilares:</p>
                <p style="color: white">
                    Compromiso<br>
                    Servicio<br>
                    Calidad<br>
                    Variedad
                </p>
                <p style="color: white">Los cuales nos llevaron a alcanzar el crecimiento.</p>
            </div>
        </div>
        </a>  
    </div>

    <div class="card historia">
        <a href="/restaurante_Cevicheria/Principal_usuario/nosotros/index.php" alt="Leer-mas">
            <img src="Images/Fotogragia.jpeg" alt="Historia">
        <div class="card-content">
            <h3 class="card-title" style="color: white">HISTORIA</h3>
            <div class="card-text">
                <p style="color: white">En medio de la pandemia, cuando muchos enfrentaban la incertidumbre y la falta de trabajo, nuestra 
                familia decidió unir fuerzas y dar vida a un sueño compartido: una cevichería que llevara los 
                auténticos sabores del mar a nuestra comunidad. Lo que comenzó como una idea para superar tiempos 
                difíciles se transformó en una pasión por la gastronomía y el servicio.</p>
            </div>
        </div>
         </a>
    </div>

    <div class="card experiencia">
        <a href="/restaurante_Cevicheria/Principal_usuario/nosotros/index.php" alt="Leer-mas">
            <img src="Images/experiencia-logo.jpeg" alt="Experiencia">
            <div class="card-content">
                <h3 class="card-title" style="color: white">EXPERIENCIAS DE CLIENTES</h3>
                <div class="card-text">
                    <p style="color: white">Contamos con personal altamente calificado en la preparacion de comidas criollas y marinas.</p>
                </div>
            </div>
            </a> 
        </div>

    </div>
    </div>


        <div class="seccion-3">
            <div class="separador-1"></div>
            <h2>MENÚ</h2>
                <br>
                    <p>Nuestro compromiso es ofrecer platillos deliciosos de pescados y mariscos,
                        preparados bajo estrictos controles de calidad.
                    </p>

                    <div class="a">
                        <a href="/restaurante_Cevicheria/Principal_usuario/menu/index.php"><img src="/restaurante_Cevicheria/Images/comida.png" alt="ronda"></a>
                    </div>
        </div>


    <div class="seccion-4">
        <h2>RESEÑAS</h2>

        <div class="reseñas_contenedor">
            <a href="https://www.google.com.pe/maps/place/Rest+CEVICHERIA+luigys/@-5.1686779,-80.6632394,17z/data=!4m8!3m7!1s0x904a1b813a27393f:0x2ec49b2e5608ff02!8m2!3d-5.1686832!4d-80.6606645!9m1!1b1!16s%2Fg%2F11q383_qmm?hl=es-419&entry=ttu&g_ep=EgoyMDI0MTAyOS4wIKXMDSoASAFQAw%3D%3D"
                target="_blank" class="tarjeta-link">
                <div class="reseña_bloque">
                    <h3>Leydi Laura Zapata Coloma</h3>
                    <p>La comida super rica, los precios accesibles, el hambiente moderado.</p>
                </div>
            </a>
            <a href="https://www.google.com.pe/maps/place/Rest+CEVICHERIA+luigys/@-5.1686779,-80.6632394,17z/data=!4m8!3m7!1s0x904a1b813a27393f:0x2ec49b2e5608ff02!8m2!3d-5.1686832!4d-80.6606645!9m1!1b1!16s%2Fg%2F11q383_qmm?hl=es-419&entry=ttu&g_ep=EgoyMDI0MTAyOS4wIKXMDSoASAFQAw%3D%3D"
                target="_blank" class="tarjeta-link">
                <div class="reseña_bloque">
                    <h3>Maria Del Milagro Sialer Serrano</h3>
                    <p>Muy rico y natural.</p>
                </div>
            </a>

            <a href="https://www.google.com.pe/maps/place/Rest+CEVICHERIA+luigys/@-5.1686779,-80.6632394,17z/data=!4m8!3m7!1s0x904a1b813a27393f:0x2ec49b2e5608ff02!8m2!3d-5.1686832!4d-80.6606645!9m1!1b1!16s%2Fg%2F11q383_qmm?hl=es-419&entry=ttu&g_ep=EgoyMDI0MTAyOS4wIKXMDSoASAFQAw%3D%3D"
                target="_blank" class="tarjeta-link">
                <div class="reseña_bloque">
                    <h3>Mego</h3>
                    <p>Muy rica la. Comida recomendado.</p>
                </div>
            </a>

        </div>
        <a href="/restaurante_Cevicheria/Principal_usuario/resenas/index.html"></a>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section locations">
                <h3>VISITANOS EN:</h3>
                <ul>
                    <li>Piura - 20001 26 de octubre, 20001
                        (1 etapa del condominio santa margarita)
                    </li>
                </ul>
            </div>

            <div class="footer-section reservations">
                <h3>DATOS DE CONTACTO</h3>
                <p><a href="https://wa.me/51952308626" target="_blank" style="color:black">- +51 952308626</a></p>
                <p><a href="https://mail.google.com/mail/?view=cm&to=Luigy14851@gmail.com" target="_blank" style="color:black">- Luigy14851@gmail.com</a></p>
            
                <h3>SÍGUENOS EN:</h3>

            <div class="social-icons">
                    <a href="https://www.facebook.com/restcevicheria.luigys" target="_blank">
                        <img src="/restaurante_Cevicheria/Images/facebook.png"></a>

                    <a href="https://www.instagram.com/rest.cevicherialuigys/" target="_blank">
                        <img src="/restaurante_Cevicheria/Images/instagram.png"></a>

                    <a href="https://www.tiktok.com/@cevicheria_luigys" target="_blank">
                        <img src="/restaurante_Cevicheria/Images/tik-tok.png"></a>
                </div>
            
            </div>
            




            <div class="footer-section contact-info">
                <h3>LIBRO DE RECLAMACIONES</h3>
                <a href="/restaurante_Cevicheria/Principal_usuario/reclamos/index.php" target="_blank">
                    <img src="/restaurante_Cevicheria/Images/LIBRO-RECLAMACIONES-negro.png" alt=""
                        class="info-libro-reclamaciones" ></a>

            </div>

            <div class="footer-section links">
                <ul>
                    <li><a href="/restaurante_Cevicheria/Principal_usuario/nosotros/index.php">Nosotros</a></li>
                    <li><a href="/restaurante_Cevicheria/Principal_usuario/menu/index.php">Menu</a></li>
                    <li><a
                            href="https://www.gob.pe/institucion/indecopi/campa%C3%B1as/65149-libro-de-reclamaciones-todo-lo-que-debe-saber-antes-de-solicitarlo">Política
                            de privacidad</a>
                    </li>
                    <li><a href="/restaurante_Cevicheria/Principal_usuario/contactanos/index.php" target="_blank">contactanos</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="/restaurante_Cevicheria/js/drop.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>

</body>
</html>