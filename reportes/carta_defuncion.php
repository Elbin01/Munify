<?php
require_once __DIR__ . '/../models/DefuncionModel.php';

$id_carta = $_GET['id'] ?? null;

if (!$id_carta) {
    die("Error: No se proporcionó un ID de acta.");
}

$modelo = new DefuncionModel();
$datos = $modelo->obtenerPorId($id_carta);

if (!$datos) {
    die("Error: No se encontró el acta con el ID proporcionado.");
}

$datos_municipio = [
    'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
    'departamento'  => 'Cabañas',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',
];

function fechaEspañol($fecha) {
    if (!$fecha) return '---';
    $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    $timestamp = strtotime($fecha);
    $dia = date('d', $timestamp);
    $mes = $meses[date('n', $timestamp) - 1];
    $año = date('Y', $timestamp);
    return "$dia de $mes de $año";
}

$nombre_fallecido = $datos['nombres'] . ' ' . $datos['apellidos'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carta de Defunción – <?= htmlspecialchars($nombre_fallecido) ?></title>
  <style>
    body { font-family: 'EB Garamond', serif; padding: 40px; line-height: 1.6; }
    .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #003366; padding-bottom: 10px; }
    .header h1 { font-size: 1.2rem; margin: 0; }
    .content { max-width: 800px; margin: 0 auto; text-align: justify; }
    .title { text-align: center; font-weight: bold; font-size: 1.4rem; margin-bottom: 30px; text-transform: uppercase; }
    .field-group { margin-bottom: 20px; }
    .label { font-weight: bold; text-transform: uppercase; font-size: 0.8rem; color: #003366; display: block; }
    .value { font-size: 1.1rem; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    .footer { margin-top: 60px; display: flex; justify-content: space-around; text-align: center; }
    .signature { width: 200px; border-top: 1px solid #000; padding-top: 5px; }
    @media print { .no-print { display: none; } }
  </style>
</head>
<body>
  <div class="header">
    <h1><?= htmlspecialchars($datos_municipio['alcaldia']) ?></h1>
    <p>Departamento de <?= htmlspecialchars($datos_municipio['departamento']) ?> – <?= htmlspecialchars($datos_municipio['pais']) ?></p>
    <p>REGISTRO DEL ESTADO FAMILIAR</p>
  </div>

  <div class="content">
    <div class="title">Certificación de Acta de Defunción</div>
    
    <div class="field-group">
      <span class="label">Nombre del Fallecido</span>
      <div class="value"><?= htmlspecialchars($nombre_fallecido) ?></div>
    </div>

    <div style="display: flex; gap: 20px;">
      <div class="field-group" style="flex: 1;">
        <span class="label">DUI</span>
        <div class="value"><?= htmlspecialchars($datos['DUI'] ?: '---') ?></div>
      </div>
      <div class="field-group" style="flex: 1;">
        <span class="label">Fecha de Defunción</span>
        <div class="value"><?= fechaEspañol($datos['fecha_defuncion']) ?></div>
      </div>
    </div>

    <div class="field-group">
      <span class="label">Lugar de Defunción</span>
      <div class="value"><?= htmlspecialchars($datos['lugar_defuncion'] ?: 'No especificado') ?></div>
    </div>

    <div class="field-group">
      <span class="label">Causa de Muerte</span>
      <div class="value"><?= htmlspecialchars($datos['causa'] ?: 'Pendiente de certificación médica') ?></div>
    </div>

    <div class="field-group">
      <span class="label">Nombre del Declarante</span>
      <div class="value"><?= htmlspecialchars($datos['nombre_declarante'] ?: '---') ?></div>
    </div>

    <div class="field-group">
      <span class="label">Fecha de Emisión</span>
      <div class="value"><?= fechaEspañol($datos['fecha_emision']) ?></div>
    </div>

    <p style="margin-top: 40px;">
      El infrascrito Jefe del Registro del Estado Familiar de la Alcaldía Municipal de Ilobasco, Certifica: Que en el libro de Defunciones que esta oficina lleva en el presente año, se encuentra el acta arriba mencionada.
    </p>
  </div>

  <div class="footer">
    <div class="signature">
      <p>F. Jefe de Registro</p>
      <p style="font-size: 0.8rem;">Licda. Rosa Elena Méndez Castro</p>
    </div>
    <div class="signature">
      <p>F. Declarante</p>
      <p style="font-size: 0.8rem;"><?= htmlspecialchars($datos['nombre_declarante'] ?: '---') ?></p>
    </div>
  </div>

  <button class="no-print" onclick="window.print()" style="position: fixed; top: 20px; right: 20px; padding: 10px 20px; background: #003366; color: white; border: none; cursor: pointer;">Imprimir</button>

  <script>window.onload = function() { setTimeout(function() { window.print(); }, 500); };</script>
</body>
</html>
