<?php
require_once '../../library/tcpdf/tcpdf.php';
require_once '../../database/conexion.php';
$conexion = new Conexion();



// Obtener datos de usuarios, productos, ventas, reclamos, ingresos mensuales, retención de clientes, análisis de cohorte y satisfacción del cliente
$usuarios = $conexion->getUsuariosData();
$reclamos = $conexion->getReclamosData();
$reservas = $conexion->getReservas();
$distribucion = $conexion -> getdistribucionData();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/restaurante_Cevicheria/Images/Logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div id="loaderPagina" class="section_loader">
        <div class="loader">
                <div class="loader_1"></div>
                <div class="loader_2"></div>
        </div>
    </div>

<button class="boton1-salir" onclick="location.href='/restaurante_Cevicheria/Principal_admin/index.php'">SALIR</button>

   <nav class="menu">
      <section class="menu_contenedor">
         <h1 class="menu_logo"> Panel administrativo - RestCevicheria Luigy's</h1>
      </section>
   </nav>

    <div class="container">
        <div class="control-section">
        <div class="filter-section">
    <label>Desde:</label>
    <input type="date" id="fechaInicio">
    <label>Hasta:</label>
    <input type="date" id="fechaFin">
    <button id="applyFilterBtn">Aplicar filtro</button>
    <button id="deleteFiltros1">Borrar filtros</button>
</div>
            

            <div class="selection-section">
                <label for="chartSelection">Seleccione el gráfico:</label>
                <select id="chartSelection">
                    <option value="usuariosChart">Registro de usuarios</option>
                    <option value="distribucionChart">Distribución de usuarios por género</option>
                    <option value="reservasChart">Registro de reservas</option>
                    <option value="reclamosChart">Reclamos por tipo</option>
                </select>
            </div>
            <button id="printPdfBtn"><i class="fas fa-file-pdf"></i> Imprimir Graficos</button>
            <button id="printTablesPdfBtn"><i class="fas fa-file-pdf"></i> Imprimir Tablas</button>
        </div>

        <div class="charts-section">
            <div class="chart-container" id="usuariosChartContainer">
                <h2>Registro de suarios</h2>
                <canvas id="usuariosChart"></canvas>
            </div>

            <div class="chart-container" id="distribucionChartContainer">
                <h2>Distribución de usuarios por género</h2>
                <canvas id="distribucionChart"></canvas>
            </div>


            <div class="chart-container" id="reservasChartContainer">
                <h2>Registro de reservas</h2>
                <canvas id="reservasChart"></canvas>
            </div>

            <div class="chart-container" id="reclamosChartContainer">
                <h2>Reclamos por tipo</h2>
                <canvas id="reclamosChart"></canvas>
            </div>

        </div>
    </div>

    <script>
        const usuariosData = <?php echo json_encode($usuarios); ?>;
        const reclamosData = <?php echo json_encode($reclamos); ?>;
        const reservasData = <?php echo json_encode($reservas); ?>;
        const distribucionData = <?php echo json_encode($distribucion); ?>;
    </script>
    <script src="script.js"></script>
    <script src="/restaurante_Cevicheria/js/loader.js"></script>
</body>
</html>