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

// =============================================
//  DATOS DEL MUNICIPIO - Ajusta según tu entorno
// =============================================
$datos_municipio = [
    'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
    'departamento'  => 'Cabañas',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',
];

function fechaEspañolCert($fecha) {
    if (!$fecha) return '---';
    $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    $timestamp = strtotime($fecha);
    return [
        'dia' => date('d', $timestamp),
        'mes' => $meses[date('n', $timestamp) - 1],
        'anio' => date('Y', $timestamp)
    ];
}

$f_boda = fechaEspañolCert($datos['fecha_matrimonio']);
$f_hoy = fechaEspañolCert(date('Y-m-d'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Certificación de Partida de Matrimonio - Munify</title>
    
    <!-- Fonts -->
    <?php include 'layouts/fonts.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
<<<<<<< HEAD:views/certificación_partida_matrimonio.php
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
        
        .titulo-central h2 {
            font-family: 'Crimson Text', serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .titulo-central .registro {
            font-family: 'Crimson Text', serif;
            font-size: 0.75rem;
            font-style: italic;
            color: #1C3166;
            display: block;
            margin-bottom: 10px;
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
            min-width: 0; /* Evita desbordamiento */
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
            min-width: 0; /* Evita desbordamiento */
        }
        
        .columna .seccion-header {
            background: #1C3166;
        }
        
        .columna .seccion-body {
            padding: 15px;
        }
        
        /* ════════ CERTIFICACIÓN TEXTO ════════ */
        .certificacion-texto {
            padding: 25px;
            font-family: 'Crimson Text', serif;
            font-size: 0.95rem;
            line-height: 1.8;
            text-align: justify;
            color: #1a1a1a;
        }
        
        .certificacion-texto p {
            margin-bottom: 15px;
            text-indent: 30px;
        }
        
        .certificacion-texto strong {
            color: #1C3166;
        }
        
        /* ════════ FIRMAS ════════ */
        .firmas {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            padding-top: 30px;
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
        }
        
        /* ════════ SELLO ════════ */
        .sello-container {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }
        
        .sello {
            width: 100px;
            height: 100px;
            border: 2px solid #1C3166;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Crimson Text', serif;
            font-size: 0.7rem;
            text-align: center;
            color: #1C3166;
            transform: rotate(-15deg);
            opacity: 0.6;
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

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE - TABLET (max-width: 1024px)
           ═══════════════════════════════════════════════════════════ */
        @media screen and (max-width: 1024px) {
            body {
                padding: 10px;
            }
            
            .documento {
                padding: 25px;
                max-width: 100%;
            }
            
            .titulo-central h1 {
                font-size: 1rem;
            }
            
            .titulo-central h2 {
                font-size: 0.8rem;
            }
            
            .titulo-central h3 {
                font-size: 1.2rem;
            }
            
            .escudo {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .dos-columnas {
                gap: 10px;
            }
            
            .fila {
                gap: 20px;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE - MÓVIL (max-width: 768px)
           ═══════════════════════════════════════════════════════════ */
        @media screen and (max-width: 768px) {
            body {
                padding: 0;
                background: white;
            }
            
            .documento {
                padding: 20px;
                box-shadow: none;
            }
            
            /* Header apilado en móvil */
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .escudo {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            
            .titulo-central {
                padding: 0;
            }
            
            .titulo-central h1 {
                font-size: 0.9rem;
                letter-spacing: 1px;
            }
            
            .titulo-central h2 {
                font-size: 0.75rem;
            }
            
            .titulo-central h3 {
                font-size: 1.1rem;
                letter-spacing: 2px;
            }
            
            /* Botón imprimir más pequeño */
            .btn-imprimir {
                top: 10px;
                right: 10px;
                padding: 8px 16px;
                font-size: 0.75rem;
            }
            
            /* Una sola columna en móvil */
            .dos-columnas {
                grid-template-columns: 1fr;
            }
            
            /* Filas en columna */
            .fila {
                flex-direction: column;
                gap: 12px;
            }
            
            .seccion-body {
                padding: 15px;
            }
            
            .seccion-header {
                padding: 8px 12px;
                font-size: 0.7rem;
            }
            
            .campo label {
                font-size: 0.6rem;
            }
            
            .campo .valor {
                font-size: 0.9rem;
            }
            
            /* Certificación más compacta */
            .certificacion-texto {
                padding: 15px;
                font-size: 0.9rem;
                line-height: 1.6;
            }
            
            .certificacion-texto p {
                text-indent: 20px;
            }
            
            /* Firmas en columna */
            .firmas {
                flex-direction: column;
                align-items: center;
                gap: 30px;
                margin-top: 30px;
            }
            
            .firma {
                width: 200px;
            }
            
            /* Footer en columna */
            .footer-info {
                flex-direction: column;
                gap: 5px;
                text-align: center;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE - MÓVIL PEQUEÑO (max-width: 480px)
           ═══════════════════════════════════════════════════════════ */
        @media screen and (max-width: 480px) {
            .documento {
                padding: 15px;
            }
            
            .titulo-central h1 {
                font-size: 0.8rem;
            }
            
            .titulo-central h3 {
                font-size: 1rem;
            }
            
            .campo .valor {
                font-size: 0.85rem;
            }
            
            .certificacion-texto {
                font-size: 0.85rem;
                padding: 12px;
            }
        }

        @media print {
            body { 
                background: white; 
                padding: 0; 
            }
            .documento { 
                box-shadow: none; 
                max-width: 100%;
                padding: 15px;
            }
            .acciones-flotantes { 
                display: none; 
            }
            .seccion { 
                break-inside: avoid; 
            }
            .dos-columnas {
                grid-template-columns: 1fr 1fr;
            }
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
        <a href="acta_de_matrimonio.php?id=<?= $id_acta ?>" class="btn-flotante btn-navegar">
            <i class="fas fa-arrow-left"></i> Ver Acta
        </a>
    </div>
>>>>>>> Hz-backend_1:views/certificacion_matrimonio.php

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
                            <h3>CERTIFICACIÓN DE MATRIMONIO</h3>
                        </div>

                        <div style="width: 80px;"></div>
                    </div>

                    <!-- ACCIONES -->
                    <div class="acciones-header">
                        <a href="acta_de_matrimonio.php?id=ID_AQUI" class="btn-custom btn-custom-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Acta
                        </a>
                        <div>
                            <button onclick="window.print()" class="btn-custom btn-custom-primary">
                                <i class="fas fa-print"></i> Imprimir Certificación
                            </button>
                        </div>
                    </div>

        <!-- DATOS DEL MATRIMONIO -->
        <div class="seccion">
            <div class="seccion-header">
                <i class="fas fa-ring"></i>
                DATOS DEL MATRIMONIO
            </div>
            <div class="seccion-body">
                <div class="fila">
                    <div class="campo">
                        <label>Número de Acta</label>
                        <div class="valor" id="numero_acta"><?= htmlspecialchars($datos['numero_acta']) ?></div>
                    </div>
                    <div class="campo">
                        <label>Fecha de Celebración</label>
                        <div class="valor" id="fecha_matrimonio"><?= htmlspecialchars($datos['fecha_matrimonio']) ?></div>
                    </div>
                    <div class="campo">
                        <label>Hora</label>
                        <div class="valor" id="hora_matrimonio"><?= htmlspecialchars(date('H:i', strtotime($datos['hora_matrimonio']))) ?></div>
                    </div>
                </div>
                <div class="fila">
                    <div class="campo">
                        <label>Lugar</label>
                        <div class="valor" id="lugar">Alcaldía Municipal de Ilobasco</div>
                    </div>
                    <div class="campo">
                        <label>Régimen Patrimonial</label>
                        <div class="valor" id="regimen"><?= htmlspecialchars($datos['regimen_patrimonial']) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTRAYENTES -->
        <div class="dos-columnas">
            
            <!-- CONTRAYENTE HOMBRE -->
            <div class="columna">
                <div class="seccion-header">
                    <i class="fas fa-male"></i>
                    DATOS DEL CONTRAYENTE
                </div>
                <div class="seccion-body">
                    <div class="campo" style="margin-bottom: 12px;">
                        <label>Nombre Completo</label>
                        <div class="valor" id="novio_nombre"><?= htmlspecialchars($datos['novio_nombre_completo']) ?></div>
                    </div>
                    <div class="fila" style="gap: 15px;">
                        <div class="campo">
                            <label>DUI</label>
                            <div class="valor" id="novio_dui"><?= htmlspecialchars($datos['novio_dui']) ?></div>
                        </div>
                        <div class="campo">
                            <label>Edad</label>
                            <div class="valor" id="novio_edad"><?= htmlspecialchars($datos['novio_edad']) ?> años</div>
                        </div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Profesión u Oficio</label>
                        <div class="valor" id="novio_profesion"><?= htmlspecialchars($datos['novio_profesion']) ?></div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Nacionalidad</label>
                        <div class="valor" id="novio_nacionalidad"><?= htmlspecialchars($datos['novio_nacionalidad']) ?></div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Domicilio</label>
                        <div class="valor" id="novio_domicilio"><?= htmlspecialchars($datos['novio_domicilio']) ?></div>
                    </div>
                </div>
            </div>

            <!-- CONTRAYENTE MUJER -->
            <div class="columna">
                <div class="seccion-header">
                    <i class="fas fa-female"></i>
                    DATOS DE LA CONTRAYENTE
                </div>
                <div class="seccion-body">
                    <div class="campo" style="margin-bottom: 12px;">
                        <label>Nombre Completo</label>
                        <div class="valor" id="novia_nombre"><?= htmlspecialchars($datos['novia_nombre_completo']) ?></div>
                    </div>
                    <div class="fila" style="gap: 15px;">
                        <div class="campo">
                            <label>DUI</label>
                            <div class="valor" id="novia_dui"><?= htmlspecialchars($datos['novia_dui']) ?></div>
                        </div>
                        <div class="campo">
                            <label>Edad</label>
                            <div class="valor" id="novia_edad"><?= htmlspecialchars($datos['novia_edad']) ?> años</div>
                        </div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Profesión u Oficio</label>
                        <div class="valor" id="novia_profesion"><?= htmlspecialchars($datos['novia_profesion']) ?></div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Nacionalidad</label>
                        <div class="valor" id="novia_nacionalidad"><?= htmlspecialchars($datos['novia_nacionalidad']) ?></div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Domicilio</label>
                        <div class="valor" id="novia_domicilio"><?= htmlspecialchars($datos['novia_domicilio']) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TESTIGOS -->
        <div class="seccion" style="margin-top: 15px;">
            <div class="seccion-header">
                <i class="fas fa-users"></i>
                DATOS DE LOS TESTIGOS
            </div>
            <div class="seccion-body">
                <div class="fila">
                    <div class="campo">
                        <label>Testigo 1</label>
                        <div class="valor" id="testigo1_nombre"><?= htmlspecialchars($datos['testigo1_nombre']) ?></div>
                    </div>
                    <div class="campo">
                        <label>Testigo 2</label>
                        <div class="valor" id="testigo2_nombre"><?= htmlspecialchars($datos['testigo2_nombre']) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CERTIFICACIÓN -->
        <div class="seccion">
            <div class="seccion-header">
                <i class="fas fa-certificate"></i>
                CERTIFICACIÓN
            </div>
            <div class="certificacion-texto">
                <p>
                    <strong>EL INFRAESCRITO, ENCARGADO DEL REGISTRO DEL ESTADO FAMILIAR DE LA ALCALDÍA MUNICIPAL DE ILOBASCO,</strong>
                </p>
                
                <p>
                    <strong>CERTIFICA:</strong> Que en el Libro de Actas de Matrimonio N° <strong id="libro_numero"><?= htmlspecialchars($datos['libro']) ?></strong>, 
                    folio <strong id="folio_numero"><?= htmlspecialchars($datos['folio']) ?></strong>, número <strong id="partida_numero"><?= htmlspecialchars($datos['numero_acta']) ?></strong>, 
                    queda inscrito el acta de matrimonio celebrado entre los señores 
                    <strong id="cert_novio"><?= htmlspecialchars($datos['novio_nombre_completo']) ?></strong> y <strong id="cert_novia"><?= htmlspecialchars($datos['novia_nombre_completo']) ?></strong>, 
                    el día <strong id="cert_fecha"><?= htmlspecialchars($f_boda['dia']) ?></strong> de <strong id="cert_mes"><?= htmlspecialchars($f_boda['mes']) ?></strong> 
                    de <strong id="cert_anio"><?= htmlspecialchars($f_boda['anio']) ?></strong>.
                </p>
                
                <p>
                    El acto se realizó ante mi presencia como <strong id="cert_cargo"><?= htmlspecialchars($datos['cargo_oficial']) ?></strong>, 
                    en presencia de los testigos arriba mencionados.
                </p>
                
                <p>
                    Se extiende la presente certificación para los fines que el interesado estime conveniente, 
                    en la ciudad de Ilobasco, a los <strong id="cert_dia_emision"><?= htmlspecialchars($f_hoy['dia']) ?></strong> días del mes de 
                    <strong id="cert_mes_emision"><?= htmlspecialchars($f_hoy['mes']) ?></strong> de <strong id="cert_anio_emision"><?= htmlspecialchars($f_hoy['anio']) ?></strong>.
                </p>
            </div>
        </div>

        <!-- SELLO Y FIRMAS -->
        <div class="sello-container">
            <div class="sello">
                <img src="../assets/Img/sello_ilobasco.png" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" style="width: 100%; height: 100%; object-fit: contain;">
                <span style="display:none;">SELLO<br>OFICIAL</span>
            </div>
        </div>

        <div class="firmas">
            <div class="firma">
                <div class="linea"></div>
                <strong id="firma_oficial_nombre"><?= htmlspecialchars($datos['nombre_oficial']) ?></strong>
                <span id="firma_oficial_cargo"><?= htmlspecialchars($datos['cargo_oficial']) ?></span>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer-info">
            <span>Código de verificación: <strong id="codigo_verificacion"><?= substr(md5($datos['id_acta']), 0, 8) ?></strong></span>
            <span>Fecha de emisión: <strong id="fecha_emision"><?= date('d/m/Y') ?></strong></span>
        </div>

                    <!-- NAVEGACIÓN -->
                    <div class="doc-nav">
                        <a href="solicitud_matrimonio_civil.php?id=ID_AQUI" class="doc-nav-item">
                            <span class="doc-nav-num">I</span>
                            <span class="doc-nav-title">Solicitud</span>
                        </a>
                        <a href="acta_de_matrimonio.php?id=ID_AQUI" class="doc-nav-item">
                            <span class="doc-nav-num">II</span>
                            <span class="doc-nav-title">Acta</span>
                        </a>
                        <a href="#" class="doc-nav-item active" onclick="return false;">
                            <span class="doc-nav-num">III</span>
                            <span class="doc-nav-title">Certificación</span>
                        </a>
                    </div>

                </div>
            </div>
            
            <!-- Footer -->
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>

<<<<<<< HEAD:views/certificación_partida_matrimonio.php
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
=======
    <script>
        function preguntarImpresion() {
            Swal.fire({
                title: 'Opciones de Documento',
                text: "¿Qué desea hacer con la Certificación?",
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
>>>>>>> Hz-backend_1:views/certificacion_matrimonio.php
</body>
</html>