
<?php
// =============================================
//  DATOS DE EJEMPLO - Reemplazar con tus datos
//  reales desde tu base de datos o formulario
// =============================================
$datos_municipio = [
    'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
    'departamento'  => 'Cabañas',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',          // Escudo Nacional de El Salvador
    'logo'          => 'assets/Img/escudo_alcaldia.png',  // Logo de tu alcaldía
];

$datos_nacido = [
    'nombre'    => 'María José Rodríguez López',
    'lugar'     => 'Hospital Nacional de Ilobasco',
    'hora'      => '03:45 PM',
    'fecha'     => '14 de abril de 2005',
    'sexo'      => 'Femenino',
];

$datos_padre = [
    'nombre'    => 'Carlos Alberto Rodríguez Martínez',
    'dui'       => '01234567-8',
    'edad'      => '32',
    'domicilio' => 'Colonia El Siete, Calle Principal #12, ilobasco',
    'profesion' => 'Mecánico Automotriz',
];

$datos_madre = [
    'nombre'    => 'Ana Sofía López de Rodríguez',
    'dui'       => '09876543-2',
    'edad'      => '29',
    'domicilio' => 'Colonia El Siete, Calle Principal #12, Ilobasco',
    'profesion' => 'Maestra de Educación Básica',
];

$datos_certificacion = [
    'informante'         => 'Carlos Alberto Rodríguez Martínez',
    'parentesco'         => 'Papa',
    'dui_informante'     => '05647382-9',
    'fecha_inscripcion'  => '16 de abril de 2005',
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
    /* ── Reset & Base ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap');

    :root {
      --azul-oscuro:  #1C3166;
      --azul-medio:   #00A9D4;
      --azul-claro:   #e8f6fb;
      --dorado:       #40FFDC;
      --dorado-claro: #a0fff0;
      --texto:        #1a1a1a;
      --gris-linea:   #b0dce8;
      --blanco:       #ffffff;
      --sombra:       rgba(28, 49, 102, 0.15);
    }

    body {
      font-family: 'EB Garamond', Georgia, serif;
      background: #240047;
      color: var(--texto);
      min-height: 100vh;
      padding: 2rem 1rem;
      display: flex;
      justify-content: center;
    }

    /* ── Hoja ── */
    .hoja {
      width: 800px;
      max-width: 100%;
      background: var(--blanco);
      border: 3px double var(--azul-medio);
      outline: 6px solid var(--azul-oscuro);
      outline-offset: -12px;
      padding: 0;
      box-shadow: 0 8px 40px var(--sombra);
      position: relative;
    }

    /* ── Banda decorativa superior ── */
    .banda-top {
      background: linear-gradient(135deg, var(--azul-oscuro) 0%, var(--azul-medio) 100%);
      height: 10px;
    }

    /* ── Encabezado ── */
    .encabezado {
      padding: 2rem 2.5rem 1.2rem;
      display: flex;
      align-items: center;
      gap: 1.5rem;
      border-bottom: 2px solid var(--dorado);
    }

    .logo-wrap {
      width: 80px;
      height: 80px;
      flex-shrink: 0;
      border: 2px solid var(--dorado);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--azul-claro);
      overflow: hidden;
    }

    .logo-wrap img { width: 100%; height: 100%; object-fit: contain; }

    .logo-placeholder {
      font-size: 11px;
      color: var(--azul-medio);
      text-align: center;
      line-height: 1.3;
      padding: 0.25rem;
    }

    .encabezado-texto { flex: 1; text-align: center; }

    .encabezado-texto h1 {
      font-family: 'Cinzel', serif;
      font-size: 1.1rem;
      color: var(--azul-oscuro);
      letter-spacing: 0.08em;
      line-height: 1.35;
    }

    .encabezado-texto .subtitulo {
      font-size: 0.85rem;
      color: var(--azul-medio);
      margin-top: 0.3rem;
      font-style: italic;
    }

    .encabezado-texto .titulo-doc {
      margin-top: 0.8rem;
      font-family: 'Cinzel', serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--dorado);
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }

    /* ── Cuerpo ── */
    .cuerpo {
      padding: 1.5rem 2.5rem 1rem;
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }

    /* ── Cards ── */
    .card {
      border: 1px solid var(--gris-linea);
      border-radius: 4px;
      overflow: hidden;
    }

    .card-header {
      background: var(--azul-oscuro);
      color: var(--dorado-claro);
      font-family: 'Cinzel', serif;
      font-size: 0.78rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 0.45rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .card-header::before {
      content: '';
      display: inline-block;
      width: 16px;
      height: 2px;
      background: var(--dorado);
      flex-shrink: 0;
    }

    .card-body {
      padding: 1rem;
      background: #f0fafd;
    }

    /* ── Grid de campos ── */
    .campos {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 0.75rem 1.5rem;
    }

    .campo { display: flex; flex-direction: column; gap: 2px; }

    .campo label {
      font-size: 0.68rem;
      font-weight: 600;
      color: var(--azul-medio);
      letter-spacing: 0.06em;
      text-transform: uppercase;
      font-family: 'Cinzel', serif;
    }

    .campo .valor {
      font-size: 0.95rem;
      color: var(--texto);
      border-bottom: 1px solid var(--gris-linea);
      padding-bottom: 3px;
      min-height: 1.4em;
    }

    /* ── Campo ancho completo ── */
    .campo.full { grid-column: 1 / -1; }


    /* ── Footer ── */
    .footer {
      padding: 1.2rem 2.5rem 1.5rem;
      border-top: 2px solid var(--dorado);
    }

    .firmas {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-bottom: 1.4rem;
    }

    .firma-bloque { display: flex; flex-direction: column; align-items: center; gap: 0.3rem; }

    .firma-linea {
      width: 100%;
      border-bottom: 1.5px solid var(--azul-oscuro);
      height: 40px;
    }

    .firma-titulo {
      font-family: 'Cinzel', serif;
      font-size: 0.7rem;
      color: var(--azul-oscuro);
      text-align: center;
      letter-spacing: 0.07em;
    }

    .firma-nombre {
      font-size: 0.82rem;
      font-style: italic;
      color: var(--azul-medio);
      text-align: center;
    }

    .atendio-wrap {
      text-align: center;
      font-size: 0.82rem;
      color: #555;
      font-style: italic;
      border-top: 1px dashed var(--gris-linea);
      padding-top: 0.8rem;
    }

    /* ── Banda decorativa inferior ── */
    .banda-bot {
      background: linear-gradient(135deg, var(--azul-medio) 0%, var(--azul-oscuro) 100%);
      height: 10px;
    }

    /* ── Botón imprimir flotante ── */
    .btn-imprimir {
      position: fixed;
      top: 1rem;
      right: 1rem;
      padding: 0.4rem 0.9rem;
      background: var(--azul-oscuro);
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-family: 'Cinzel', serif;
      font-size: 0.72rem;
      letter-spacing: 0.08em;
      box-shadow: 0 2px 8px rgba(0,0,0,0.25);
      z-index: 999;
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }

    .btn-imprimir:hover { background: var(--azul-medio); }

    /* ── Print ── */
    @media print {
      body { background: none; padding: 0; }
      .hoja { box-shadow: none; outline: none; border-color: #999; width: 100%; }
      .btn-imprimir { display: none; }
    }
  </style>
</head>
<body>

<!-- ══════════════════════════════════════════
     PLANTILLA PARTIDA DE NACIMIENTO
     ══════════════════════════════════════════ -->
<div class="hoja">

  <div class="banda-top"></div>

  <!-- ENCABEZADO -->
  <div class="encabezado">

    <!-- Escudo Nacional (izquierda) -->
    <div class="logo-wrap">
      <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
        <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" alt="Escudo Nacional de El Salvador">
      <?php else: ?>
        <div class="logo-placeholder">ESCUDO<br>NACIONAL</div>
      <?php endif; ?>
    </div>

    <!-- Texto central -->
    <div class="encabezado-texto">
      <h1>
        <?= htmlspecialchars($datos_municipio['alcaldia']) ?><br>
        Departamento de <?= htmlspecialchars($datos_municipio['departamento']) ?>
        – <?= htmlspecialchars($datos_municipio['pais']) ?>
      </h1>
      <div class="subtitulo">Registro del Estado Familiar</div>
      <div class="titulo-doc">Partida de Nacimiento</div>
    </div>

    <!-- Logo Alcaldía (derecha) -->
    <div class="logo-wrap">
      <?php if (!empty($datos_municipio['logo'])): ?>
        <img src="<?= htmlspecialchars($datos_municipio['logo']) ?>" alt="Logo Alcaldía">
      <?php else: ?>
        <div class="logo-placeholder">LOGO<br>ALCALDÍA</div>
      <?php endif; ?>
    </div>

  </div>

  <!-- CUERPO -->
  <div class="cuerpo">

    <!-- ── CARD 1: DATOS DEL NACIDO ── -->
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

    <!-- ── CARD 2: DATOS DEL PADRE ── -->
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

    <!-- ── CARD 3: DATOS DE LA MADRE ── -->
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

    <!-- ── CARD 4: CERTIFICACIÓN ── -->
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
