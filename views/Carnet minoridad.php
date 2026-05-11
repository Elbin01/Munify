<?php
$datos_municipio = [
    'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
    'departamento'  => 'Cabañas',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',
    'logo'          => '',
];

$datos_menor = [
    'apellidos'          => $_POST['m_apellidos'] ?? 'Rodríguez López',
    'nombres'            => $_POST['m_nombres'] ?? 'María José',
    'lugar_nacimiento'   => $_POST['m_lugar_nac'] ?? 'Ilobasco, Cabañas',
    'fecha_nacimiento'   => $_POST['m_fecha_nac'] ?? '14/04/2015',
    'fecha_expedicion'   => date('d/m/Y'),
    'fecha_vencimiento'  => date('d/m/Y', strtotime('+3 years')),
    'numero_carnet'      => '0601-' . rand(100000, 999999),
    'foto'               => $_POST['m_foto_path'] ?? '',
];

$datos_reverso = [
    'direccion'          => $_POST['m_direccion'] ?? 'Colonia Jardines, Calle Principal #12, Ilobasco, Cabañas',
    'nombre_madre'       => $_POST['m_nombre_madre'] ?? 'Ana Sofía López de Rodríguez',
    'nombre_padre'       => $_POST['m_nombre_padre'] ?? 'Carlos Alberto Rodríguez Martínez',
    'color_piel'         => $_POST['m_color_piel'] ?? 'Moreno',
    'color_ojos'         => $_POST['m_color_ojos'] ?? 'Café',
    'cabello'            => $_POST['m_color_cabello'] ?? 'Negro',
    'senales_especiales' => $_POST['m_senales_especiales'] ?? 'Ninguna',
    'centro_estudios'    => $_POST['m_centro_estudios'] ?? 'Centro Escolar Sor Heriquez',
    'tipo_tramite'       => 'PRIMERA VEZ',
];

