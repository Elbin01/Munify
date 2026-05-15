<?php
// =============================================
//  DATOS DEL MUNICIPIO - Ajusta según tu entorno
// =============================================
$datos_municipio = [
    'alcaldia'      => $_POST['alcaldia'] ?? 'Alcaldía Municipal',
    'departamento'  => $_POST['departamento'] ?? '',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',
];

// =============================================
//  DATOS DEL FALLECIDO
// =============================================
$datos_fallecido = [
    'nombre'       => $_POST['nombre_fallecido'] ?? '',
    'dui'          => $_POST['dui_fallecido'] ?? '',
    'fecha_def'    => $_POST['fecha_defuncion'] ?? '',
    'hora_def'     => $_POST['hora_defuncion'] ?? '',
    'nacionalidad' => $_POST['nacionalidad'] ?? 'Salvadoreña',
    'causa'        => $_POST['causa_fallecimiento'] ?? '',
];

// =============================================
//  DATOS DEL DECLARANTE
// =============================================
$datos_declarante = [
    'nombre'     => $_POST['nombre_declarante'] ?? '',
    'parentesco' => $_POST['parentesco_declarante'] ?? '',
    'dui'        => $_POST['dui_declarante'] ?? '',
];

// =============================================
//  FECHA DE REGISTRO (incluye hora)
// =============================================
$datos_registro = [
    'fecha_hora' => $_POST['fecha_registro'] ?? '',
];

