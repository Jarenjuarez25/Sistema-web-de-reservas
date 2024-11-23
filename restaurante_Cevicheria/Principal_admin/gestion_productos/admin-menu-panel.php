<?php
require_once(__DIR__ . '../../../database/conexion.php');
require_once(__DIR__ . '../../../controller/ProductController.php');

$con = new Conexion();
$productController = new ProductController($con->getConexion());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
            case 'update':
                $data = [
                    'nombre' => $_POST['nombre'],
                    'descripcion' => $_POST['descripcion'],
                    'precio_personal' => $_POST['precio_personal'],
                    'precio_mediano' => $_POST['precio_mediano'],
                    'precio_familiar' => $_POST['precio_familiar'],
                    'categoria' => $_POST['categoria'],
                    'imagen' => ''
                ];

                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                    $uploadDir = __DIR__ . '/../../uploads/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileExtension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    $fileName = uniqid() . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                        $data['imagen'] = $fileName;
                    }
                }

                if ($_POST['action'] === 'add') {
                    $productController->addProduct($data);
                } else {
                    $productController->updateProduct($_POST['id'], $data);
                }
                break;

            case 'delete':
                $productController->deleteProduct($_POST['id']);
                break;
        }
    }
}

$products = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
   <meta name="viewport" content="width = device-width, initial-scale=1.0">
   <title>Gestionar Productos</title>
   <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style_tabla.css">
    <link rel="stylesheet" href="/restaurante_Cevicheria/css/style_admin.css" />
</head>
<body> 

    <div id="loaderPagina" class="section_loader">
        <div class="loader">
                <div class="loader_1"></div>
                <div class="loader_2"></div>
        </div>
    </div>

<button class="boton-salir" onclick="location.href='/restaurante_Cevicheria/Principal_admin/index.php'">SALIR</button>
<nav class="menu">
      <section class="menu_contenedor">
         <h1 class="menu_logo"> Panel administrativo - RestCevicheria Luigy's</h1>
      </section>
   </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Agregar Producto</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="precio_personal">Precio Personal:</label>
                        <input type="number" id="precio_personal" name="precio_personal" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="precio_mediano">Precio Mediano:</label>
                        <input type="number" id="precio_mediano" name="precio_mediano" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="precio_familiar">Precio Familiar:</label>
                        <input type="number" id="precio_familiar" name="precio_familiar" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="categoria">Categoría:</label>
                        <select id="categoria" name="categoria" class="form-control" required>
                            <option value="Ceviche">Ceviche</option>
                            <option value="Chicharrones y Jaleas">Chicharrones y Jaleas</option>
                            <option value="Mariscos">Mariscos</option>
                            <option value="Parihuelas, sudados pasados y encebollados">Parihuelas, sudados pasados y encebollados</option>
                            <option value="Las leches del chef">Las leches del chef</option>
                            <option value="Especiales de la casa">Especiales de la casa</option>
                            <option value="Festival de TACU TACU">Festival de TACU TACU</option>
                            <option value="Criollos">Criollos</option>
                            <option value="Sabado, Domingo y Feriados">Sabado, Domingo y Feriados</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="imagen">Imagen:</label>
                        <input type="file" id="imagen" name="imagen" class="form-control-file" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-custom">Agregar Producto</button>
                </form>
            </div>

            <div class="col-md-5">
                <h2>Productos Existentes</h2>
                <table class="table table-custom table-striped table-bordered table-fixed">
                    <thead>
                        <tr style="width: 680px">
                            <th style="width: 100px">Nombre</th>
                            <th style="width: 120px">Descripcion</th>
                            <th style="width: 108px">Categoría</th>
                            <th style="width: 190px">Precios</th>
                            <th style="width: 200px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr style="width: 680px">
                                <td style="width: 100px"><?php echo htmlspecialchars($product['nombre']); ?></td>
                                <td style="width: 120px"><?php echo htmlspecialchars($product['descripcion']); ?></td>
                                <td style="width: 108px"><?php echo htmlspecialchars($product['categoria']); ?></td>
                                <td style="width: 190px">
                                    <?php
                                    $precios = array_filter([
                                        $product['precio_personal'] ? "P: S/{$product['precio_personal']}" : null,
                                        $product['precio_mediano'] ? "M: S/{$product['precio_mediano']}" : null,
                                        $product['precio_familiar'] ? "F: S/{$product['precio_familiar']}" : null
                                    ]);
                                    echo implode(' / ', $precios);
                                    ?>
                                </td>
                                <td style="width: 200px">
                                    <button class="btn btn-custom btn-sm" onclick="fillEditForm(<?php echo htmlspecialchars(json_encode($product)); ?>);return false;">
                                        Editar
                                    </button>
                                    <form action="" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                        <button type="submit" class="btn btn-custom btn-sm" onclick="return confirm('¿Está seguro de eliminar este producto?');return false;">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" id="editForm" style="display: none;">
            <div class="col-md-6 offset-md-3 tableactu">
                <h2>Editar Producto</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit-id">
                    
                    <div class="form-group">
                        <label for="edit-nombre">Nombre:</label>
                        <input type="text" id="edit-nombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-descripcion">Descripción:</label>
                        <textarea id="edit-descripcion" name="descripcion" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit-precio_personal">Precio Personal:</label>
                        <input type="number" id="edit-precio_personal" name="precio_personal" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="edit-precio_mediano">Precio Mediano:</label>
                        <input type="number" id="edit-precio_mediano" name="precio_mediano" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="edit-precio_familiar">Precio Familiar:</label>
                        <input type="number" id="edit-precio_familiar" name="precio_familiar" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="edit-categoria">Categoría:</label>
                        <select id="edit-categoria" name="categoria" class="form-control" required>
                            <option value="Ceviche">Ceviche</option>
                            <option value="Chicharrones y Jaleas">Chicharrones y Jaleas</option>
                            <option value="Mariscos">Mariscos</option>
                            <option value="Mariscos">Mariscos</option>
                            <option value="Parihuelas, sudados pasados y encebollados">Parihuelas, sudados pasados y encebollados</option>
                            <option value="Las leches del chef">Las leches del chef</option>
                            <option value="Especiales de la casa">Especiales de la casa</option>
                            <option value="Festival de TACU TACU">Festival de TACU TACU</option>
                            <option value="Criollos">Criollos</option>
                            <option value="Sabado, Domingo y Feriados">Sabado, Domingo y Feriados</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit-imagen">Imagen:</label>
                        <input type="file" id="edit-imagen" name="imagen" class="form-control-file" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-custom">Actualizar Producto</button>
                </form>
            </div>
        </div>
    </div>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
    <script>
        function fillEditForm(product) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('edit-id').value = product.id;
            document.getElementById('edit-nombre').value = product.nombre;
            document.getElementById('edit-descripcion').value = product.descripcion;
            document.getElementById('edit-precio_personal').value = product.precio_personal;
            document.getElementById('edit-precio_mediano').value = product.precio_mediano;
            document.getElementById('edit-precio_familiar').value = product.precio_familiar;
            document.getElementById('edit-categoria').value = product.categoria;
        }
    </script>
</body>
</html>