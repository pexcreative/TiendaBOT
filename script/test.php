<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de barras animado con Bootstrap 5</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .chart {
            width: 100%;
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <canvas class="chart" id="myChart"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        // Configuración del gráfico
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                datasets: [{
                    label: 'Ventas',
                    data: [100, 200, 300, 400, 500, 600, 700],
                    backgroundColor: [
                        'rgba(233, 30, 99, 0.1)',
                        'rgba(23, 114, 145, 0.1)',
                        'rgba(128, 181, 233, 0.1)',
                        'rgba(220, 220, 220, 0.1)',
                        'rgba(128, 128, 128, 0.1)'
                    ],
                    borderColor: [
                        'rgba(233, 30, 99, 1)',
                        'rgba(23, 114, 145, 1)',
                        'rgba(128, 181, 233, 1)',
                        'rgba(220, 220, 220, 1)',
                        'rgba(128, 128, 128, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: true,
                    position: 'top'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Mostrar el gráfico
        myChart.update();
    </script>
</body>
</html>