document.addEventListener('DOMContentLoaded', function () {
    const fechaInicioInput = document.getElementById('fechaInicio');
    const fechaFinInput = document.getElementById('fechaFin');
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const deleteFiltersBtn = document.getElementById('deleteFiltros1');

    let usuariosChart, reservasChart, reclamosChart, distribucionChart, perdidasChart;

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
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad' // Etiqueta del eje Y
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha' // Etiqueta del eje X
                        }
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
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad' // Etiqueta del eje Y
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha' // Etiqueta del eje X
                        }
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
                    backgroundColor: 'rgb(3,27,52)',
                    borderColor: 'rgb(3,27,52)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad' // Etiqueta del eje Y
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tipo' // Etiqueta del eje X
                        }
                    }
                }
            }
        });

        //para las ganacias
        distribucionChart = new Chart(document.getElementById('distribucionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: distribucionData.map(entry => entry.fecha), // Fechas como etiquetas
                datasets: [{
                    label: 'Monto Total Pagado',
                    data: distribucionData.map(entry => entry.total), // Montos totales como datos
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto Total (S/.)' // Etiqueta del eje Y
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha' // Etiqueta del eje X
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#333'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `S/. ${tooltipItem.raw.toLocaleString()}`; // Formato en soles
                            }
                        }
                    }
                }
            }
        });

        const perdidasChart = new Chart(document.getElementById('perdidasChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: perdidasData.map(entry => entry.fecha), // Fechas de reservas canceladas
                datasets: [{
                    label: 'Monto Perdido (Reservas Canceladas)',
                    data: perdidasData.map(entry => entry.total), // Monto perdido por cada fecha
                    backgroundColor: 'rgba(255, 99, 132, 0.6)', // Color de las barras
                    borderColor: 'rgba(255, 99, 132, 1)', // Borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto Total (S/.)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#333'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `S/. ${tooltipItem.raw.toLocaleString()}`;
                            }
                        }
                    }
                }
            }
        });
        

    }

    //filtros
    function updateChart(chart, data, labelKey, valueKey) {
        chart.data.labels = data.map(item => item[labelKey]);
        chart.data.datasets[0].data = data.map(item => item[valueKey]);
        chart.update();
    }


    function filterDataByDate(data, startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        return data.filter(item => {
            const date = new Date(item.fecha);
            return date >= start && date <= end;
        });
    }


    function applyFilters() {
        const fechaInicio = fechaInicioInput.value;
        const fechaFin = fechaFinInput.value;
    
        if (!fechaInicio || !fechaFin) {
            alert('Por favor, selecciona ambas fechas.');
            return;
        }
    
        const usuariosFiltrados = filterDataByDate(usuariosData, fechaInicio, fechaFin);
        const reservasFiltradas = filterDataByDate(reservasData, fechaInicio, fechaFin);
        const distribucionFiltrada = filterDataByDate(distribucionData, fechaInicio, fechaFin);
        const perdidasFiltradas = filterDataByDate(perdidasData, fechaInicio, fechaFin);
    
        updateChart(usuariosChart, usuariosFiltrados, 'fecha', 'cantidad');
        updateChart(reservasChart, reservasFiltradas, 'fecha', 'cantidad');
        updateChart(distribucionChart, distribucionFiltrada, 'fecha', 'total');
        updateChart(perdidasChart, perdidasFiltradas, 'fecha', 'total');
    }


    function clearFilters() {
        fechaInicioInput.value = '';
        fechaFinInput.value = '';
    
        updateChart(usuariosChart, usuariosData, 'fecha', 'cantidad');
        updateChart(reservasChart, reservasData, 'fecha', 'cantidad');
        updateChart(distribucionChart, distribucionData, 'fecha', 'total');
        updateChart(perdidasChart, perdidasData, 'fecha', 'total');

    }

    applyFilterBtn.addEventListener('click', applyFilters);
    deleteFiltersBtn.addEventListener('click', clearFilters);

initCharts();

});

document.getElementById('printTablesPdfBtn').addEventListener('click', function () {
    window.location.href = 'generate_report.php';
});
