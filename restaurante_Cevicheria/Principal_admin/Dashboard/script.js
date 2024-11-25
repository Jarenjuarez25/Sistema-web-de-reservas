document.addEventListener('DOMContentLoaded', function () {
    const fechaInicioInput = document.getElementById('fechaInicio');
    const fechaFinInput = document.getElementById('fechaFin');
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const deleteFiltersBtn = document.getElementById('deleteFiltros1');

    let usuariosChart, reservasChart, reclamosChart, distribucionChart;

    // Función para inicializar los gráficos
    function initCharts() {
        usuariosChart = new Chart(document.getElementById('usuariosChart').getContext('2d'), {
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

        reservasChart = new Chart(document.getElementById('reservasChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: reservasData.map(entry => entry.fecha),
                datasets: [{
                    label: 'Reservas por día',
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

        reclamosChart = new Chart(document.getElementById('reclamosChart').getContext('2d'), {
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

        distribucionChart = new Chart(document.getElementById('distribucionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: distribucionData.map(entry => entry.genero),
                datasets: [{
                    label: 'Distribución por género',
                    data: distribucionData.map(entry => entry.cantidad),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
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
    }

    // Función para actualizar un gráfico
    function updateChart(chart, data, labelKey, valueKey) {
        chart.data.labels = data.map(item => item[labelKey]);
        chart.data.datasets[0].data = data.map(item => item[valueKey]);
        chart.update();
    }

    // Función para filtrar datos por rango de fechas
    function filterDataByDate(data, startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        return data.filter(item => {
            const date = new Date(item.fecha);
            return date >= start && date <= end;
        });
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

        // Actualizar gráficos
        updateChart(usuariosChart, usuariosFiltrados, 'fecha', 'cantidad');
        updateChart(reservasChart, reservasFiltradas, 'fecha', 'cantidad');
    }

    // Función para borrar filtros
    function clearFilters() {
        fechaInicioInput.value = '';
        fechaFinInput.value = '';

        // Restaurar gráficos con datos originales
        updateChart(usuariosChart, usuariosData, 'fecha', 'cantidad');
        updateChart(reservasChart, reservasData, 'fecha', 'cantidad');
    }

    // Vincular eventos
    applyFilterBtn.addEventListener('click', applyFilters);
    deleteFiltersBtn.addEventListener('click', clearFilters);

    // Inicializar gráficos
    initCharts();


});

document.getElementById('printTablesPdfBtn').addEventListener('click', function() {
        window.location.href = 'generate_report.php';
});
