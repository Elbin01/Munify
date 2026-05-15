<?php 
session_start();
require_once __DIR__ . '/../models/EstadisticaModel.php';

$estadisticaModel = new EstadisticaModel();

// Obtener datos para los gráficos
$citasMes = $estadisticaModel->getCitasPorMes();
$distribucion = $estadisticaModel->getDistribucionTramites();
$partidasMes = $estadisticaModel->getPartidasPorMes();

// Preparar arrays para Tendencia
$mesesNombres = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$citasData = array_fill(0, 12, 0);
$partidasData = array_fill(0, 12, 0);

foreach ($citasMes as $c) {
    $citasData[$c['mes_num'] - 1] = (int)$c['total'];
}
foreach ($partidasMes as $p) {
    $partidasData[$p['mes_num'] - 1] = (int)$p['total'];
}

$distLabels = [];
$distValues = [];
foreach ($distribucion as $d) {
    $distLabels[] = $d['tramite'];
    $distValues[] = (int)$d['total'];
}

// Preparar datos para Heatmap (Día vs Hora)
$heatmapRaw = $estadisticaModel->getDemandaHeatmap();
$diasSemana = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$diasEs = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
$heatmapData = [];

foreach ($diasSemana as $index => $dia) {
    $dataDia = [];
    for ($h = 8; $h <= 17; $h++) { // De 8 AM a 5 PM
        $total = 0;
        foreach ($heatmapRaw as $row) {
            if ($row['dia'] == $dia && $row['hora'] == $h) {
                $total = (int)$row['total'];
                break;
            }
        }
        $dataDia[] = ['x' => $h . ':00', 'y' => $total];
    }
    $heatmapData[] = [
        'name' => $diasEs[$index],
        'data' => $dataDia
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - Munify</title>
    <?php include 'layouts/fonts.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/Css/index.css">
    <link rel="stylesheet" href="../assets/Css/sidebar.css">
    <link rel="stylesheet" href="../assets/Css/footer.css">
    <style>
        .chart-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 20px;
            height: 100%;
            transition: transform 0.3s ease;
        }
        .chart-card:hover {
            transform: translateY(-5px);
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="dashboard-container d-flex">
        <?php include 'layouts/sidebar.php'; ?>

        <main class="main-content flex-grow-1">
            <div class="container-fluid py-4 px-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold" style="color: var(--color-3);">Estadísticas Avanzadas</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Estadísticas</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <!-- Gráfico de Tendencias -->
                    <div class="col-12 col-lg-8">
                        <div class="chart-card">
                            <h5 class="fw-bold mb-4">Tendencia Mensual (Citas vs Partidas)</h5>
                            <div id="chart-tendencia"></div>
                        </div>
                    </div>

                    <!-- Gráfico de Distribución -->
                    <div class="col-12 col-lg-4">
                        <div class="chart-card">
                            <h5 class="fw-bold mb-4">Distribución de Trámites</h5>
                            <div id="chart-distribucion"></div>
                        </div>
                    </div>

                    <!-- Heatmap de Saturación -->
                    <div class="col-12">
                        <div class="chart-card">
                            <h5 class="fw-bold mb-4">Mapa de Calor: Saturación de Citas</h5>
                            <div id="chart-heatmap"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Configuración Global de Colores
        const primaryColor = '#1C3166';
        const secondaryColor = '#4a69bd';

        // 1. Gráfico de Tendencia (Área)
        var optionsTendencia = {
            series: [{
                name: 'Citas Solicitadas',
                data: <?= json_encode($citasData) ?>
            }, {
                name: 'Partidas Emitidas',
                data: <?= json_encode($partidasData) ?>
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: [primaryColor, '#27ae60'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: <?= json_encode($mesesNombres) ?>,
            },
            tooltip: { x: { format: 'dd/MM/yy HH:mm' } },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                }
            }
        };
        new ApexCharts(document.querySelector("#chart-tendencia"), optionsTendencia).render();

        // 2. Gráfico de Distribución (Donut)
        var optionsDist = {
            series: <?= json_encode($distValues) ?>,
            chart: {
                type: 'donut',
                height: 350
            },
            labels: <?= json_encode($distLabels) ?>,
            colors: [primaryColor, '#3498db', '#9b59b6', '#e67e22'],
            legend: { position: 'bottom' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: { show: true, label: 'Total' }
                        }
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#chart-distribucion"), optionsDist).render();

        // 3. Heatmap de Saturación
        var optionsHeatmap = {
            series: <?= json_encode($heatmapData) ?>,
            chart: {
                height: 350,
                type: 'heatmap',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            colors: [primaryColor],
            title: { text: '' },
            xaxis: {
                type: 'category',
                title: { text: 'Horario de Atención' }
            },
            plotOptions: {
                heatmap: {
                    shadeIntensity: 0.5,
                    radius: 0,
                    useFillColorAsStroke: true,
                    colorScale: {
                        ranges: [{
                            from: 0,
                            to: 0,
                            name: 'Sin Citas',
                            color: '#f3f3f3'
                        }, {
                            from: 1,
                            to: 5,
                            name: 'Baja',
                            color: '#b3c1d1'
                        }, {
                            from: 6,
                            to: 10,
                            name: 'Media',
                            color: '#5c7ba1'
                        }, {
                            from: 11,
                            to: 100,
                            name: 'Alta',
                            color: primaryColor
                        }]
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#chart-heatmap"), optionsHeatmap).render();
    </script>
</body>
</html>