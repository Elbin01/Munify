<?php session_start(); ?>
<?php
require_once __DIR__ . '/../models/ActaMatrimonioModel.php';

$id_acta = $_GET['id'] ?? null;

if (!$id_acta) {
    die("Error: No se proporcionó un ID de acta.");
}

$modelo = new ActaMatrimonioModel();
$datos = $modelo->obtenerActaPorId($id_acta);

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
    return date('d', $timestamp) . " de " . $meses[date('n', $timestamp) - 1] . " de " . date('Y', $timestamp);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Acta de Matrimonio - Munify</title>
    
    <!-- Fonts -->
    <?php include 'layouts/fonts.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
<<<<<<< HEAD
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/solicitud_matrimonio.css?v=<?= time() ?>">
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container-fluid py-4 px-4">
                <div class="documento">
                    
                    <!-- HEADER -->
                    <div class="header">
                        <div class="escudo">
                            <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
                                <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" 
                                     alt="Escudo" 
                                     style="width:100%; height:100%; object-fit:contain;">
                            <?php else: ?>
                                <i class="fas fa-landmark"></i>
                            <?php endif; ?>
                        </div>

                        <div class="titulo-central">
                            <h1>ALCALDÍA MUNICIPAL DE ILOBASCO</h1>
                            <h2>DEPARTAMENTO DE CABAÑAS — EL SALVADOR</h2>
                            <span class="registro">Registro del Estado Familiar</span>
                            <h3>ACTA DE MATRIMONIO</h3>
                        </div>

                        <div style="width: 80px;"></div>
                    </div>

                    <!-- ACCIONES -->
                    <div class="acciones-header">
                        <a href="solicitud_matrimonio_civil.php?id=ID_AQUI" class="btn-custom btn-custom-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Solicitud
                        </a>
                        <div>
                            <button onclick="window.print()" class="btn-custom btn-custom-primary">
                                <i class="fas fa-print"></i> Imprimir Acta
                            </button>
                            <a href="certificación_partida_matrimonio.php?id=ID_AQUI" class="btn-custom btn-custom-primary">
                                <i class="fas fa-certificate"></i> Ver Certificación →
                            </a>
                        </div>
                    </div>
