<?php
require_once __DIR__ . '/../controller/TestamentoController.php';

$id = $_GET['id'] ?? null;

function fechaEspanol($fecha)
{
    if (!$fecha) return '---';

    $meses = [
        "enero","febrero","marzo","abril","mayo","junio",
        "julio","agosto","septiembre","octubre","noviembre","diciembre"
    ];

    $timestamp = strtotime($fecha);

    $dia = date('d', $timestamp);
    $mes = $meses[date('n', $timestamp)-1];
    $anio = date('Y', $timestamp);

    return "$dia de $mes de $anio";
}

if ($id) {
    $controller = new TestamentoController();
    $datos = $controller->obtenerReporte($id);

    if (!$datos) {
        die("Error: No se encontró el testamento solicitado.");
    }

    $datos_municipio = [
        'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
        'departamento'  => 'Cabañas',
        'pais'          => 'El Salvador',
        'escudo_nacion' => '../assets/Img/escudo.jpeg'
    ];

    $datos_testador = [
        'nombre'        => $datos['nombre_testador'],
        'dui'           => $datos['dui_testador'],
        'edad'          => $datos['edad_testador'],
        'estado_civil'  => $datos['estado_civil_testador'],
        'domicilio'     => $datos['domicilio_testador']
    ];

    $datos_heredero = [
        'nombre'        => $datos['nombre_heredero'],
        'parentesco'    => $datos['parentesco_heredero']
    ];

    $datos_testamento = [
        'numero'        => $datos['id_testamento'],
        'bienes'        => $datos['bienes_declarados'],
        'declaracion'   => $datos['declaracion_voluntad'],
        'fecha'         => fechaEspanol($datos['fecha_registro'])
    ];

    $datos_footer = [
        'atendio'       => $datos['atendio_por'] ?? 'Registro del Estado Familiar',
        'testador'      => $datos['nombre_testador']
    ];
} else {
    $datos_municipio = [
        'alcaldia'      => $_POST['alcaldia'] ?? 'Alcaldía Municipal de Ilobasco',
        'departamento'  => $_POST['departamento'] ?? 'Cabañas',
        'pais'          => 'El Salvador',
        'escudo_nacion' => '../assets/Img/escudo.jpeg'
    ];

    $datos_testador = [
        'nombre'        => $_POST['nombre_testador'] ?? '',
        'dui'           => $_POST['dui_testador'] ?? '',
        'edad'          => $_POST['edad_testador'] ?? '',
        'estado_civil'  => $_POST['estado_civil_testador'] ?? '',
        'domicilio'     => $_POST['domicilio_testador'] ?? ''
    ];

    $datos_heredero = [
        'nombre'        => $_POST['nombre_heredero'] ?? '',
        'parentesco'    => $_POST['parentesco_heredero'] ?? ''
    ];

    $fecha_raw = $_POST['fecha_registro'] ?? date('Y-m-d');
    
    $datos_testamento = [
        'numero'        => '---',
        'bienes'        => $_POST['bienes_declarados'] ?? '',
        'declaracion'   => $_POST['declaracion_voluntad'] ?? '',
        'fecha'         => fechaEspanol($fecha_raw)
    ];

    $datos_footer = [
        'atendio'       => $_POST['atendio'] ?? 'Sistema Munify',
        'testador'      => $_POST['nombre_testador'] ?? ''
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Testamento</title>
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
      margin-top: 3.5rem; /* Separación extra solicitada */
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

    @media print {
      /* Ocultar elementos de SweetAlert en la impresión y evitar que interfieran con el layout */
      .swal2-container, .swal2-backdrop, .swal2-popup, .swal2-overlay, .swal2-modal {
        display: none !important;
      }
      body.swal2-shown, html.swal2-shown {
        overflow: visible !important;
        height: auto !important;
      }

      body { background: white; padding: 0; }
      .hoja { width: 100%; margin: 0; border: none; box-shadow: none; border-radius: 0; }
      .btn-imprimir, .btn-volver { display: none; }
      .card { page-break-inside: avoid; }
      .cuerpo { padding: 0.8rem 1.5rem; }
      .footer { padding: 0.8rem 1.5rem; }
    }
  </style>
</head>
<body>

<div class="hoja">
  <div class="encabezado">
    <div class="logo-wrap">
      <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
        <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" alt="Escudo Nacional">
      <?php endif; ?>
    </div>
    <div class="encabezado-texto">
      <h1>
        <?= htmlspecialchars($datos_municipio['alcaldia']) ?><br>
        Departamento de <?= htmlspecialchars($datos_municipio['departamento']) ?>
        – <?= htmlspecialchars($datos_municipio['pais']) ?>
      </h1>
      <div class="subtitulo">Registro del Estado Familiar</div>
      <div class="titulo-doc">Testamento</div>
    </div>
  </div>

  <div class="cuerpo">
    <div class="card">
    <div class="card-header">Información del Registro</div>

    <div class="card-body">
        <div class="campos">

            <div class="campo">
                <label>Número de Registro</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_testamento['numero']) ?>
                </div>
            </div>

            <div class="campo">
                <label>Fecha de Registro</label>
                <div class="valor">
                    <?= $datos_testamento['fecha'] ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">Datos del Testador</div>

    <div class="card-body">
        <div class="campos">

            <div class="campo full">
                <label>Nombre Completo</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_testador['nombre']) ?>
                </div>
            </div>

            <div class="campo">
                <label>DUI</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_testador['dui']) ?>
                </div>
            </div>

            <div class="campo">
                <label>Edad</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_testador['edad']) ?> años
                </div>
            </div>

            <div class="campo">
                <label>Estado Civil</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_testador['estado_civil']) ?>
                </div>
            </div>

            <div class="campo full">
                <label>Domicilio</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_testador['domicilio']) ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">Datos del Heredero</div>

    <div class="card-body">
        <div class="campos">

            <div class="campo full">
                <label>Nombre del Heredero</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_heredero['nombre']) ?>
                </div>
            </div>

            <div class="campo">
                <label>Parentesco</label>
                <div class="valor">
                    <?= htmlspecialchars($datos_heredero['parentesco']) ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">Bienes Declarados</div>

    <div class="card-body">
        <div class="campo full">
            <div class="valor">
                <?= nl2br(htmlspecialchars($datos_testamento['bienes'])) ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Declaración de Voluntad</div>

    <div class="card-body">
        <div class="campo full">
            <div class="valor">
                <?= nl2br(htmlspecialchars($datos_testamento['declaracion'])) ?>
            </div>
        </div>
    </div>
