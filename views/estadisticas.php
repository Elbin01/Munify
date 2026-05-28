<?php 
session_start();
require_once __DIR__ . '/../models/EstadisticaModel.php';

$estadisticaModel = new EstadisticaModel();

/* ================= DATOS ================= */
$citasMes     = $estadisticaModel->getCitasPorMes();
$distribucion = $estadisticaModel->getDistribucionTramites();
$partidasMes  = $estadisticaModel->getPartidasPorMes();
$demografia   = $estadisticaModel->getDemografiaCiudadanos();

$mesesNombres = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
$citasData    = array_fill(0,12,0);
$partidasData = array_fill(0,12,0);

foreach ($citasMes as $c)     $citasData[$c['mes_num'] - 1] = (int)$c['total'];
foreach ($partidasMes as $p)  $partidasData[$p['mes_num'] - 1] = (int)$p['total'];

$distLabels = [];
$distValues = [];
foreach ($distribucion as $d) {
    $distLabels[] = $d['tramite'];
    $distValues[] = (int)$d['total'];
}

/* ================= HEATMAP ================= */
$heatmapRaw = $estadisticaModel->getDemandaHeatmap();
$diasSemana = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
$diasEs     = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
$heatmapData = [];

foreach ($diasSemana as $i => $dia) {
    $dataDia = [];
    for ($h = 8; $h <= 17; $h++) {
        $total = 0;
        foreach ($heatmapRaw as $row) {
            if ($row['dia'] === $dia && $row['hora'] == $h) {
                $total = (int)$row['total'];
                break;
            }
        }
        $dataDia[] = ['x'=>$h.':00','y'=>$total];
    }
    $heatmapData[] = ['name'=>$diasEs[$i],'data'=>$dataDia];
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

<link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
<link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
<link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">

<style>
.chart-card{
    background:#fff;
    border-radius:15px;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
    padding:20px;
}
.nav-tabs .nav-link{
    font-weight:600;
    color:#333;
}
.nav-tabs .nav-link.active{
    background:var(--color-3);
    color:#fff;
}
.main-content{
    background:#f8f9fa;
    min-height:100vh;
}
</style>
</head>

<body>
<div class="dashboard-container d-flex">

<?php include 'layouts/sidebar.php'; ?>

<main class="main-content flex-grow-1">
<div class="container-fluid py-4 px-4">

<!-- ================= HEADER CON CAMPANA ================= -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--color-3);">Estadísticas Avanzadas</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a>
                </li>
                <li class="breadcrumb-item active fw-semibold small" style="color: var(--color-3);">
                    Estadísticas
                </li>
            </ol>
        </nav>
    </div>
</div>
<!-- ================= TABS ================= -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#t1">Tendencia</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#t2">Distribución</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#t3">Comparativa</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#t4">Demografía</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#t5">Saturación</button></li>
</ul>

<div class="tab-content">

<div class="tab-pane fade show active" id="t1">
    <div class="chart-card"><div id="chart-tendencia"></div></div>
</div>

<div class="tab-pane fade" id="t2">
    <div class="chart-card"><div id="chart-distribucion"></div></div>
</div>

<div class="tab-pane fade" id="t3">
    <div class="chart-card"><div id="chart-barras"></div></div>
</div>

<div class="tab-pane fade" id="t4">
    <div class="chart-card"><div id="chart-demografia"></div></div>
</div>

<div class="tab-pane fade" id="t5">
    <div class="chart-card"><div id="chart-heatmap"></div></div>
</div>

</div>
</div>

<?php include 'layouts/footer.php'; ?>
</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
const primaryColor = '#1C3166';
const charts = [];

/* Tendencia */
charts.push(new ApexCharts(document.querySelector("#chart-tendencia"),{
series:[
{ name:'Citas', data:<?=json_encode($citasData)?> },
{ name:'Partidas', data:<?=json_encode($partidasData)?> }
],
chart:{ type:'area', height:350 },
xaxis:{ categories:<?=json_encode($mesesNombres)?> },
colors:[primaryColor,'#27ae60']
}));

/* Distribución */
charts.push(new ApexCharts(document.querySelector("#chart-distribucion"),{
series:<?=json_encode($distValues)?>,
chart:{ type:'donut', height:350 },
labels:<?=json_encode($distLabels)?>,
colors:[primaryColor,'#3498db','#9b59b6','#e67e22']
}));

/* Barras */
charts.push(new ApexCharts(document.querySelector("#chart-barras"),{
series:[{ data:<?=json_encode($distValues)?> }],
chart:{ type:'bar', height:350 },
xaxis:{ categories:<?=json_encode($distLabels)?> },
colors:[primaryColor]
}));

/* Demografía */
charts.push(new ApexCharts(document.querySelector("#chart-demografia"),{
series:[<?=$demografia['Adultos']?>,<?=$demografia['Menores']?>],
chart:{ type:'pie', height:350 },
labels:['Adultos','Menores']
}));

/* Heatmap */
charts.push(new ApexCharts(document.querySelector("#chart-heatmap"),{
series:<?=json_encode($heatmapData)?>,
chart:{ type:'heatmap', height:350 },
colors:[primaryColor]
}));

charts.forEach(c => c.render());

document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tab=>{
    tab.addEventListener('shown.bs.tab',()=>{
        charts.forEach(c=>c.resize());
    });
});
</script>

</body>
</html>