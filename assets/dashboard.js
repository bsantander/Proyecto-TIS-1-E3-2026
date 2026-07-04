new Chart(document.getElementById('Izquierda'), {
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

new Chart(document.getElementById('Derecha'), {
    type:'pie',
    data:{
        labels:['Operativos','En Mantención','Baja'],
        datasets:[{
            data:[170,60,120],
            backgroundColor:[
                '#05ad98',
                '#ffc107',
                '#dc3545'
            ]
        }]
    }
});