$datos_footer = [
    'alcalde'    => 'Lic. Lorenzo Rivas',
    'secretario' => 'Licda. Rosa Elena Méndez Castro',
    'atendio'    => 'Asistente: María del Carmen Guevara',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carnet de Minoridad – <?= htmlspecialchars($datos_menor['nombres']) ?> <?= htmlspecialchars($datos_menor['apellidos']) ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --negro:       #000000;
      --azul-oscuro: #003366;
      --azul-medio:  #005599;
      --blanco:      #ffffff;
      --gris-claro:  #f5f5f5;
      --gris-linea:  #cccccc;
      --texto:       #111111;
      --sombra:      rgba(0, 0, 0, 0.2);
    }

    body {
      font-family: 'EB Garamond', Georgia, serif;
      background: #ffffff;
      color: var(--texto);
      min-height: 100vh;
      padding: 1.5rem 0.5rem 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.5rem;
    }

    /* ── Botón imprimir ── */
    .btn-imprimir {
      position: fixed;
      top: 1rem;
      right: 1rem;
      padding: 0.35rem 0.8rem;
      background: var(--negro);
      color: var(--blanco);
      border: 1.5px solid var(--negro);
      border-radius: 3px;
      cursor: pointer;
      font-family: 'Cinzel', serif;
      font-size: 0.65rem;
      letter-spacing: 0.08em;
      box-shadow: 0 2px 8px rgba(0,0,0,0.35);
      z-index: 999;
      display: flex;
      align-items: center;
      gap: 0.35rem;
      transition: background 0.2s;
    }
    .btn-imprimir:hover { background: var(--azul-oscuro); }

    /* ── Etiqueta de cara ── */
    .cara-label {
      font-family: 'Cinzel', serif;
      font-size: 0.68rem;
      letter-spacing: 0.12em;
      color: #555555;
      text-transform: uppercase;
      align-self: flex-start;
      margin-left: calc(50% - 380px);
      margin-top: 1rem;
    }

    /* ── Hoja ── */
    .hoja {
      width: 100%;
      max-width: 760px;
      background: var(--blanco);
      border: 1.5px solid #999;
      box-shadow: 0 6px 30px var(--sombra);
      position: relative;
      overflow: hidden;
      margin-bottom: 2rem;
    }

    /* ── Encabezado ── */
    .encabezado {
      padding: 0.45rem 1rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      border-bottom: 2px solid var(--negro);
      background: var(--blanco);
    }

    .logo-wrap {
      width: 50px;
      height: 50px;
      flex-shrink: 0;
      border: 1.5px solid var(--negro);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--gris-claro);
      overflow: hidden;
    }
    .logo-wrap img { width: 100%; height: 100%; object-fit: contain; }
    .logo-placeholder {
      font-size: 9px;
      color: var(--negro);
      text-align: center;
      line-height: 1.3;
      font-family: 'Cinzel', serif;
    }

    .encabezado-texto { flex: 1; text-align: center; }
    .encabezado-texto h1 {
      font-family: 'Cinzel', serif;
      font-size: 0.65rem;
      color: var(--negro);
      letter-spacing: 0.08em;
      line-height: 1.5;
    }
    .encabezado-texto .titulo-doc {
      margin-top: 0.35rem;
      font-family: 'Cinzel', serif;
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--negro);
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }

    /* ══ CARA FRONTAL ══ */
    .frontal-body {
      padding: 1.2rem 1.5rem;
      display: flex;
      gap: 1.2rem;
      background: var(--blanco);
    }

    .foto-wrap {
      width: 110px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.4rem;
    }
    .foto-box {
      width: 110px;
      height: 140px;
      border: 2px solid var(--negro);
      background: var(--gris-claro);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .foto-box img { width: 100%; height: 100%; object-fit: cover; }
    .foto-placeholder {
      font-size: 0.65rem;
      color: #888;
      text-align: center;
      font-style: italic;
    }
    .numero-carnet {
      font-family: 'Cinzel', serif;
      font-size: 0.68rem;
      color: var(--negro);
      font-weight: 700;
      letter-spacing: 0.05em;
      text-align: center;
    }

    .frontal-campos {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 0.8rem;
    }

    /* ── Campos ── */
    .campo { display: flex; flex-direction: column; gap: 1px; }
    .campo label {
      font-size: 0.6rem;
      font-weight: 700;
      color: var(--negro);
      letter-spacing: 0.06em;
      text-transform: uppercase;
      font-family: 'Cinzel', serif;
    }
    .campo .valor {
      font-size: 0.82rem;
      color: var(--texto);
      border-bottom: 1px solid var(--gris-linea);
      padding-bottom: 2px;
      min-height: 1.3em;
    }

    .campos-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.6rem 1.2rem;
    }

    /* Firmas frontales */
    .frontal-footer {
      padding: 0.7rem 1.5rem 1rem;
      border-top: 1px solid var(--gris-linea);
      display: flex;
      justify-content: space-around;
      align-items: flex-end;
      gap: 1rem;
      background: var(--blanco);
    }

    .sello-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.25rem;
    }
    .sello-circulo {
      width: 55px;
      height: 55px;
      border: 2px solid var(--negro);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.5rem;
      color: var(--negro);
      text-align: center;
      font-family: 'Cinzel', serif;
      letter-spacing: 0.04em;
      line-height: 1.3;
    }
    .firma-linea-sm {
      width: 110px;
      border-bottom: 1.5px solid var(--negro);
      height: 28px;
    }
    .firma-label {
      font-family: 'Cinzel', serif;
      font-size: 0.58rem;
      color: var(--negro);
      text-align: center;
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }
    .firma-nombre-sm {
      font-size: 0.7rem;
      font-style: italic;
      color: var(--negro);
      text-align: center;
    }

    /* ══ CARA POSTERIOR ══ */
    .reverso-body {
      padding: 1.2rem 1.5rem;
      background: var(--blanco);
    }

    .reverso-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem 1.5rem;
    }

    .campo.full-col { grid-column: 1 / -1; }

    .tipo-tramite-badge {
      display: inline-block;
      color: var(--negro);
      font-family: 'Cinzel', serif;
      font-size: 0.62rem;
      letter-spacing: 0.08em;
      padding: 0.2rem 0.7rem;
      border-radius: 2px;
      align-self: center;
      justify-self: end;
    }

    .reverso-footer {
      padding: 0.8rem 1.5rem 1rem;
      border-top: 1px solid var(--gris-linea);
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      background: var(--blanco);
    }

    .huella-box {
      width: 50px;
      height: 65px;
      border: 1px solid var(--gris-linea);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.25rem;
    }
    .huella-box span {
      font-size: 0.55rem;
      color: #888;
      font-style: italic;
    }
    .huella-oval {
      width: 25px;
      height: 36px;
      border: 1.5px solid #999;
      border-radius: 50%;
    }

    .ministerio-wrap {
      text-align: right;
      font-family: 'Cinzel', serif;
      font-size: 0.62rem;
      color: var(--negro);
      letter-spacing: 0.05em;
      line-height: 1.6;
    }
    .ministerio-num {
      font-size: 0.88rem;
      font-weight: 700;
      color: var(--negro);
    }

    .atendio-wrap {
      text-align: center;
      font-size: 0.7rem;
      color: #444;
      font-style: italic;
      border-top: 1px dashed var(--gris-linea);
      padding: 0.5rem 1.5rem;
      background: var(--blanco);
    }

    /* ── Responsivo ── */
    @media (max-width: 600px) {
      body { padding: 0.5rem 0.25rem 0; }
      .cara-label { margin-left: 0.25rem; }
      .encabezado { flex-direction: column; text-align: center; padding: 0.8rem; gap: 0.5rem; }
      .logo-wrap { width: 50px; height: 50px; }
      .encabezado-texto h1 { font-size: 0.65rem; }
      .encabezado-texto .titulo-doc { font-size: 0.85rem; }
      .frontal-body { flex-direction: column; align-items: center; padding: 0.8rem; }
      .foto-wrap { width: 90px; }
      .foto-box { width: 90px; height: 115px; }
      .campos-grid { grid-template-columns: 1fr; }
      .frontal-footer { padding: 0.6rem 0.8rem 0.8rem; }
      .firma-linea-sm { width: 85px; }
      .reverso-body { padding: 0.8rem; }
      .reverso-grid { grid-template-columns: 1fr; }
      .tipo-tramite-badge { justify-self: start; }
      .reverso-footer { padding: 0.6rem 0.8rem; flex-wrap: wrap; gap: 0.8rem; }
    }

    @media (max-width: 400px) {
      .frontal-footer { flex-direction: column; align-items: center; gap: 0.8rem; }
    }

    /* ── Print ── */
    @media print {
      body { background: none; padding: 0; gap: 1rem; }
      .hoja { box-shadow: none; outline: none; border-color: #999; width: 100%; max-width: 100%; margin-bottom: 1rem; }
      .btn-imprimir { display: none; }
      .cara-label { display: none; }
    }
  </style>
</head>
<body>

<button class="btn-imprimir" onclick="window.print()">&#128438; Imprimir</button>

<!-- ══ CARA FRONTAL ══ -->
<div class="cara-label">▶ Cara frontal</div>
<div class="hoja">

  <div class="encabezado">
    <div class="logo-wrap">
      <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
        <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" alt="Escudo Nacional">
      <?php else: ?>
        <div class="logo-placeholder">ESCUDO<br>NACIONAL</div>
      <?php endif; ?>
    </div>
    <div class="encabezado-texto">
      <h1>
        REPÚBLICA DE EL SALVADOR<br>
        DOCUMENTO DE IDENTIDAD PERSONAL<br>
        <?= htmlspecialchars($datos_municipio['alcaldia']) ?>,<br>
        DEPARTAMENTO DE <?= strtoupper(htmlspecialchars($datos_municipio['departamento'])) ?>
      </h1>
      <div class="titulo-doc">Carnet de Minoridad</div>
    </div>
    <div class="logo-wrap">
      <?php if (!empty($datos_municipio['logo'])): ?>
      <?php else: ?>
        <div class="logo-placeholder">LOGO<br>ALCALDÍA</div>
      <?php endif; ?>
    </div>
  </div>

  <div class="frontal-body">
    <div class="foto-wrap">
      <div class="foto-box">
        <?php if (!empty($datos_menor['foto'])): ?>
          <img src="<?= htmlspecialchars($datos_menor['foto']) ?>" alt="Foto del menor">
        <?php else: ?>
          <div class="foto-placeholder">FOTOGRAFÍA<br>DEL MENOR</div>
        <?php endif; ?>
      </div>
      <div class="numero-carnet"><?= htmlspecialchars($datos_menor['numero_carnet']) ?></div>
    </div>

    <div class="frontal-campos">
      <div class="campo">
        <label>Apellidos</label>
        <div class="valor"><?= htmlspecialchars($datos_menor['apellidos']) ?></div>
      </div>
      <div class="campo">
        <label>Nombres</label>
        <div class="valor"><?= htmlspecialchars($datos_menor['nombres']) ?></div>
      </div>
      <div class="campo">
        <label>Lugar y fecha de nacimiento</label>
        <div class="valor">
          <?= htmlspecialchars($datos_menor['lugar_nacimiento']) ?> &nbsp;|&nbsp;
          <?= htmlspecialchars($datos_menor['fecha_nacimiento']) ?>
        </div>
      </div>
      <div class="campos-grid">
        <div class="campo">
          <label>Fecha de expedición</label>
          <div class="valor"><?= htmlspecialchars($datos_menor['fecha_expedicion']) ?></div>
        </div>
        <div class="campo">
          <label>Fecha de vencimiento</label>
          <div class="valor"><?= htmlspecialchars($datos_menor['fecha_vencimiento']) ?></div>
        </div>
      </div>
    </div>
  </div>

  <div class="frontal-footer">
    <div class="sello-wrap">
      <div class="firma-linea-sm"></div>
      <div class="firma-label">Alcalde</div>
      <div class="firma-nombre-sm"><?= htmlspecialchars($datos_footer['alcalde']) ?></div>
    </div>
    <div class="sello-wrap">
      <div class="sello-circulo">SELLO<br>ALCALDÍA</div>
    </div>
    <div class="sello-wrap">
      <div class="firma-linea-sm"></div>
      <div class="firma-label">Secretario(a)</div>
      <div class="firma-nombre-sm"><?= htmlspecialchars($datos_footer['secretario']) ?></div>
    </div>
  </div>

</div><!-- /hoja frontal -->

<!-- ══ CARA POSTERIOR ══ -->
<div class="cara-label">▶ Cara posterior</div>
<div class="hoja">

  <div class="reverso-body">
    <div class="reverso-grid">

      <div class="campo full-col">
        <label>Dirección</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['direccion']) ?></div>
      </div>

      <div class="campo">
        <label>Nombre de la madre</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['nombre_madre']) ?></div>
      </div>

      <div style="display:flex;flex-direction:column;justify-content:flex-end;">
        <div class="tipo-tramite-badge">
          Tipo de trámite: <?= htmlspecialchars($datos_reverso['tipo_tramite']) ?>
        </div>
      </div>

      <div class="campo full-col">
        <label>Nombre del padre</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['nombre_padre']) ?></div>
      </div>

      <div class="campo">
        <label>Color de piel</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['color_piel']) ?></div>
      </div>
      <div class="campo">
        <label>Color de ojos</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['color_ojos']) ?></div>
      </div>
      <div class="campo">
        <label>Cabello</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['cabello']) ?></div>
      </div>
      <div class="campo">
        <label>Señales especiales</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['senales_especiales']) ?></div>
      </div>

      <div class="campo full-col">
        <label>Centro de estudios o lugar de trabajo</label>
        <div class="valor"><?= htmlspecialchars($datos_reverso['centro_estudios']) ?></div>
      </div>

    </div>
  </div>

  <div class="reverso-footer">
    <div class="sello-wrap">
      <div class="firma-linea-sm"></div>
      <div class="firma-label">Firma</div>
    </div>
    <div class="huella-box">
      <div class="huella-oval"></div>
      <span>Huella</span>
    </div>
    <div class="ministerio-wrap">
      MINISTERIO DE HACIENDA<br>
      <span class="ministerio-num">No <?= htmlspecialchars($datos_menor['numero_carnet']) ?> "A"</span>
    </div>
  </div>

  <div class="atendio-wrap"><?= htmlspecialchars($datos_footer['atendio']) ?></div>

</div><!-- /hoja posterior -->

</body>
</html>