// =============================================
//  DATOS DE FIRMAS (footer)
// =============================================
$datos_footer = [
    'jefe_registros' => $_POST['jefe_registros'] ?? 'Licda. Rosa Elena Méndez Castro',
    'atendio'        => $_POST['atendio'] ?? 'Asistente: María del Carmen Guevara',
    'informante'     => $_POST['nombre_declarante'] ?? '', // nombre del declarante para la firma
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acta de Defunción</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --negro:       #000000;
      --azul-oscuro: #003366;
      --azul-medio:  #005599;
      --azul-claro:  #e8f0f8;
      --blanco:      #ffffff;
      --gris-claro:  #f4f7fb;
      --gris-linea:  #c5d5e8;
      --texto:       #111111;
      --sombra:      rgba(0, 51, 102, 0.15);
    }

    html { overflow-x: hidden; margin: 0; padding: 0; }

    body {
      font-family: 'EB Garamond', Georgia, serif;
      background: #e9edf2;
      color: var(--texto);
      margin: 0;
      padding: 20px;
      overflow-x: hidden;
    }

    /* ── Hoja principal ── */
    .hoja {
      width: 850px;
      min-height: auto;
      margin: 20px auto;
      background: var(--blanco);
      border: 1px solid var(--gris-linea);
      box-shadow: 0 0 15px rgba(0,0,0,0.08);
      display: flex;
      flex-direction: column;
      box-sizing: border-box;
      overflow: hidden;
      border-radius: 4px;
    }

    /* ── Encabezado ── */
    .encabezado {
      padding: 1.2rem 1.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 1.2rem;
      border-bottom: 2px solid var(--azul-oscuro);
      background: var(--blanco);
      box-sizing: border-box;
      width: 100%;
    }

    .logo-wrap {
      width: 70px;
      height: 70px;
      flex-shrink: 0;
      border: 2px solid var(--azul-oscuro);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--azul-claro);
      overflow: hidden;
    }

    .logo-wrap img { width: 100%; height: 100%; object-fit: contain; }

    .logo-placeholder {
      font-size: 9px;
      color: var(--azul-oscuro);
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
      font-size: 0.88rem;
      color: var(--negro);
      letter-spacing: 0.06em;
      line-height: 1.5;
      font-weight: 700;
    }

    .encabezado-texto .subtitulo {
      font-size: 0.75rem;
      color: var(--azul-medio);
      margin-top: 0.25rem;
      font-style: italic;
    }

    .encabezado-texto .titulo-doc {
      margin-top: 0.5rem;
      font-family: 'Cinzel', serif;
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--negro);
      letter-spacing: 0.12em;
      text-transform: uppercase;
      display: inline-block;
    }

    /* ── Cuerpo ── */
    .cuerpo {
      padding: 1.2rem 1.5rem 1rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
      flex: 1;
      box-sizing: border-box;
      width: 100%;
      overflow-x: hidden;
    }

    /* ── Tarjetas (cards) ── */
    .card {
      border: 1px solid var(--gris-linea);
      border-radius: 3px;
      overflow: hidden;
      page-break-inside: avoid;
      box-sizing: border-box;
      width: 100%;
    }

    .card-header {
      background: var(--azul-oscuro);
      color: var(--blanco);
      font-family: 'Cinzel', serif;
      font-size: 0.7rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 0.4rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .card-header::before {
      content: '';
      display: inline-block;
      width: 14px;
      height: 2px;
      background: var(--blanco);
      flex-shrink: 0;
      opacity: 0.7;
    }

    .card-body {
      padding: 0.85rem 1rem;
      background: var(--gris-claro);
    }

    /* ── Grid de campos ── */
    .campos {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 0.6rem 1.5rem;
    }

    .campo { display: flex; flex-direction: column; gap: 2px; }

    .campo label {
      font-size: 0.6rem;
      font-weight: 700;
      color: var(--azul-oscuro);
      letter-spacing: 0.08em;
      text-transform: uppercase;
      font-family: 'Cinzel', serif;
    }

    .campo .valor {
      font-size: 0.85rem;
      color: var(--texto);
      border-bottom: 1px solid var(--gris-linea);
      padding-bottom: 3px;
      min-height: 1.4em;
    }

    .campo.full { grid-column: 1 / -1; }

    /* ── Footer: Firmas ── */
    .footer {
      padding: 1rem 1.5rem 1.2rem;
      border-top: 2px solid var(--azul-oscuro);
      background: var(--blanco);
      box-sizing: border-box;
      width: 100%;
    }

    .firmas {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-bottom: 1rem;
    }

    .firma-bloque {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.3rem;
    }

    .firma-linea {
      width: 50%;
      border-bottom: 1.5px solid var(--negro);
      height: 10px;
    }

    .firma-titulo {
      font-family: 'Cinzel', serif;
      font-size: 0.62rem;
      color: var(--azul-oscuro);
      text-align: center;
      letter-spacing: 0.07em;
      text-transform: uppercase;
    }

    .firma-nombre {
      font-size: 0.78rem;
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
      padding: 0.4rem 0.9rem;
      background: var(--azul-oscuro);
      color: var(--blanco);
      border: 2px solid var(--negro);
      border-radius: 3px;
      cursor: pointer;
      font-family: 'Cinzel', serif;
      font-size: 0.65rem;
      letter-spacing: 0.08em;
      box-shadow: 0 2px 8px rgba(0,0,0,0.25);
      z-index: 999;
      display: flex;
      align-items: center;
      gap: 0.4rem;
      transition: background 0.2s;
    }

    .btn-imprimir:hover { background: var(--negro); }

    /* ── Responsivo ── */
    @media (max-width: 600px) {
      .encabezado {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
        gap: 0.6rem;
      }
      .logo-wrap { width: 55px; height: 55px; }
      .encabezado-texto h1 { font-size: 0.75rem; }
      .encabezado-texto .titulo-doc { font-size: 0.95rem; }
      .cuerpo { padding: 0.8rem 0.8rem 0.6rem; gap: 0.8rem; }
      .campos { grid-template-columns: 1fr 1fr; }
      .campo .valor { font-size: 0.78rem; }
      .firmas { grid-template-columns: 1fr; gap: 1rem; }
      .footer { padding: 0.4rem 1.5rem 1rem; }
    }

    @media (max-width: 400px) {
      .campos { grid-template-columns: 1fr; }
    }

    /* ── Impresión ── */
    @media print {
      body {
        background: white;
        padding: 0;
      }
      .hoja {
        width: 100%;
        margin: 0;
        border: none;
        box-shadow: none;
        border-radius: 0;
      }
      .btn-imprimir { display: none; }
      .card { page-break-inside: avoid; }
      .cuerpo { padding: 0.8rem 1.5rem; }
      .footer { padding: 0.8rem 1.5rem; }
    }
  </style>
</head>
<body>

<div class="hoja">

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
      <div class="titulo-doc">Acta de Defunción</div>
    </div>
  </div>

  <!-- CUERPO -->
  <div class="cuerpo">

    <!-- DATOS DEL FALLECIDO -->
    <div class="card">
      <div class="card-header">Datos del Fallecido</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo full">
            <label>Nombre completo</label>
            <div class="valor"><?= htmlspecialchars($datos_fallecido['nombre']) ?></div>
          </div>
          <div class="campo">
            <label>DUI</label>
            <div class="valor"><?= htmlspecialchars($datos_fallecido['dui']) ?></div>
          </div>
          <div class="campo">
            <label>Fecha de defunción</label>
            <div class="valor"><?= htmlspecialchars($datos_fallecido['fecha_def']) ?></div>
          </div>
          <div class="campo">
            <label>Hora de defunción</label>
            <div class="valor"><?= htmlspecialchars($datos_fallecido['hora_def']) ?></div>
          </div>
          <div class="campo">
            <label>Nacionalidad</label>
            <div class="valor"><?= htmlspecialchars($datos_fallecido['nacionalidad']) ?></div>
          </div>
          <div class="campo full">
            <label>Causa del fallecimiento</label>
            <div class="valor"><?= htmlspecialchars($datos_fallecido['causa']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- DATOS DEL DECLARANTE -->
    <div class="card">
      <div class="card-header">Datos del Declarante</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo full">
            <label>Nombre del declarante</label>
            <div class="valor"><?= htmlspecialchars($datos_declarante['nombre']) ?></div>
          </div>
          <div class="campo">
            <label>Parentesco</label>
            <div class="valor"><?= htmlspecialchars($datos_declarante['parentesco']) ?></div>
          </div>
          <div class="campo">
            <label>DUI del declarante</label>
            <div class="valor"><?= htmlspecialchars($datos_declarante['dui']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- FECHA DE REGISTRO -->
    <div class="card">
      <div class="card-header">Registro</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo full">
            <label>Fecha de registro</label>
            <div class="valor"><?= htmlspecialchars($datos_registro['fecha_hora']) ?></div>
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
        <div class="firma-titulo">Firma del Declarante</div>
        <div class="firma-nombre"><?= htmlspecialchars($datos_footer['informante']) ?></div>
      </div>
    </div>
    <div class="atendio-wrap">
      <?= htmlspecialchars($datos_footer['atendio']) ?>
    </div>
  </div>

</div><!-- /hoja -->

<button class="btn-imprimir" onclick="confirmarImpresion()">
  🖨️ Imprimir
</button>

<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true
});

function confirmarImpresion(){

    Swal.fire({

        title: '¿Imprimir Partida?',
        text: 'Verifique que toda la información sea correcta.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#003366',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, imprimir',
        cancelButtonText: 'Cancelar'

    }).then((result) => {

        if(result.isConfirmed){

            Toast.fire({
                icon:'info',
                title:'Preparando documento...'
            });

            setTimeout(() => {

                window.print();

            },2000);

        }

    });

}

</script>
</body>
</html>