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

        <!-- ACTA -->
        <div class="acta-container">
            
            <div class="acta-numero">
                <strong>ACTA N° <span id="numero_acta">_____</span> — AÑO <span id="anio">2025</span></strong>
            </div>

            <div class="acta-prosa">
                <p>
                    En la Oficina del Registro del Estado Familiar de esta Alcaldía Municipal, 
                    siendo las <strong id="hora_letras">_____</strong> horas del día 
                    <strong id="fecha_letras">_____</strong> de <strong id="mes">_____</strong> 
                    de <strong id="anio_letras">_____</strong>, ante mí, 
                    <strong id="oficial_nombre">_____</strong>, 
                    <strong id="oficial_cargo">_____</strong>, 
                    comparecieron los señores:
                </p>

                <p>
                    <strong id="novio_nombre_completo">_____</strong>, 
                    de <strong id="novio_edad">_____</strong> años de edad, 
                    <strong id="novio_profesion">_____</strong>, 
                    de nacionalidad <strong id="novio_nacionalidad">_____</strong>, 
                    con Documento Único de Identidad número <strong id="novio_dui">_____</strong> 
                    y domicilio en <strong id="novio_domicilio">_____</strong>;
                </p>

                <p>
                    Y <strong id="novia_nombre_completo">_____</strong>, 
                    de <strong id="novia_edad">_____</strong> años de edad, 
                    <strong id="novia_profesion">_____</strong>, 
                    de nacionalidad <strong id="novia_nacionalidad">_____</strong>, 
                    con Documento Único de Identidad número <strong id="novia_dui">_____</strong> 
                    y domicilio en <strong id="novia_domicilio">_____</strong>.
                </p>

                <p>
                    Los comparecientes manifestaron ser solteros, mayores de edad, actuar por su propio derecho, 
                    y solicitaron contraer matrimonio bajo el régimen de 
                    <strong id="regimen">_____</strong>, en presencia de los testigos 
                    <strong id="testigo1">_____</strong> y <strong id="testigo2">_____</strong>.
                </p>

                <p>
                    En testimonio de lo cual, y habiendo leído íntegramente la presente acta a los contrayentes, 
                    ratificaron su contenido y procedieron a firmar la misma, junto con el suscrito Oficial del 
                    Registro del Estado Familiar, en la fecha y hora antes indicadas.
                </p>
            </div>

            <div class="acta-firmas">
                <div class="firma-box">
                    <div class="firma-linea">
                        <strong id="firma_oficial">____________________</strong>
                    </div>
                    <strong>EL OFICIAL</strong>
                    <span>Encargado del Registro del Estado Familiar</span>
                </div>
                <div class="firma-box">
                    <div class="firma-linea">
                        <strong id="firma_novio">____________________</strong>
                    </div>
                    <strong>EL CONTRAYENTE</strong>
                    <span>DUI: <span id="firma_novio_dui">_____</span></span>
                </div>
                <div class="firma-box">
                    <div class="firma-linea">
                        <strong id="firma_novia">____________________</strong>
                    </div>
                    <strong>LA CONTRAYENTE</strong>
                    <span>DUI: <span id="firma_novia_dui">_____</span></span>
                </div>
            </div>

        </div>

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