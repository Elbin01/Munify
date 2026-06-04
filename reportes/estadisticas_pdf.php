<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/EstadisticaModel.php';

$inicio = $_GET['inicio'] ?? null;
$fin = $_GET['fin'] ?? null;

if (!$inicio || !$fin) {
    die("Debe proporcionar las fechas de inicio y fin para el reporte.");
}

$estadisticaModel = new EstadisticaModel();

$citasMes     = $estadisticaModel->getCitasPorMes($inicio, $fin);
$distribucion = $estadisticaModel->getDistribucionTramites($inicio, $fin);
$partidasMes  = $estadisticaModel->getPartidasPorMes($inicio, $fin);
$demografia   = $estadisticaModel->getDemografiaCiudadanos(); // General

// Preparamos HTML
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Estadísticas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #1C3166;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
            border: none;
        }
        .header td {
            vertical-align: middle;
        }
        .logo-izq {
            width: 120px;
        }
        .logo-der {
            width: 100px;
        }
        .titulo-reporte {
            text-align: center;
        }
        .titulo-reporte h1 {
            color: #1C3166;
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .titulo-reporte p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #555;
        }
        h2 {
            color: #1C3166;
            font-size: 14px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        table.datos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.datos th, table.datos td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.datos th {
            background-color: #f4f7fb;
            color: #1C3166;
            font-weight: bold;
        }
        .footer {
            width: 100%;
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="header">
    <table>
        <tr>
            <td style="width: 20%;"><img src="../assets/img/logo_munify/isotipo_positivo.png" class="logo-izq"></td>
            <td style="width: 60%;" class="titulo-reporte">
                <h1>Alcaldía Municipal de Ilobasco</h1>
                <p>Reporte Estadístico del Sistema Munify</p>
                <p><strong>Período:</strong> ' . date("d/m/Y", strtotime($inicio)) . ' al ' . date("d/m/Y", strtotime($fin)) . '</p>
            </td>
            <td style="width: 20%; text-align: right;"><img src="../assets/img/sello_ilobasco.png" class="logo-der"></td>
        </tr>
    </table>
</div>

<h2>Distribución de Trámites Emitidos</h2>
<table class="datos">
    <thead>
        <tr>
            <th>Tipo de Trámite</th>
            <th>Total Solicitudes</th>
        </tr>
    </thead>
    <tbody>';
$totalTramites = 0;
foreach ($distribucion as $d) {
    $html .= '<tr>
                <td>' . htmlspecialchars($d['tramite']) . '</td>
                <td>' . htmlspecialchars($d['total']) . '</td>
              </tr>';
    $totalTramites += (int)$d['total'];
}
$html .= '
        <tr>
            <td style="text-align: right; font-weight: bold;">Total General:</td>
            <td style="font-weight: bold;">' . $totalTramites . '</td>
        </tr>
    </tbody>
</table>

<h2>Citas por Mes (Demandas en el período)</h2>
<table class="datos">
    <thead>
        <tr>
            <th>Mes</th>
            <th>Total Citas Agendadas</th>
        </tr>
    </thead>
    <tbody>';
$totalCitas = 0;
foreach ($citasMes as $c) {
    $html .= '<tr>
                <td>' . htmlspecialchars($c['mes_nombre']) . '</td>
                <td>' . htmlspecialchars($c['total']) . '</td>
              </tr>';
    $totalCitas += (int)$c['total'];
}
if(empty($citasMes)) {
    $html .= '<tr><td colspan="2" style="text-align:center;">No hay citas registradas en este período</td></tr>';
} else {
    $html .= '
        <tr>
            <td style="text-align: right; font-weight: bold;">Total Citas:</td>
            <td style="font-weight: bold;">' . $totalCitas . '</td>
        </tr>';
}
$html .= '
    </tbody>
</table>

<h2>Partidas Emitidas por Mes</h2>
<table class="datos">
    <thead>
        <tr>
            <th>Mes</th>
            <th>Total Partidas</th>
        </tr>
    </thead>
    <tbody>';
$totalPartidas = 0;
foreach ($partidasMes as $p) {
    // Convertir el número de mes a nombre para mejor lectura
    $meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    $mesNombre = $meses[(int)$p['mes_num'] - 1];
    
    $html .= '<tr>
                <td>' . $mesNombre . '</td>
                <td>' . htmlspecialchars($p['total']) . '</td>
              </tr>';
    $totalPartidas += (int)$p['total'];
}
if(empty($partidasMes)) {
    $html .= '<tr><td colspan="2" style="text-align:center;">No hay partidas registradas en este período</td></tr>';
} else {
    $html .= '
        <tr>
            <td style="text-align: right; font-weight: bold;">Total Partidas:</td>
            <td style="font-weight: bold;">' . $totalPartidas . '</td>
        </tr>';
}
$html .= '
    </tbody>
</table>

<div class="footer">
    <p>Reporte generado por Munify el ' . date("d/m/Y H:i:s") . '</p>
</div>

</body>
</html>
';

try {
    $mpdf = new \Mpdf\Mpdf([
        'format' => 'Letter',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 15,
        'margin_bottom' => 15,
    ]);
    
    $mpdf->SetTitle('Reporte de Estadísticas');
    $mpdf->WriteHTML($html);
    $mpdf->Output('Reporte_Estadisticas.pdf', 'I');
    
} catch (\Mpdf\MpdfException $e) {
    echo "Hubo un error al generar el PDF: " . $e->getMessage();
}
