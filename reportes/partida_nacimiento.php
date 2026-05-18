<?php
require_once __DIR__ . '/../models/PartidaModel.php';

$id_partida = $_GET['id'] ?? null;

if (!$id_partida) {
    die("Error: No se proporcionó un ID de partida.");
}

$modelo = new PartidaModel();
$datos = $modelo->obtenerPorId($id_partida);

if (!$datos) {
    die("Error: No se encontró la partida con el ID proporcionado.");
}

// Datos de la alcaldía (Se mantienen fijos o configurables)
$datos_municipio = [
    'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
    'departamento'  => 'Cabañas',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',
];

// Función para formatear fecha a español
function fechaEspañol($fecha) {
    if (!$fecha) return '---';
    $dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    $timestamp = strtotime($fecha);
    $dia = date('d', $timestamp);
    $mes = $meses[date('n', $timestamp) - 1];
    $año = date('Y', $timestamp);
    return "$dia de $mes de $año";
}

// Mapeo de datos del nacido desde la base de datos
$datos_nacido = [
    'nombre'    => (string)($datos['nombres'] . ' ' . $datos['apellidos']),
    'lugar'     => (string)($datos['lugar_nacimiento'] ?: $datos['hospital'] ?: '---'),
    'hora'      => (string)($datos['hora_nacimiento'] ?: '---'),
    'fecha'     => fechaEspañol($datos['fecha_nacimiento']),
    'sexo'      => ($datos['sexo'] == 'M' ? 'Masculino' : 'Femenino'),
    'numero'    => (string)$datos['numero_partida'],
    'libro'     => (string)$datos['libro'],
    'folio'     => (string)$datos['folio'],
];

// Datos de los padres (Si existen en la tabla o como texto)
$datos_padre = [
    'nombre'    => (string)($datos['nombre_padre'] ?: 'No registrado'),
    'dui'       => 'No registrado',
    'edad'      => '---',
    'domicilio' => '---',
    'profesion' => '---',
];

$datos_madre = [
    'nombre'    => (string)($datos['nombre_madre'] ?: 'No registrado'),
    'dui'       => 'No registrado',
    'edad'      => '---',
    'domicilio' => '---',
    'profesion' => '---',
];

$informante_default = $datos['nombre_padre'] ?: $datos['nombre_madre'] ?: 'No especificado';

$datos_certificacion = [
    'informante'         => (string)$informante_default,
    'parentesco'         => ($datos['nombre_padre'] ? 'Padre' : ($datos['nombre_madre'] ? 'Madre' : '---')),
    'dui_informante'     => '---',
    'fecha_inscripcion'  => fechaEspañol($datos['fecha_emision']),
];

