const chartIzquierda = document.getElementById('Izquierda');
const chartDerecha = document.getElementById('Derecha');
const chartBar = document.getElementById('bar');
const chartPie = document.getElementById('pie');
    
const dashboardTecnicoData = window.dashboardTecnicoData || null;

if (chartIzquierda) {
    new Chart(chartIzquierda, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Costos durante el mes',
                data: [56000, 40000, 22000, 100000, 70000, 90000],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Costos en $ por Mes',
                    color: 'dark',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
}

if (chartDerecha) {
    new Chart(chartDerecha, {
        type: 'pie',
        data: {
            labels: ['Operativos', 'En Mantencion', 'Baja'],
            datasets: [{
                data: [170, 60, 120],
                backgroundColor: [
                    '#05ad98',
                    '#ffc107',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

if (chartBar) {
    new Chart(chartBar, {
        type: 'bar',
        data: {
            labels: ['Operativos', 'En Mantencion', 'Dados de baja'],
            datasets: [{
                label: 'Equipos',
                data: dashboardTecnicoData
                    ? [
                        dashboardTecnicoData.equipos.operativos,
                        dashboardTecnicoData.equipos.mantencion,
                        dashboardTecnicoData.equipos.baja
                    ]
                    : [20, 15, 10],
                backgroundColor: [
                    '#05ad98',
                    '#ffc107',
                    '#dc3545'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Equipos por Estado',
                    color: '#333333',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            }
        }
    });
}

if (chartPie) {
    new Chart(chartPie, {
        type: 'pie',
        data: {
            labels: ['Preventivas', 'Correctivas'],
            datasets: [{
                data: dashboardTecnicoData
                    ? [
                        dashboardTecnicoData.mantenciones.preventivas,
                        dashboardTecnicoData.mantenciones.correctivas
                    ]
                    : [0, 0],
                backgroundColor: [
                    '#0d6efd',
                    '#dc3545'
                ],
                borderColor: '#ffffff',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Mantenciones por Tipo',
                    color: '#333333',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            }
        }
    });
}
