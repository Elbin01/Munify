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
    <title>Acta de Matrimonio</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
        
        /* ════════ BOTONES ════════ */
        .acciones-header {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: space-between;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-family: 'Open Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: #1C3166;
            color: white;
        }
        
        .btn-primary:hover {
            background: #15254d;
        }
        
        .btn-secondary {
            background: white;
            color: #1C3166;
            border: 2px solid #1C3166;
        }
        
        .btn-secondary:hover {
            background: #1C3166;
            color: white;
        }
        
        .btn-success {
            background: #003366;
            color: white;
        }
        
        /* ════════ ACTA CONTAINER ════════ */
        .acta-container {
            border: 2px solid #1C3166;
            padding: 40px;
            background: white;
        }
        
        .acta-numero {
            text-align: center;
            margin-bottom: 30px;
            padding: 15px;
            background: #f0f4ff;
            border: 1px solid #1C3166;
        }
        
        .acta-numero strong {
            font-family: 'Crimson Text', serif;
            font-size: 1.2rem;
            color: #1C3166;
        }
        
        /* ════════ PROSA JURÍDICA ════════ */
        .acta-prosa {
            font-family: 'Crimson Text', serif;
            font-size: 1rem;
            line-height: 2;
            text-align: justify;
            color: #1a1a1a;
        }
        
        .acta-prosa p {
            margin-bottom: 20px;
            text-indent: 40px;
        }
        
        .acta-prosa strong {
            color: #1C3166;
            font-weight: 600;
        }
        
        /* ════════ FIRMAS ACTA ════════ */
        .acta-firmas {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            margin-top: 60px;
            padding-top: 40px;
        }
        
        .firma-box {
            text-align: center;
        }
        
        .firma-linea {
            border-top: 1px solid #333;
            margin-bottom: 10px;
            padding-top: 10px;
        }
        
        .firma-box strong {
            font-family: 'Crimson Text', serif;
            font-size: 0.9rem;
            display: block;
            color: #1a1a1a;
        }
        
        .firma-box span {
            font-size: 0.75rem;
            color: #666;
        }
        
        /* ════════ NAVEGACIÓN ════════ */
        /* ════════ NAVEGACIÓN (BOTONES PEQUEÑOS) ════════ */
.nav-documentos {
    display: flex;
    gap: 8px;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #ddd;
}

.nav-item {
    flex: 1;
    padding: 10px 8px;
    background: white;
    border: 1px solid #ccc;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
}

.nav-item:hover {
    border-color: #1C3166;
    transform: translateY(-2px);
}

.nav-item.active {
    background: #1C3166;
    border-color: #1C3166;
    color: white;
}

.nav-num {
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    font-weight: 600;
    display: block;
    margin-bottom: 2px;
    line-height: 1;
}

.nav-title {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

/* Responsive */
@media screen and (max-width: 768px) {
    .nav-documentos {
        gap: 6px;
        margin-top: 15px;
    }
    
    .nav-item {
        padding: 8px 5px;
        border-radius: 4px;
    }
    
    .nav-num {
        font-size: 1rem;
    }
    
    .nav-title {
        font-size: 0.6rem;
    }
}

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE
           ═══════════════════════════════════════════════════════════ */
        @media screen and (max-width: 1024px) {
            body { padding: 10px; }
            .documento { padding: 25px; }
            .titulo-central h1 { font-size: 1rem; }
            .titulo-central h3 { font-size: 1.2rem; }
            .escudo { width: 60px; height: 60px; font-size: 1.5rem; }
            .acta-container { padding: 25px; }
        }

        @media screen and (max-width: 768px) {
            body { padding: 0; background: white; }
            .documento { padding: 20px; box-shadow: none; }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .escudo { width: 50px; height: 50px; font-size: 1.2rem; }
            .titulo-central h1 { font-size: 0.9rem; }
            .titulo-central h3 { font-size: 1.1rem; }
            
            .acciones-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .acta-container { padding: 20px; }
            .acta-prosa { font-size: 0.95rem; line-height: 1.8; }
            .acta-prosa p { text-indent: 20px; }
            
            .acta-firmas {
                grid-template-columns: 1fr;
                gap: 30px;
                margin-top: 40px;
            }
            
            .nav-documentos { flex-direction: column; }
        }

        @media print {
            body { background: white; padding: 0; }
            .documento { box-shadow: none; max-width: 100%; }
            .acciones-header, .nav-documentos { display: none; }
            .acta-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>

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

        <!-- ACCIONES -->
        <div class="acciones-header">
            <a href="solicitud_matrimonio_civil.php?id=ID_AQUI" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Solicitud
            </a>
            <div>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Imprimir Acta
                </button>
                <a href="certificación_partida_matrimonio.php?id=ID_AQUI" class="btn btn-primary">
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
        <div class="nav-documentos">
            <a href="solicitud_matrimonio_civil.php?id=ID_AQUI" class="nav-item">
                <span class="nav-num">I</span>
                <span class="nav-title">Solicitud</span>
            </a>
            <a href="#" class="nav-item active" onclick="return false;">
                <span class="nav-num">II</span>
                <span class="nav-title">Acta</span>
            </a>
            <a href="certificación_partida_matrimonio.php?id=ID_AQUI" class="nav-item">
                <span class="nav-num">III</span>
                <span class="nav-title">Certificación</span>
            </a>
        </div>

    </div>

</body>
</html>