</div>

  </div> <!-- Fin de cuerpo -->

<div class="footer">

    <div class="firmas">

        <div class="firma-bloque">
            <div class="firma-linea"></div>

            <div class="firma-titulo">
                Testador
            </div>

            <div class="firma-nombre">
                <?= htmlspecialchars($datos_footer['testador']) ?>
            </div>
        </div>

        <div class="firma-bloque">
            <div class="firma-linea"></div>

            <div class="firma-titulo">
                Registro Municipal
            </div>

            <div class="firma-nombre">
                <?= htmlspecialchars($datos_footer['atendio']) ?>
            </div>
        </div>

    </div>
  </div> <!-- Fin de hoja -->

<button class="btn-volver" onclick="window.close() || (window.location.href = '../views/recepcion_testamento.php')">&#11013; Volver</button>
<button class="btn-imprimir" onclick="confirmarImpresion()">🖨️ Imprimir</button>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarImpresion(){
    Swal.fire({
        title: '¿Imprimir Acta?',
        text: 'Verifique que toda la información sea correcta.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1C3166',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, imprimir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if(result.isConfirmed){
            Swal.close();
            setTimeout(function() {
                window.print();
            }, 350);
        }
    });
}

<?php if ($id): ?>
window.onload = function() { setTimeout(function() { confirmarImpresion(); }, 500); };
<?php endif; ?>
</script>
</body>
</html>
