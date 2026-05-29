<?php session_start(); ?>
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
                        <div class="valor" id="numero_acta">_____</div>
                    </div>
                    <div class="campo">
                        <label>Fecha de Celebración</label>
                        <div class="valor" id="fecha_matrimonio">_____</div>
                    </div>
                    <div class="campo">
                        <label>Hora</label>
                        <div class="valor" id="hora_matrimonio">_____</div>
                    </div>
                </div>
                <div class="fila">
                    <div class="campo">
                        <label>Lugar</label>
                        <div class="valor" id="lugar">_____</div>
                    </div>
                    <div class="campo">
                        <label>Régimen Patrimonial</label>
                        <div class="valor" id="regimen">_____</div>
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
                        <div class="valor" id="novio_nombre">_____</div>
                    </div>
                    <div class="fila" style="gap: 15px;">
                        <div class="campo">
                            <label>DUI</label>
                            <div class="valor" id="novio_dui">_____</div>
                        </div>
                        <div class="campo">
                            <label>Edad</label>
                            <div class="valor" id="novio_edad">_____</div>
                        </div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Profesión u Oficio</label>
                        <div class="valor" id="novio_profesion">_____</div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Nacionalidad</label>
                        <div class="valor" id="novio_nacionalidad">_____</div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Domicilio</label>
                        <div class="valor" id="novio_domicilio">_____</div>
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
                        <div class="valor" id="novia_nombre">_____</div>
                    </div>
                    <div class="fila" style="gap: 15px;">
                        <div class="campo">
                            <label>DUI</label>
                            <div class="valor" id="novia_dui">_____</div>
                        </div>
                        <div class="campo">
                            <label>Edad</label>
                            <div class="valor" id="novia_edad">_____</div>
                        </div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Profesión u Oficio</label>
                        <div class="valor" id="novia_profesion">_____</div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Nacionalidad</label>
                        <div class="valor" id="novia_nacionalidad">_____</div>
                    </div>
                    <div class="campo" style="margin-top: 12px;">
                        <label>Domicilio</label>
                        <div class="valor" id="novia_domicilio">_____</div>
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
                        <div class="valor" id="testigo1_nombre">_____</div>
                    </div>
                    <div class="campo">
                        <label>DUI Testigo 1</label>
                        <div class="valor" id="testigo1_dui">_____</div>
                    </div>
                    <div class="campo">
                        <label>Testigo 2</label>
                        <div class="valor" id="testigo2_nombre">_____</div>
                    </div>
                    <div class="campo">
                        <label>DUI Testigo 2</label>
                        <div class="valor" id="testigo2_dui">_____</div>
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
                    <strong>CERTIFICA:</strong> Que en el Libro de Actas de Matrimonio N° <strong id="libro_numero">_____</strong>, 
                    folio <strong id="folio_numero">_____</strong>, número <strong id="partida_numero">_____</strong>, 
                    queda inscrito el acta de matrimonio celebrado entre los señores 
                    <strong id="cert_novio">_____</strong> y <strong id="cert_novia">_____</strong>, 
                    el día <strong id="cert_fecha">_____</strong> de <strong id="cert_mes">_____</strong> 
                    de <strong id="cert_anio">_____</strong>.
                </p>
                
                <p>
                    El acto se realizó ante mi presencia como <strong id="cert_cargo">_____</strong>, 
                    en presencia de los testigos arriba mencionados.
                </p>
                
                <p>
                    Se extiende la presente certificación para los fines que el interesado estime conveniente, 
                    en la ciudad de Ilobasco, a los <strong id="cert_dia_emision">_____</strong> días del mes de 
                    <strong id="cert_mes_emision">_____</strong> de <strong id="cert_anio_emision">_____</strong>.
                </p>
            </div>
        </div>

        <!-- SELLO Y FIRMAS -->
        <div class="sello-container">
            <div class="sello">
                SELLO<br>OFICIAL
            </div>
        </div>

        <div class="firmas">
            <div class="firma">
                <div class="linea"></div>
                <strong id="firma_oficial_nombre">_____</strong>
                <span id="firma_oficial_cargo">Encargado del Registro del Estado Familiar</span>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer-info">
            <span>Código de verificación: <strong id="codigo_verificacion">_____</strong></span>
            <span>Fecha de emisión: <strong id="fecha_emision">_____</strong></span>
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>