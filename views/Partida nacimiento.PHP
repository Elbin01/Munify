<?php
// =============================================
//  DATOS DE EJEMPLO - Reemplazar con tus datos
//  reales desde tu base de datos o formulario
// =============================================
$datos_municipio = [
    'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
    'departamento'  => 'Cabañas',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',
];

$datos_nacido = [
    'nombre'    => $_POST['p_nombre_inscrito'] ?? 'María José Rodríguez López',
    'lugar'     => $_POST['p_lugar_nac'] ?? 'Hospital Nacional de Ilobasco',
    'hora'      => $_POST['p_hora_nac'] ?? '03:45 PM',
    'fecha'     => $_POST['p_fecha_nac'] ?? '14 de abril de 2005',
    'sexo'      => $_POST['p_sexo'] ?? 'Femenino',
];

$datos_padre = [
    'nombre'    => $_POST['p_nombre_padre'] ?? 'Carlos Alberto Rodríguez Martínez',
    'dui'       => '01234567-8',
    'edad'      => $_POST['p_edad_padre'] ?? '32',
    'domicilio' => 'Colonia El Siete, Calle Principal #12, Ilobasco',
    'profesion' => $_POST['p_profesion_padre'] ?? 'Mecánico Automotriz',
];

$datos_madre = [
    'nombre'    => $_POST['p_nombre_madre'] ?? 'Ana Sofía López de Rodríguez',
    'dui'       => '09876543-2',
    'edad'      => $_POST['p_edad_madre'] ?? '29',
    'domicilio' => 'Colonia El Siete, Calle Principal #12, Ilobasco',
    'profesion' => $_POST['p_profesion_madre'] ?? 'Maestra de Educación Básica',
];

$datos_certificacion = [
    'informante'         => $_POST['p_nombre_padre'] ?? 'Carlos Alberto Rodríguez Martínez',
    'parentesco'         => 'Padre',
    'dui_informante'     => '05647382-9',
    'fecha_inscripcion'  => date('d de m de Y'),
];

