<?php
require_once __DIR__ . '/../models/MinoridadModel.php';

$id_carnet = $_GET['id'] ?? null;

if (!$id_carnet) {
    die("Error: No se proporcionó un ID de carnet.");
}

$modelo = new MinoridadModel();
$datos = $modelo->obtenerPorId($id_carnet);

if (!$datos) {
    die("Error: No se encontró el carnet con el ID proporcionado.");
}

$nombre_completo = $datos['nombres'] . ' ' . $datos['apellidos'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carnet de Minoridad – <?= htmlspecialchars($nombre_completo) ?></title>
  <style>
    body { font-family: 'Arial', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f0f0f0; margin: 0; }
    .carnet {
      width: 450px;
      height: 280px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      border: 1px solid #ddd;
      position: relative;
    }
    .carnet-header {
      background: #1C3166;
      color: white;
      padding: 10px;
      text-align: center;
      font-size: 0.9rem;
      font-weight: bold;
    }
    .carnet-body {
      display: flex;
      padding: 15px;
      flex: 1;
    }
    .photo-area {
      width: 110px;
      height: 140px;
      border: 2px solid #1C3166;
      background: #eee;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }
    .info-area {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .info-label { font-size: 0.65rem; color: #666; text-transform: uppercase; font-weight: bold; }
    .info-value { font-size: 0.85rem; color: #000; font-weight: bold; margin-bottom: 5px; border-bottom: 1px solid #eee; }
    .carnet-footer {
      background: #f8f9fa;
      padding: 8px;
      font-size: 0.7rem;
      text-align: center;
      border-top: 1px solid #eee;
    }
    .watermark {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-30deg);
      font-size: 4rem;
      color: rgba(0,0,0,0.03);
      pointer-events: none;
      white-space: nowrap;
    }
    @media print {
      body { background: white; }
      .no-print { display: none; }
      .carnet { box-shadow: none; border: 1px solid #000; -webkit-print-color-adjust: exact; }
    }
  </style>
</head>
<body>
  <div class="carnet">
    <div class="watermark">MUNIFY MUNIFY</div>
    <div class="carnet-header">
      ALCALDÍA MUNICIPAL DE ILOBASCO<br>
      <span style="font-size: 0.7rem; font-weight: normal;">CARNET DE IDENTIFICACIÓN DE MENOR</span>
    </div>
    <div class="carnet-body">
      <div class="photo-area">
        <span style="font-size: 0.6rem; color: #999;">FOTOGRAFÍA</span>
      </div>
      <div class="info-area">
        <div class="info-label">Nombres y Apellidos</div>
        <div class="info-value"><?= htmlspecialchars($nombre_completo) ?></div>
        
        <div style="display: flex; gap: 10px;">
          <div style="flex: 1;">
            <div class="info-label">Fecha Nac.</div>
            <div class="info-value"><?= htmlspecialchars($datos['fecha_nacimiento']) ?></div>
          </div>
          <div style="flex: 1;">
            <div class="info-label">Sexo</div>
            <div class="info-value"><?= $datos['sexo'] == 'M' ? 'Masc.' : 'Fem.' ?></div>
          </div>
        </div>

        <div class="info-label">Número de Carnet</div>
        <div class="info-value" style="color: #1C3166;"><?= htmlspecialchars($datos['numero_carnet']) ?></div>

        <div style="display: flex; gap: 10px;">
          <div style="flex: 1;">
            <div class="info-label">Emisión</div>
            <div class="info-value"><?= htmlspecialchars($datos['fecha_emision']) ?></div>
          </div>
          <div style="flex: 1;">
            <div class="info-label">Vencimiento</div>
            <div class="info-value"><?= htmlspecialchars($datos['fecha_vencimiento']) ?></div>
          </div>
        </div>
      </div>
    </div>
    <div class="carnet-footer">
      Este documento es personal e intransferible. Válido en todo el territorio nacional.
    </div>
  </div>

  <button class="no-print" onclick="window.print()" style="position: fixed; top: 20px; right: 20px; padding: 10px 20px; background: #1C3166; color: white; border: none; border-radius: 5px; cursor: pointer;">Imprimir Carnet</button>

  <script>window.onload = function() { setTimeout(function() { window.print(); }, 500); };</script>
</body>
</html>