$datos_footer = [
    'jefe_registros'  => 'Licda. Rosa Elena Méndez Castro',
    'informante'      => (string)$informante_default,
    'atendio'         => 'Sistema Munify',
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

    html {
      overflow-x: hidden;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'EB Garamond', Georgia, serif;
      background: var(--blanco);
      color: var(--texto);
      display: block;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      width: 100vw;
    }

    /* ── Hoja ── */
    .hoja {
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      background: var(--blanco);
      border: none;
      display: flex;
      flex-direction: column;
      box-sizing: border-box;
      min-height: 100vh;
    }

    /* ── Banda decorativa ── */
    .banda-top,
    .banda-bot 
     {
      display: none;
      background: linear-gradient(90deg, var(--negro) 0%, var(--azul-oscuro) 40%, var(--azul-medio) 60%, var(--negro) 100%);
      height: 8px;
      flex-shrink: 0;
      
    }

    /* ── Encabezado ── */
    .encabezado {
      padding: 0.8rem 1.2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
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
      padding: 0.8rem 1.2rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      flex: 1;
      box-sizing: border-box;
      width: 100%;
      overflow-x: hidden;
    }

    /* ── Cards ── */
    .card {
      border: 1px solid var(--gris-linea);
      border-radius: 3px;
      overflow: hidden;
      page-break-inside: avoid;
      box-sizing: border-box;
      width: 100%;
    }

    /* ── Contenedor Padres (Lado a Lado) ── */
    .padres-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
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
      padding: 0.6rem 1rem;
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
      padding: 0.8rem 1.2rem;
      border-top: 2px solid var(--azul-oscuro);
      background: var(--blanco);
      box-sizing: border-box;
      width: 100%;
    }

    .firmas {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-top: 2.2rem;
      margin-bottom: 1.2rem;
    }

    .firma-bloque {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.3rem;
      position: relative;
    }

    .firma-imagen-wrap {
      height: 65px;
      margin-bottom: -65px;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 5;
      pointer-events: none;
      position: relative;
      top: -25px;
    }

    .firma-imagen-wrap img {
      height: 100%;
      max-width: 180px;
      object-fit: contain;
    }

    .firma-linea {
      width: 60%;
      border-bottom: 1.5px solid var(--negro);
      margin-top: 2.8rem;
      margin-bottom: 0.3rem;
      position: relative;
      z-index: 1;
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

    /* ── Botón Volver ── */
    .btn-volver {
      position: fixed;
      bottom: 1rem;
      left: 1rem;
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
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-volver:hover { 
      background: var(--negro); 
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(28, 49, 102, 0.4);
    }

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

      .padres-container {
        grid-template-columns: 1fr;
        gap: 0.8rem;
      }

      .firmas { grid-template-columns: 1fr; gap: 1rem; }

      .footer { padding: 0.4rem 1.5rem 1rem; }
    }

    @media (max-width: 400px) {
      .campos { grid-template-columns: 1fr; }
    }

    /* ── Print ── */
    @media print {
      /* Ocultar elementos de SweetAlert en la impresión y evitar que interfieran con el layout */
      .swal2-container, .swal2-backdrop, .swal2-popup, .swal2-overlay, .swal2-modal {
        display: none !important;
      }
      body.swal2-shown, html.swal2-shown {
        overflow: visible !important;
        height: auto !important;
      }

      @page {
        margin: 0.5cm;
        size: letter;
      }
      body { background: none; }

      .hoja {
        box-shadow: none;
        border-color: #999;
        width: 100%;
        min-height: 0;
        max-width: none;
      }

      .btn-imprimir, .btn-volver { display: none; }

      .card { page-break-inside: avoid; }

      .cuerpo { padding: 0.7rem 1.3rem; gap: 0.7rem; }
      .footer { padding: 0.7rem 1.3rem; }
      .card-body { padding: 0.5rem 1.1rem; }
      .campos { gap: 0.4rem 1.3rem; }
      .encabezado { padding: 0.7rem 1.3rem; }
      .encabezado-texto h1 { font-size: 0.88rem; }
      .encabezado-texto .titulo-doc { font-size: 1.05rem; margin-top: 0.35rem; }
      .campo label { font-size: 0.6rem; }
      .campo .valor { font-size: 0.88rem; }
      .padres-container {
        grid-template-columns: 1fr 1fr !important;
        gap: 0.8rem;
      }
      .card-header { padding: 0.35rem 1.1rem; font-size: 0.8rem; }
      .firmas { gap: 1.8rem; margin-bottom: 0.7rem; }
      .atendio-wrap { padding-top: 0.45rem; font-size: 0.75rem; }
    }
  </style>
</head>
<body>

<div class="hoja">

  <!-- ENCABEZADO -->
  <div class="encabezado">

    <div class="logo-wrap">
      <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
        <img src="<?= htmlspecialchars((string)$datos_municipio['escudo_nacion']) ?>" alt="Escudo Nacional de El Salvador">
      <?php else: ?>
        <div class="logo-placeholder">ESCUDO<br>NACIONAL</div>
      <?php endif; ?>
    </div>

    <div class="encabezado-texto">
      <h1>
        <?= htmlspecialchars((string)$datos_municipio['alcaldia']) ?><br>
        Departamento de <?= htmlspecialchars((string)$datos_municipio['departamento']) ?>
        – <?= htmlspecialchars((string)$datos_municipio['pais']) ?>
      </h1>
      <div class="subtitulo">Registro del Estado Familiar</div>
      <div class="titulo-doc">Partida de Nacimiento</div>
    </div>

  </div>

  <!-- CUERPO -->
  <div class="cuerpo">

    <!-- DATOS DE REGISTRO (FOLIO) -->
    <div class="card">
      <div class="card-header">Información de Registro</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo">
            <label>Número de Partida</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['numero']) ?></div>
          </div>
          <div class="campo">
            <label>Libro (Tomo)</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['libro']) ?></div>
          </div>
          <div class="campo">
            <label>Folio</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['folio']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- DATOS DEL NACIDO -->
    <div class="card">
      <div class="card-header">Datos del Nacido</div>
      <div class="card-body">
        <div class="campos">
          <div class="campo full">
            <label>Nombre completo</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['nombre']) ?></div>
          </div>
          <div class="campo">
            <label>Lugar de nacimiento</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['lugar']) ?></div>
          </div>
          <div class="campo">
            <label>Fecha de nacimiento</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['fecha']) ?></div>
          </div>
          <div class="campo">
            <label>Hora de nacimiento</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['hora']) ?></div>
          </div>
          <div class="campo">
            <label>Sexo</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_nacido['sexo']) ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- SECCIÓN DE LOS PADRES -->
    <div class="padres-container">
      <!-- DATOS DEL PADRE -->
      <div class="card">
        <div class="card-header">Datos del Padre</div>
        <div class="card-body">
          <div class="campos">
            <div class="campo full">
              <label>Nombre completo</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_padre['nombre']) ?></div>
            </div>
            <div class="campo">
              <label>DUI</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_padre['dui']) ?></div>
            </div>
            <div class="campo">
              <label>Edad</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_padre['edad']) ?> años</div>
            </div>
            <div class="campo">
              <label>Profesión u oficio</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_padre['profesion']) ?></div>
            </div>
            <div class="campo full">
              <label>Domicilio</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_padre['domicilio']) ?></div>
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
              <div class="valor"><?= htmlspecialchars((string)$datos_madre['nombre']) ?></div>
            </div>
            <div class="campo">
              <label>DUI</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_madre['dui']) ?></div>
            </div>
            <div class="campo">
              <label>Edad</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_madre['edad']) ?> años</div>
            </div>
            <div class="campo">
              <label>Profesión u oficio</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_madre['profesion']) ?></div>
            </div>
            <div class="campo full">
              <label>Domicilio</label>
              <div class="valor"><?= htmlspecialchars((string)$datos_madre['domicilio']) ?></div>
            </div>
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
            <div class="valor"><?= htmlspecialchars((string)$datos_certificacion['informante']) ?></div>
          </div>
          <div class="campo">
            <label>Parentesco</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_certificacion['parentesco']) ?></div>
          </div>
          <div class="campo">
            <label>DUI del informante</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_certificacion['dui_informante']) ?></div>
          </div>
          <div class="campo">
            <label>Fecha de inscripción</label>
            <div class="valor"><?= htmlspecialchars((string)$datos_certificacion['fecha_inscripcion']) ?></div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /cuerpo -->

  <!-- FOOTER: FIRMAS -->
  <div class="footer">
    <div class="firmas">
      <div class="firma-bloque">
        <div class="firma-imagen-wrap">
          <img src="../assets/uploads/firmas/firma1.png" alt="Firma Jefe de Distrito">
        </div>
        <div class="firma-linea"></div>
        <div class="firma-titulo">Jefe de Registros Familiares</div>
        <div class="firma-nombre"><?= htmlspecialchars((string)$datos_footer['jefe_registros']) ?></div>
      </div>
      <div class="firma-bloque">
        <div class="firma-linea"></div>
        <div class="firma-titulo">Firma del Informante</div>
        <div class="firma-nombre"><?= htmlspecialchars((string)$datos_footer['informante']) ?></div>
      </div>
    </div>
    <div class="atendio-wrap">
      <?= htmlspecialchars((string)$datos_footer['atendio']) ?>
    </div>
  </div>

  <div class="banda-bot"></div>

</div><!-- /hoja -->

<button class="btn-volver" onclick="window.close() || (window.location.href = '../views/recepcion_partida.php')">&#11013; Volver</button>
<button class="btn-imprimir" onclick="confirmarImpresion()">&#128438; Imprimir</button>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarImpresion() {
        Swal.fire({
            title: '¿Imprimir Partida?',
            text: 'Verifique que toda la información sea correcta antes de imprimir.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, imprimir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.close();
                setTimeout(function() {
                    window.print();
                }, 350);
            }
        });
    }

    // Disparar el diálogo de impresión automáticamente al cargar la página
    window.onload = function() {
        setTimeout(function() {
            confirmarImpresion();
        }, 500);
    };
</script>

</body>
</html>