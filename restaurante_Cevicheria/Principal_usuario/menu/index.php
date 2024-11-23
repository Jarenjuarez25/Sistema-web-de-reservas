<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<?php

require_once('../../database/conexion.php');
require_once __DIR__ . '/../../controller/ProductController.php';


$con = new Conexion();
$productController = new ProductController($con->getConexion());

$nombre = ''; // Inicializa $nombre con un valor predeterminado
//var_dump($_SESSION);
//exit("1");
if (isset($_SESSION['user_id'])) {
    $nombre = $con->getNombreByUserId($_SESSION['user_id']);
    //var_dump($nombre);
    //exit("");

    $busqueda = isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '';
    $categoria_filtro = isset($_GET['categoria']) ? htmlspecialchars($_GET['categoria']) : '';
    $orden = isset($_GET['orden']) ? htmlspecialchars($_GET['orden']) : '';

}


$ceviches = $productController->getProductsByCategory('Ceviche');
$chicharrones = $productController->getProductsByCategory('Chicharrones y Jaleas');
$mariscos = $productController->getProductsByCategory('Mariscos');
$parihuelas = $productController->getProductsByCategory('Parihuelas, sudados pasados y encebollados');
$lasleches = $productController->getProductsByCategory('Las leches del chef');
$especiales = $productController->getProductsByCategory('Especiales de la casa');
$festival = $productController->getProductsByCategory('Festival de TACU TACU');
$criollos = $productController->getProductsByCategory('Criollos');
$sabado = $productController->getProductsByCategory('Sabado, Domingo y Feriados');

// Si hay una búsqueda activa
if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];

    echo '<div style="text-align: center; margin: 20px;">
            <a href="' . $_SERVER['PHP_SELF'] . '" class="btn-limpiar">Limpiar Filtro</a>
          </div>';

    // Realiza la consulta de búsqueda
    $stmt = $con->getConexion()->prepare("SELECT * FROM tbproductos WHERE nombre LIKE ?");
    $param = "%$busqueda%";
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $consulta = $stmt->get_result();


    echo '<div class="menu-grid2">';

    if ($consulta->num_rows > 0) {
        while ($row = $consulta->fetch_array()) {
            echo '<div class="menu-item">';
            echo '<img src="/restaurante_Cevicheria/uploads/' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '" class="icono">';
            echo '<label class="nombre"><span style="font-size: 20px;color: black;">' . htmlspecialchars($row['nombre']) . '</span></label>';

            if (!empty($row['descripcion'])) {
                echo '<p class="descripcion" style="margin-top: 2px;">' . htmlspecialchars($row['descripcion']) . '</p>';
            }

            $precios = array_filter([
                $row['precio_personal'] ? "S/{$row['precio_personal']}" : null,
                $row['precio_mediano'] ? "S/{$row['precio_mediano']}" : null,
                $row['precio_familiar'] ? "S/{$row['precio_familiar']}" : null
            ]);
            echo '<p class="precio">' . implode(' - ', $precios) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p class="p-nobus">No se encontraron resultados.</p>';
    }

    echo '</div>';
} else {
    echo '<p style="text-align: center; width: 100%;">No se encontraron resultados.</p>';
    echo '</div>';
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Menú</title>
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
        style=" padding-left: 20px;"
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
                
                <div class="search-box">
                <form id="search-form" method="GET">
                    <img src="/restaurante_Cevicheria/Images/lupa.png" style="height: 30px;width: 30px;margin-top: 5px;margin-left: 1px;">
                    <i class='bx bx-search'></i>
                    <div class="input-box">
                        <input type="text" name="busqueda" placeholder="Buscar producto..." required>
                    </div>

                </form>
            </div>
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
    
    <h1 class="h1_0">Ceviche</h1>
    <div class="menu-grid">
        <?php if (empty($ceviches)): ?>
            <p class="no-productos">No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($ceviches as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 2px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h1 class="h1_1">Chicharrones Y Jaleas</h1>
    <div class="menu-grid">
        <?php if (empty($chicharrones)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($chicharrones as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 19px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h1 class="h1_2">Mariscos</h1>
    <div class="menu-grid">
        <?php if (empty($mariscos)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($mariscos as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 19px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h1 class="h1_3">Parihuelas, sudados pasados y encebollados</h1>
    <div class="menu-grid">
        <?php if (empty($parihuelas)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($parihuelas as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 19px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h1 class="h1_4">Las leches del chef</h1>
    <div class="menu-grid">
        <?php if (empty($lasleches)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($lasleches as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 19px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h1 class="h1_5">Especiales de la casa</h1>
    <div class="menu-grid">
        <?php if (empty($especiales)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($especiales as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>

                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="letter-spacing: 0px;margin-top: 3px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: -4px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h1 class="h1_7">Festival de TACU TACU</h1>
    <div class="menu-grid">
        <?php if (empty($festival)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($festival as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 2px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h1 class="h1_8">Criollos</h1>
    <div class="menu-grid">
        <?php if (empty($criollos)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($criollos as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 19px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <h1 class="h1_9">Sabado, Domingo y Feriados</h1>
    <div class="menu-grid">
        <?php if (empty($sabado)): ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php else: ?>
            <?php foreach ($sabado as $producto): ?>
                <div class="menu-item">
                    <img src="/restaurante_Cevicheria/uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>" 
                         class="icono">
                    <label class="nombre">
                        <span style="font-size: 20px;color: black;"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                    </label>
                    <?php if (!empty($producto['descripcion'])): ?>
                        <p class="descripcion" style="margin-top: 19px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <?php endif; ?>
                    <p class="precio" style="margin-top: 5px;">
                        <?php
                        $precios = array_filter([
                            $producto['precio_personal'] ? "S/{$producto['precio_personal']}" : null,
                            $producto['precio_mediano'] ? "S/{$producto['precio_mediano']}" : null,
                            $producto['precio_familiar'] ? "S/{$producto['precio_familiar']}" : null
                        ]);
                        echo implode(' - ', $precios);
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script src="/restaurante_Cevicheria/js/drop.js"></script>
    <script src="search.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>