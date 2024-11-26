<?php 
require_once '../../database/conexion.php';
$con = new Conexion();

// Obtén la conexión usando el método getConexion()
$mysqli = $con->getConexion();

// Realiza la consulta utilizando la conexión correcta
$query = mysqli_query($mysqli, "SELECT * FROM tbusuario WHERE cargo_id = 2");

if (!$query) {
    echo "Error en la consulta: " . mysqli_error($mysqli);
}
$admin = $con->Mostrar_Usuarios(1);
$cliente = $con->Mostrar_Usuarios(2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width = device-width, initial-scale=1.0">
   <title>Administrar usuarios</title>
   <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style_admin.css" />
</head>
<body>
<button class="boton-salir" onclick="location.href='/restaurante_Cevicheria/Principal_admin/index.php'">SALIR</button>
<nav class="menu">
    
    <div id="loaderPagina" class="section_loader">
        <div class="loader">
                <div class="loader_1"></div>
                <div class="loader_2"></div>
        </div>
    </div>

      <section class="menu_contenedor">
         <h1 class="menu_logo"> Panel administrativo - RestCevicheria Luigy's</h1>
      </section>
   </nav>

<div class="container mt-5">
    <h1 class="titel">Gestión de Usuarios</h1>
    <table class="table table-fixed">
        <thead class="table table-hover ">
            <tr style="width: 680px">
                <th style="width: 80px">ID</th>
                <th style="width: 150px">DNI</th>
                <th style="width: 230px">Nombres</th>
                <th style="width: 210px">Apellidos</th>
                <th style="width: 320px">Email</th>
                <th style="width: 100px">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <tr>     
                    <td style="width: 80px"><?php echo ($row['id']); ?></td>
                    <td style="width: 150px"><?php echo ($row['dni']); ?></td>
                    <td style="width: 230px"><?php echo ($row['nombre']); ?></td>
                    <td style="width: 210px"><?php echo ($row['apellidos']); ?></td>
                    <td style="width: 320px"><?php echo ($row['correo']); ?></td>
                    <td style="width: 100px">
                        <a href="actualizar.php?id=<?php echo ($row['id']); ?>" class="btn btn-primary">Editar</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<h1 class="titel2">Gestión de Roles</h1>

<div class="main-container">
        <h2>Tabla de Administradores</h2>
        <table class="table table-fixed2">
            <thead class="table table-hover">
                <tr style="width: 680px">
                    <th style="width: 100px">ID</th>
                    <th style="width: 230px">Usuario</th>
                    <th style="width: 350px">Correo</th>
                    <th style="width: 210px">Rol</th>
                    <th style="width: 220px">Estado</th>
                    <th style="width: 300px">Dar Rol</th>
                </tr>
            </thead>   
            <tbody>
                <?php foreach($admin as $usuario) { ?>
                    <tr>
                        <td style="width: 100px"><?php echo $usuario['id']; ?></td>
                        <td style="width: 230px"><?php echo $usuario['nombre']; ?></td>
                        <td style="width: 360px"><?php echo $usuario['correo']; ?></td>
                        <td style="width: 200px">
                            <?php 
                                if ($usuario['cargo_id'] == 1) {
                                    echo "Admin";
                                } elseif ($usuario['cargo_id'] == 2) {
                                    echo "Cliente";
                                } else {
                                    echo "Desconocido";
                                }
                            ?>
                        </td>
                        <td style="width: 160px"><?php echo $usuario['estado']; ?></td>
                        <td style="width: 300px">
                        <?php if ($usuario['verificado'] == '1') { ?>
                                <a href="/restaurante_Cevicheria/controller/desactivar.php?id=<?=$usuario['id']?>" class="btn btn-warning">Quitar verificado</a>
                            <?php } else { ?>
                                <a href="/restaurante_Cevicheria/controller/activar.php?id=<?=$usuario['id']?>" class="btn btn-success">Verificar</a>
                            <?php } ?>
                            <a href="/restaurante_Cevicheria/controller/cambiar_rol.php?id=<?=$usuario['id']?>&rol=<?=$usuario['cargo_id']?>" class="btn btn-primary">
                                <?php echo ($usuario['cargo_id'] == 1) ? 'Quitar Admin' : 'Hacer Admin'; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
                            
        <h2 class="titel3">Tabla de Clientes</i></h2>
        <table class="table table-fixed3">
            <thead class="table table-hover">
                <tr style="width: 680px">
                    <th style="width: 100px">ID</th>
                    <th style="width: 230px">Usuario</th>
                    <th style="width: 360px">Correo</th>
                    <th style="width: 150px">Rol</th>
                    <th style="width: 150px">Estado</th>
                    <th style="width: 300px">Dar rol</th>
                </tr>
            </thead>   
            <tbody>
                <?php foreach($cliente as $usuario) { ?>
                    <tr>
                        <td style="width: 100px"><?php echo $usuario['id']; ?></td>
                        <td style="width: 230px"><?php echo $usuario['nombre']; ?></td>
                        <td style="width: 360px"><?php echo $usuario['correo']; ?></td>
                        <td style="width: 150px">
                            <?php 
                                if ($usuario['cargo_id'] == 1) {
                                    echo "Admin";
                                } elseif ($usuario['cargo_id'] == 2) {
                                    echo "Cliente";
                                } else {
                                    echo "Desconocido";
                                }
                            ?>
                        </td>
                        <td style="width: 150px"><?php echo $usuario['estado']; ?></td>
                        <td style="width: 300px">
                        <?php if ($usuario['verificado'] == '1') { ?>
                                <a href="/restaurante_Cevicheria/controller/desactivar.php?id=<?=$usuario['id']?>" class="btn btn-warning">Quitar verificado</a>
                            <?php } else { ?>
                                <a href="/restaurante_Cevicheria/controller/activar.php?id=<?=$usuario['id']?>" class="btn btn-success">Verificar</a>
                            <?php } ?>
                            <a href="/restaurante_Cevicheria/controller/cambiar_rol.php?id=<?=$usuario['id']?>&rol=<?=$usuario['cargo_id']?>" class="btn btn-primary">
                                <?php echo ($usuario['cargo_id'] == 1) ? 'Quitar Admin' : 'Hacer Admin'; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>
