document.addEventListener('DOMContentLoaded', function () {
    const usuariosCtx = document.getElementById('usuariosChart').getContext('2d');
    const reclamosCtx = document.getElementById('reclamosChart').getContext('2d');
    const reservasCtx = document.getElementById('reservasChart').getContext('2d');
    const distribucionCtx = document.getElementById('distribucionChart').getContext('2d');
    const fechaInicioInput = document.getElementById('fechaInicio');
    const fechaFinInput = document.getElementById('fechaFin');
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const deleteFiltersBtn = document.getElementById('deleteFiltros1');
    
    const usuariosChart = new Chart(usuariosCtx, {
        type: 'bar',
        data: {
            labels: usuariosData.map(entry => entry.fecha),
            datasets: [{
                label: 'Usuarios registrados',
                data: usuariosData.map(entry => entry.cantidad),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const reclamosChart = new Chart(reclamosCtx, {
        type: 'bar',
        data: {
            labels: reclamosData.map(entry => entry.tipo),
            datasets: [{
                label: 'Reclamos por tipo',
                data: reclamosData.map(entry => entry.cantidad),
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const reservasChart = new Chart(reservasCtx, {
        type: 'bar',
        data: {
            labels: reservasData.map(entry => entry.fecha),
            datasets: [{
                label: 'Reservas Por dia',
                data: reservasData.map(entry => entry.cantidad),
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const distribucionChart = new Chart(distribucionCtx, {
        type: 'bar',
        data: {
            labels: distribucionData.map(entry => entry.genero),
            datasets: [{
                label: 'Distribución de usuarios por género',
                data: distribucionData.map(entry => entry.cantidad),
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Función para filtrar datos por rango de fechas
    function filterDataByDate(data, startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        return data.filter(item => {
            const date = new Date(item.fecha);
            return date >= start && date <= end;
        });
    }

    // Función para actualizar un gráfico
    function updateChart(chart, newData, labelKey, valueKey) {
        chart.data.labels = newData.map(item => item[labelKey]);
        chart.data.datasets[0].data = newData.map(item => item[valueKey]);
        chart.update();
    }

    // Función para aplicar filtros
    function applyFilters() {
        const fechaInicio = fechaInicioInput.value;
        const fechaFin = fechaFinInput.value;

        if (!fechaInicio || !fechaFin) {
            alert('Por favor, selecciona ambas fechas.');
            return;
        }

        // Filtrar datos
        const usuariosFiltrados = filterDataByDate(usuariosData, fechaInicio, fechaFin);
        const reservasFiltradas = filterDataByDate(reservasData, fechaInicio, fechaFin);
        const reclamosFiltrados = filterDataByDate(reclamosData, fechaInicio, fechaFin);

        // Actualizar gráficos
        updateChart(usuariosChart, usuariosFiltrados, 'fecha', 'cantidad');
        updateChart(reservasChart, reservasFiltradas, 'fecha', 'cantidad');
        updateChart(reclamosChart, reclamosFiltrados, 'tipo', 'cantidad');
    }

    // Función para borrar filtros
    function clearFilters() {
        fechaInicioInput.value = '';
        fechaFinInput.value = '';

        // Restaurar gráficos con datos originales
        updateChart(usuariosChart, usuariosData, 'fecha', 'cantidad');
        updateChart(reservasChart, reservasData, 'fecha', 'cantidad');
        updateChart(reclamosChart, reclamosData, 'tipo', 'cantidad');
    }

    // Event listeners para los botones de filtro
    applyFilterBtn.addEventListener('click', applyFilters);
    deleteFiltersBtn.addEventListener('click', clearFilters);

    function filterDataByDate(data, days) {
        const now = new Date();
        return data.filter(entry => {
            const entryDate = new Date(entry.fecha);
            const diffTime = Math.abs(now - entryDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays <= days;
        });
    }

    chartSelection.addEventListener('change', function() {
        const selectedChart = chartSelection.value;
        document.querySelectorAll('.chart-container').forEach(container => {
            container.style.display = container.querySelector('canvas').id === selectedChart ? 'block' : 'none';
        });
    });

    document.getElementById('printPdfBtn').addEventListener('click', function() {
        const selectedChart = document.getElementById('chartSelection').value;
        const chartCanvas = document.getElementById(selectedChart);
    
        if (chartCanvas) {
            const imgData = chartCanvas.toDataURL('image/png');
            const imgWidth = 190;
            const imgHeight = chartCanvas.height * imgWidth / chartCanvas.width;
    
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();
    
            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
            pdf.save('ReporteGraficos.pdf');
        } else {
            console.error('No se encontró el lienzo seleccionado.');
        }
    });

    document.getElementById('printTablesPdfBtn').addEventListener('click', function() {
        window.location.href = 'generate_report.php';
    });
});