$datos_footer = [
    'jefe_registros'  => 'Licda. Rosa Elena Méndez Castro',
    'informante'      => 'Carlos Alberto Rodríguez Martínez',
    'atendio'         => 'Asistente: María del Carmen Guevara',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Partida de Nacimiento – <?= htmlspecialchars($datos_nacido['nombre']) ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --negro:        #000000;
      --rojo-oscuro:  #550000;
      --rojo-medio:   #7a0000;
      --blanco:       #ffffff;
      --gris-claro:   #f5f5f5;
      --gris-linea:   #cccccc;
      --texto:        #111111;
      --sombra:       rgba(0, 0, 0, 0.2);
    }

    body {
      font-family: 'EB Garamond', Georgia, serif;
      background: #1a0000;
      color: var(--texto);
      min-height: 100vh;
      padding: 1.5rem 0.5rem;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    /* ── Hoja ── */
    .hoja {
      width: 100%;
      max-width: 760px;
      background: var(--blanco);
      border: 2px solid var(--negro);
      outline: 5px solid var(--rojo-oscuro);
      outline-offset: -10px;
      box-shadow: 0 6px 30px var(--sombra);
      position: relative;
      overflow: hidden;
    }

    /* ── Banda decorativa ── */
    .banda-top {
      background: linear-gradient(90deg, var(--negro) 0%, var(--rojo-oscuro) 50%, var(--negro) 100%);
      height: 8px;
    }

    .banda-bot {
      background: linear-gradient(90deg, var(--negro) 0%, var(--rojo-oscuro) 50%, var(--negro) 100%);
      height: 8px;
    }

    /* ── Encabezado ── */
    .encabezado {
      padding: 1.2rem 1.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      border-bottom: 2px solid var(--rojo-oscuro);
      background: var(--blanco);
    }

    .logo-wrap {
      width: 65px;
      height: 65px;
      flex-shrink: 0;
      border: 2px solid var(--rojo-oscuro);
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
      color: var(--rojo-oscuro);
      text-align: center;
      line-height: 1.3;
      padding: 0.2rem;
      font-family: 'Cinzel', serif;
    }

    .encabezado-texto {
      flex: 1;
      text-align: center;
    }

    .encabezado-texto h1 {
      font-family: 'Cinzel', serif;
      font-size: 0.82rem;
      color: var(--negro);
      letter-spacing: 0.06em;
      line-height: 1.4;
      font-weight: 700;
    }

    .encabezado-texto .subtitulo {
      font-size: 0.72rem;
      color: var(--negro);
      margin-top: 0.25rem;
      font-style: italic;
    }

    .encabezado-texto .titulo-doc {
      margin-top: 0.5rem;
      font-family: 'Cinzel', serif;
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--negro);
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }

    /* ── Cuerpo ── */
    .cuerpo {
      padding: 1rem 1.5rem 0.8rem;
      display: flex;
      flex-direction: column;
      gap: 0.9rem;
    }

    /* ── Cards ── */
    .card {
      border: 1px solid var(--gris-linea);
      border-radius: 3px;
      overflow: hidden;
      page-break-inside: avoid;
    }

    .card-header {
      background: var(--blanco);
      color: var(--negro);
      font-family: 'Cinzel', serif;
      font-size: 0.68rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 0.35rem 0.8rem;
      display: flex;
      align-items: center;
      gap: 0.4rem;
      border-bottom: 1px solid var(--gris-linea);
    }

    .card-header::before {
      content: '';
      display: inline-block;
      width: 12px;
      height: 2px;
      background: var(--negro);
      flex-shrink: 0;
    }

    .card-body {
      padding: 0.75rem 0.8rem;
      background: var(--gris-claro);
    }

    /* ── Grid de campos ── */
    .campos {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 0.55rem 1.2rem;
    }

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

    .campo.full { grid-column: 1 / -1; }

    /* ── Footer: Firmas ── */
    .footer {
      padding: 0.9rem 1.5rem 1rem;
      border-top: 2px solid var(--rojo-oscuro);
    }

    .firmas {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      margin-bottom: 1rem;
    }

    .firma-bloque {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.25rem;
    }

    .firma-linea {
      width: 100%;
      border-bottom: 1.5px solid var(--negro);
      height: 35px;
    }

    .firma-titulo {
      font-family: 'Cinzel', serif;
      font-size: 0.62rem;
      color: var(--negro);
      text-align: center;
      letter-spacing: 0.06em;
      text-transform: uppercase;
    }

    .firma-nombre {
      font-size: 0.75rem;
      font-style: italic;
      color: var(--negro);
      text-align: center;
    }

    .atendio-wrap {
      text-align: center;
      font-size: 0.72rem;
      color: #444;
      font-style: italic;
      border-top: 1px dashed var(--gris-linea);
      padding-top: 0.6rem;
    }

    /* ── Botón imprimir ── */
    .btn-imprimir {
      position: fixed;
      top: 1rem;
      right: 1rem;
      padding: 0.35rem 0.8rem;
      background: var(--negro);
      color: var(--blanco);
      border: 2px solid var(--rojo-oscuro);
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

    .btn-imprimir:hover { background: var(--rojo-oscuro); }

    /* ── Responsivo ── */
    @media (max-width: 600px) {
      body { padding: 0.5rem 0.25rem; }

      .encabezado {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
        gap: 0.6rem;
      }

      .logo-wrap { width: 50px; height: 50px; }

      .encabezado-texto h1 { font-size: 0.72rem; }
      .encabezado-texto .titulo-doc { font-size: 0.9rem; }

      .cuerpo { padding: 0.75rem 0.75rem 0.5rem; gap: 0.7rem; }

      .campos { grid-template-columns: 1fr 1fr; }

      .campo .valor { font-size: 0.75rem; }

      .firmas { grid-template-columns: 1fr; gap: 1rem; }

      .footer { padding: 0.75rem 0.75rem 0.8rem; }
    }

    @media (max-width: 400px) {
      .campos { grid-template-columns: 1fr; }
    }

    /* ── Print ── */
    @media print {
      body {
        background: none;
        padding: 0;
        margin: 0;
      }

      .hoja {
        box-shadow: none;
        outline: none;
        border-color: #999;
        width: 100%;
        max-width: 100%;
        page-break-after: avoid;
      }

      .btn-imprimir { display: none; }

      .card { page-break-inside: avoid; }

      .cuerpo { padding: 0.8rem 1.2rem; }
      .footer { padding: 0.7rem 1.2rem 0.8rem; }
    }
  </style>
</head>
<body>

<div class="hoja">

  <div class="banda-top"></div>

  <!-- ENCABEZADO -->
  <div class="encabezado">

    <div class="logo-wrap">
      <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
        <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" alt="Escudo Nacional de El Salvador">
      <?php else: ?>
        <div class="logo-placeholder">ESCUDO<br>NACIONAL</div>
      <?php endif; ?>
    </div>

    <div class="encabezado-texto">
      <h1>
        <?= htmlspecialchars($datos_municipio['alcaldia']) ?><br>
        Departamento de <?= htmlspecialchars($datos_municipio['departamento']) ?>
        – <?= htmlspecialchars($datos_municipio['pais']) ?>
      </h1>
      <div class="subtitulo">Registro del Estado Familiar</div>
      <div class="titulo-doc">Partida de Nacimiento</div>
    </div>



  </div>

  <!-- CUERPO -->
  <div class="cuerpo">

    <!-- DATOS DEL NACIDO -->
    <div class="card">
      <div class="card-header">Datos del Nacido</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo full">
            <label>Nombre completo</label>
            <div class="valor"><?= htmlspecialchars($datos_nacido['nombre']) ?></div>
          </div>
          <div class="campo">
            <label>Lugar de nacimiento</label>
            <div class="valor"><?= htmlspecialchars($datos_nacido['lugar']) ?></div>
          </div>
          <div class="campo">
            <label>Fecha de nacimiento</label>
            <div class="valor"><?= htmlspecialchars($datos_nacido['fecha']) ?></div>
          </div>
          <div class="campo">
            <label>Hora de nacimiento</label>
            <div class="valor"><?= htmlspecialchars($datos_nacido['hora']) ?></div>
          </div>
          <div class="campo">
            <label>Sexo</label>
            <div class="valor"><?= htmlspecialchars($datos_nacido['sexo']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- DATOS DEL PADRE -->
    <div class="card">
      <div class="card-header">Datos del Padre</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo full">
            <label>Nombre completo</label>
            <div class="valor"><?= htmlspecialchars($datos_padre['nombre']) ?></div>
          </div>
          <div class="campo">
            <label>DUI</label>
            <div class="valor"><?= htmlspecialchars($datos_padre['dui']) ?></div>
          </div>
          <div class="campo">
            <label>Edad</label>
            <div class="valor"><?= htmlspecialchars($datos_padre['edad']) ?> años</div>
          </div>
          <div class="campo">
            <label>Profesión u oficio</label>
            <div class="valor"><?= htmlspecialchars($datos_padre['profesion']) ?></div>
          </div>
          <div class="campo full">
            <label>Domicilio</label>
            <div class="valor"><?= htmlspecialchars($datos_padre['domicilio']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- DATOS DE LA MADRE -->
    <div class="card">
      <div class="card-header">Datos de la Madre</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo full">
            <label>Nombre completo</label>
            <div class="valor"><?= htmlspecialchars($datos_madre['nombre']) ?></div>
          </div>
          <div class="campo">
            <label>DUI</label>
            <div class="valor"><?= htmlspecialchars($datos_madre['dui']) ?></div>
          </div>
          <div class="campo">
            <label>Edad</label>
            <div class="valor"><?= htmlspecialchars($datos_madre['edad']) ?> años</div>
          </div>
          <div class="campo">
            <label>Profesión u oficio</label>
            <div class="valor"><?= htmlspecialchars($datos_madre['profesion']) ?></div>
          </div>
          <div class="campo full">
            <label>Domicilio</label>
            <div class="valor"><?= htmlspecialchars($datos_madre['domicilio']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- CERTIFICACIÓN -->
    <div class="card">
      <div class="card-header">Certificación</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo">
            <label>Informante</label>
            <div class="valor"><?= htmlspecialchars($datos_certificacion['informante']) ?></div>
          </div>
          <div class="campo">
            <label>Parentesco</label>
            <div class="valor"><?= htmlspecialchars($datos_certificacion['parentesco']) ?></div>
          </div>
          <div class="campo">
            <label>DUI del informante</label>
            <div class="valor"><?= htmlspecialchars($datos_certificacion['dui_informante']) ?></div>
          </div>
          <div class="campo">
            <label>Fecha de inscripción</label>
            <div class="valor"><?= htmlspecialchars($datos_certificacion['fecha_inscripcion']) ?></div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /cuerpo -->

  <!-- FOOTER: FIRMAS -->
  <div class="footer">
    <div class="firmas">
      <div class="firma-bloque">
        <div class="firma-linea"></div>
        <div class="firma-titulo">Jefe de Registros Familiares</div>
        <div class="firma-nombre"><?= htmlspecialchars($datos_footer['jefe_registros']) ?></div>
      </div>
      <div class="firma-bloque">
        <div class="firma-linea"></div>
        <div class="firma-titulo">Firma del Informante</div>
        <div class="firma-nombre"><?= htmlspecialchars($datos_footer['informante']) ?></div>
      </div>
    </div>
    <div class="atendio-wrap">
      <?= htmlspecialchars($datos_footer['atendio']) ?>
    </div>
  </div>

  <div class="banda-bot"></div>

</div><!-- /hoja -->

<button class="btn-imprimir" onclick="window.print()">&#128438; Imprimir</button>

</body>
</html>