=======
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background: #f5f5f5;
            padding: 20px;
            -webkit-text-size-adjust: 100%;
        }
        
        .documento {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* ════════ HEADER ════════ */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 3px double #1C3166;
        }
        
        .escudo {
            width: 80px;
            height: 80px;
            border: 2px solid #1C3166;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            background: white;
        }

        .escudo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }
        
        .titulo-central {
            text-align: center;
            flex: 1;
            padding: 0 20px;
        }
        
        .titulo-central h1 {
            font-family: 'Crimson Text', serif;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .titulo-central h3 {
            font-family: 'Crimson Text', serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 3px;
            color: #1a1a1a;
            text-transform: uppercase;
        }
        
        .acciones-flotantes {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }
        
        .btn-flotante {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.2s;
            border: none;
        }
        
        .btn-volver {
            background: #6c757d;
            color: white;
        }
        .btn-volver:hover { background: #5a6268; }
        
        .btn-imprimir {
            background: #1C3166;
            color: white;
        }
        .btn-imprimir:hover { background: #15254d; }
        
        .btn-navegar {
            background: #198754;
            color: white;
        }
        .btn-navegar:hover { background: #146c43; }
        
        /* ════════ SECCIONES ════════ */
        .seccion {
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }
        
        .seccion-header {
            background: #1C3166;
            color: white;
            padding: 10px 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .seccion-header i {
            font-size: 0.7rem;
        }
        
        .seccion-body {
            padding: 20px;
            background: #fafbfc;
        }
        
        /* ════════ CAMPOS ════════ */
        .fila {
            display: flex;
            gap: 30px;
            margin-bottom: 15px;
        }
        
        .fila:last-child {
            margin-bottom: 0;
        }
        
        .campo {
            flex: 1;
            min-width: 0;
        }
        
        .campo label {
            display: block;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1C3166;
            margin-bottom: 4px;
        }
        
        .campo .valor {
            font-family: 'Crimson Text', serif;
            font-size: 0.95rem;
            color: #1a1a1a;
            padding-bottom: 4px;
            border-bottom: 1px solid #bbb;
            min-height: 24px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        /* ════════ DOS COLUMNAS ════════ */
        .dos-columnas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .columna {
            border: 1px solid #ddd;
            min-width: 0;
        }
        
        .columna .seccion-header {
            background: #1C3166;
        }
        
        .columna .seccion-body {
            padding: 15px;
        }
        
        /* ════════ ACTA TEXTO ════════ */
        .acta-texto {
            padding: 25px;
            font-family: 'Crimson Text', serif;
            font-size: 0.95rem;
            line-height: 1.8;
            text-align: justify;
            color: #1a1a1a;
        }
        
        .acta-texto p {
            margin-bottom: 15px;
            text-indent: 30px;
        }
        
        .acta-texto strong {
            color: #1C3166;
        }
        
        /* ════════ FIRMAS ════════ */
        .firmas {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            padding-top: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .firma {
            text-align: center;
            width: 250px;
        }
        
        .firma .linea {
            border-top: 1px solid #333;
            margin-bottom: 8px;
            padding-top: 8px;
        }
        
        .firma strong {
            font-family: 'Crimson Text', serif;
            font-size: 0.9rem;
            display: block;
            color: #1a1a1a;
        }
        
        .firma span {
            font-size: 0.75rem;
            color: #666;
            display: block;
        }
        
        /* ════════ FOOTER INFO ════════ */
        .footer-info {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 0.7rem;
            color: #666;
        }

        @media print {
            body { background: white; padding: 0; }
            .documento { box-shadow: none; max-width: 100%; border: none; padding: 15px; }
            .acciones-flotantes { display: none; }
            .seccion { break-inside: avoid; }
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="acciones-flotantes">
        <a href="recepcion_matrimonio.php" class="btn-flotante btn-volver">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <button class="btn-flotante btn-imprimir" onclick="preguntarImpresion()">
            <i class="fas fa-print"></i> Imprimir
        </button>
        <a href="certificacion_matrimonio.php?id=<?= $id_acta ?>" class="btn-flotante btn-navegar">
            Ver Certificación <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="documento">
        
        <!-- HEADER -->
        <div class="header">
            <div class="escudo">
                <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
                    <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" alt="Escudo">
                <?php else: ?>
                    <i class="fas fa-landmark"></i>
                <?php endif; ?>
            </div>
            <div class="titulo-central">
                <h1><?= htmlspecialchars($datos_municipio['alcaldia']) ?></h1>
                <h3>ACTA DE MATRIMONIO CIVIL</h3>
            </div>
            <div style="width: 80px;" class="spacer"></div>
        </div>
>>>>>>> Hz-backend_1

        <!-- CUERPO DEL ACTA -->
        <div class="seccion">
            <div class="seccion-header">
                <i class="fas fa-file-alt"></i>
                TEXTO DEL ACTA
            </div>
            <div class="acta-texto">
                <p>
                    En la Oficina del Registro del Estado Familiar de esta Alcaldía Municipal, 
                    siendo las <strong><?= htmlspecialchars(date('H:i', strtotime($datos['hora_matrimonio']))) ?></strong> horas del día 
                    <strong><?= fechaEspañol($datos['fecha_matrimonio']) ?></strong>, ante mí, 
                    <strong><?= htmlspecialchars($datos['nombre_oficial']) ?></strong>, 
                    <strong><?= htmlspecialchars($datos['cargo_oficial']) ?></strong>, 
                    comparecieron los señores:
                </p>

                <p>
                    <strong><?= htmlspecialchars($datos['novio_nombre_completo']) ?></strong>, 
                    de <strong><?= htmlspecialchars($datos['novio_edad']) ?></strong> años de edad, 
                    <strong><?= htmlspecialchars($datos['novio_profesion']) ?></strong>, 
                    de nacionalidad <strong><?= htmlspecialchars($datos['novio_nacionalidad']) ?></strong>, 
                    con Documento Único de Identidad número <strong><?= htmlspecialchars($datos['novio_dui']) ?></strong> 
                    y domicilio en <strong><?= htmlspecialchars($datos['novio_domicilio']) ?></strong>;
                </p>

                <p>
                    Y <strong><?= htmlspecialchars($datos['novia_nombre_completo']) ?></strong>, 
                    de <strong><?= htmlspecialchars($datos['novia_edad']) ?></strong> años de edad, 
                    <strong><?= htmlspecialchars($datos['novia_profesion']) ?></strong>, 
                    de nacionalidad <strong><?= htmlspecialchars($datos['novia_nacionalidad']) ?></strong>, 
                    con Documento Único de Identidad número <strong><?= htmlspecialchars($datos['novia_dui']) ?></strong> 
                    y domicilio en <strong><?= htmlspecialchars($datos['novia_domicilio']) ?></strong>.
                </p>

                <p>
                    Los comparecientes manifestaron ser solteros, mayores de edad, actuar por su propio derecho, 
                    y solicitaron contraer matrimonio bajo el régimen de 
                    <strong><?= htmlspecialchars($datos['regimen_patrimonial']) ?></strong>, en presencia de los testigos 
                    <strong><?= htmlspecialchars($datos['testigo1_nombre']) ?></strong> y <strong><?= htmlspecialchars($datos['testigo2_nombre']) ?></strong>.
                </p>
                <p>
                    En testimonio de lo cual, y habiendo leído íntegramente la presente acta a los contrayentes, 
                    ratificaron su contenido y procedieron a firmar la misma, junto con el suscrito Oficial del 
                    Registro del Estado Familiar, en la fecha y hora antes indicadas.
                </p>
            </div>
        </div>

<<<<<<< HEAD
                    <!-- NAVEGACIÓN -->
                    <div class="doc-nav">
                        <a href="solicitud_matrimonio_civil.php?id=ID_AQUI" class="doc-nav-item">
                            <span class="doc-nav-num">I</span>
                            <span class="doc-nav-title">Solicitud</span>
                        </a>
                        <a href="#" class="doc-nav-item active" onclick="return false;">
                            <span class="doc-nav-num">II</span>
                            <span class="doc-nav-title">Acta</span>
                        </a>
                        <a href="certificación_partida_matrimonio.php?id=ID_AQUI" class="doc-nav-item">
                            <span class="doc-nav-num">III</span>
                            <span class="doc-nav-title">Certificación</span>
                        </a>
                    </div>
=======
        <div class="firmas">
            <div class="firma">
                <div class="linea"></div>
                <strong><?= htmlspecialchars($datos['nombre_oficial']) ?></strong>
                <span><?= htmlspecialchars($datos['cargo_oficial']) ?></span>
            </div>
            <div class="firma">
                <div class="linea"></div>
                <strong><?= htmlspecialchars($datos['novio_nombre_completo']) ?></strong>
                <span>El Contrayente (DUI: <?= htmlspecialchars($datos['novio_dui']) ?>)</span>
            </div>
            <div class="firma">
                <div class="linea"></div>
                <strong><?= htmlspecialchars($datos['novia_nombre_completo']) ?></strong>
                <span>La Contrayente (DUI: <?= htmlspecialchars($datos['novia_dui']) ?>)</span>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer-info">
            <span>Acta número: <strong><?= htmlspecialchars($datos['numero_acta']) ?></strong></span>
            <span>Libro: <strong><?= htmlspecialchars($datos['libro']) ?></strong> - Folio: <strong><?= htmlspecialchars($datos['folio']) ?></strong></span>
        </div>
>>>>>>> Hz-backend_1

                </div>
            </div>
            
            <!-- Footer -->
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>

<<<<<<< HEAD
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
=======
    <script>
        function preguntarImpresion() {
            Swal.fire({
                title: 'Opciones de Documento',
                text: "¿Qué desea hacer con el Acta de Matrimonio?",
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#1C3166',
                denyButtonColor: '#6c757d',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-print me-2"></i> Imprimir',
                denyButtonText: '<i class="fas fa-eye me-2"></i> Solo Ver',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.print();
                }
            });
        }

        // Ejecutar la pregunta al cargar la página
        window.onload = function() {
            preguntarImpresion();
        };
    </script>
>>>>>>> Hz-backend_1
</body>
</html>