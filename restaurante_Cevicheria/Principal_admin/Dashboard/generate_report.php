<?php
require_once '../../library/tcpdf/tcpdf.php';
require_once '../../database/conexion.php';

$conexion = new Conexion();

// Obtener datos de la base de datos
$usuarios = $conexion->getUsuariosData();
$reclamos = $conexion->getReclamosData();
$reservas = $conexion->getReservas();
$distribucion = $conexion -> getdistribucionData();
$perdidas = $conexion -> getperdidasData();


// Crear nuevo documento PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Autor');
$pdf->SetTitle('Dashboard PDF');
$pdf->SetSubject('Dashboard PDF');
$pdf->SetKeywords('TCPDF, PDF, dashboard');

// Configuración de las cabeceras y pies de página
$pdf->setHeaderData('', 0, 'Reporte Tablas');
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// Establecer fuentes
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Establecer márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Establecer saltos de página automáticos
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Establecer escala de imágenes
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Añadir una página
$pdf->AddPage();

// Título del documento
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 15, 'Reporte', 0, 1, 'C', 0, '', 0, false, 'M', 'M');

// Función para generar una tabla en el PDF
function generarTabla($pdf, $titulo, $datos, $columnas) {
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, $titulo, 0, 1);
    
    $pdf->SetFont('helvetica', 'B', 12);
    foreach ($columnas as $columna) {
        $pdf->Cell(95, 10, $columna, 1, 0, 'C');
    }
    $pdf->Ln();
    
    $pdf->SetFont('helvetica', '', 12);
    foreach ($datos as $fila) {
        foreach ($fila as $celda) {
            $pdf->Cell(95, 10, $celda, 1, 0, 'C');
        }
        $pdf->Ln();
    }
}

// Datos de usuarios
generarTabla($pdf, 'Usuarios registrados por Día', $usuarios, ['Fecha', 'Cantidad']);

// Datos de ventas
generarTabla($pdf, 'Reservas por dia', $reservas, ['Fecha', 'Cantidad']);

// Datos de reclamos
generarTabla($pdf, 'Registro de ganancias de reservas', $distribucion, ['Fecha', 'Cantidad']);

generarTabla($pdf, 'Pedidas por cancelacion', $perdidas, ['Fecha', 'Cantidad']);

// Datos de productos
generarTabla($pdf, 'Reclamos por dia', $reclamos, ['Tipo', 'Cantidad']);

$pdf ->Output('Reporte.pdf', 'D');

// Cerrar la conexión
$conexion = null;
?>
