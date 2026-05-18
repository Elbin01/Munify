<?php
require_once __DIR__ . '/../models/MinoridadModel.php';

$id_carnet = $_GET['id'] ?? null;

if ($id_carnet) {
    $modelo = new MinoridadModel();
    $datos_db = $modelo->obtenerPorId($id_carnet);

    if (!$datos_db) {
        die("Error: No se encontró el carnet con el ID proporcionado.");
    }

    $datos_municipio = [
        'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
        'departamento'  => 'Cabañas',
        'pais'          => 'El Salvador',
        'escudo_nacion' => '../assets/Img/escudo.jpeg',
        'logo'          => '',
    ];

    $datos_menor = [
        'apellidos'          => $datos_db['apellidos'],
        'nombres'            => $datos_db['nombres'],
        'lugar_nacimiento'   => $datos_db['lugar_nacimiento'] ?: 'Ilobasco, Cabañas',
        'fecha_nacimiento'   => $datos_db['fecha_nacimiento'],
        'fecha_expedicion'   => $datos_db['fecha_emision'],
        'fecha_vencimiento'  => $datos_db['fecha_vencimiento'],
        'numero_carnet'      => $datos_db['numero_carnet'],
        'foto'               => '', // Se podría agregar path si existe
    ];

    $datos_reverso = [
        'direccion'          => 'Ilobasco, Cabañas',
        'nombre_madre'       => $datos_db['nombre_madre'] ?: '---',
        'nombre_padre'       => $datos_db['nombre_padre'] ?: '---',
        'color_piel'         => $datos_db['color_piel'] ?: '---',
        'color_ojos'         => $datos_db['color_ojos'] ?: '---',
        'cabello'            => $datos_db['color_cabello'] ?: '---',
        'senales_especiales' => $datos_db['senales_especiales'] ?: '---',
        'centro_estudios'    => $datos_db['lugar_estudio'] ?: '---',
        'tipo_tramite'       => 'REPOSICIÓN/CERTIFICADO',
    ];

    $datos_footer = [
        'alcalde'    => 'Lic. Lorenzo Rivas',
        'secretario' => 'Licda. Rosa Elena Méndez Castro',
        'atendio'    => 'Sistema Munify',
    ];
} else {
    // Lógica original de la vista (MOCK/POST)
    $datos_municipio = [
        'alcaldia'      => 'Alcaldía Municipal de Ilobasco',
        'departamento'  => 'Cabañas',
        'pais'          => 'El Salvador',
        'escudo_nacion' => '../assets/Img/escudo.jpeg',
        'logo'          => '',
    ];

    $datos_menor = [
        'apellidos'          => $_POST['m_apellidos'] ?? 'Rodríguez López',
        'nombres'            => $_POST['m_nombres'] ?? 'María José',
        'lugar_nacimiento'   => $_POST['m_lugar_nac'] ?? 'Ilobasco, Cabañas',
        'fecha_nacimiento'   => $_POST['m_fecha_nac'] ?? '14/04/2015',
        'fecha_expedicion'   => date('d/m/Y'),
        'fecha_vencimiento'  => date('d/m/Y', strtotime('+3 years')),
        'numero_carnet'      => $_POST['m_numero_carnet'] ?? ('0601-' . rand(100000, 999999)),
        'foto'               => $_POST['m_foto_path'] ?? '',
    ];

    $datos_reverso = [
        'direccion'          => $_POST['m_direccion'] ?? 'Colonia Jardines, Calle Principal #12, Ilobasco, Cabañas',
        'nombre_madre'       => $_POST['m_nombre_madre'] ?? 'Ana Sofía López de Rodríguez',
        'nombre_padre'       => $_POST['m_nombre_padre'] ?? 'Carlos Alberto Rodríguez Martínez',
        'color_piel'         => $_POST['m_color_piel'] ?? 'Moreno',
        'color_ojos'         => $_POST['m_color_ojos'] ?? 'Café',
        'cabello'            => $_POST['m_color_cabello'] ?? 'Negro',
        'senales_especiales' => $_POST['m_senales_especiales'] ?? 'Ninguna',
        'centro_estudios'    => $_POST['m_centro_estudios'] ?? 'Centro Escolar Sor Heriquez',
        'tipo_tramite'       => 'PRIMERA VEZ',
    ];

    $datos_footer = [
        'alcalde'    => 'Lic. Lorenzo Rivas',
        'secretario' => 'Licda. Rosa Elena Méndez Castro',
        'atendio'    => 'Asistente: María del Carmen Guevara',
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista 3D Interactiva – Carnet de Minoridad</title>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Montserrat:wght@400;600;700&display=swap">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --negro: #000000;
            --azul-oscuro: #1C3166;
            --blanco: #ffffff;
            --gris-claro: #f5f7fa;
            --gris-linea: #cccccc;
            --texto: #111111;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Montserrat', sans-serif;
            background: radial-gradient(circle at 50% 50%, #f4f6fa, #e1e5f0);
            color: var(--texto);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            overflow-x: hidden;
        }

        /* ── Barra de Navegación / Controles Superiores ── */
        .controls-header {
            width: 100%;
            max-width: 800px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .header-title {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--azul-oscuro);
            letter-spacing: 0.03em;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            border: none;
        }

        .btn-back {
            background: transparent;
            color: var(--azul-oscuro);
            border: 2px solid var(--azul-oscuro);
        }

        .btn-back:hover {
            background: rgba(28, 49, 102, 0.05);
            transform: translateY(-2px);
        }

        .btn-print {
            background: var(--azul-oscuro);
            color: white;
            box-shadow: 0 4px 10px rgba(28, 49, 102, 0.2);
        }

        .btn-print:hover {
            background: var(--negro);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(28, 49, 102, 0.4);
        }

        /* ── Contenedor de Vista 3D ── */
        .preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            perspective: 1500px;
            margin-top: 10px;
        }

        .preview-instruction {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            color: var(--azul-oscuro);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
            background: rgba(28, 49, 102, 0.06);
            padding: 8px 20px;
            border-radius: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }

        .preview-instruction:hover {
            background: rgba(28, 49, 102, 0.12);
            transform: scale(1.05);
        }

        .card-flip-container {
            width: 760px;
            height: 410px;
            cursor: pointer;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 20px;
        }

        .card-flip-container.flipped {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            inset: 0;
            backface-visibility: hidden;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            transition: box-shadow 0.3s;
        }

        .card-front:hover, .card-back:hover {
            box-shadow: 0 25px 50px rgba(28, 49, 102, 0.25);
        }

        .card-front {
            z-index: 2;
            transform: rotateY(0deg);
        }

        .card-back {
            transform: rotateY(180deg);
        }

        /* ── Estilos del Carnet (Mapeados desde el original) ── */
        .hoja {
            width: 100%;
            height: 100%;
            background: white;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-family: 'EB Garamond', Georgia, serif;
            background: linear-gradient(135deg, #ffffff 0%, #f7f9fc 100%);
            border: 2px solid rgba(28, 49, 102, 0.15);
            border-radius: 16px;
        }

        /* Brillo sutil de tarjeta PVC real */
        .hoja::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.05) 30%, transparent 60%);
            pointer-events: none;
            z-index: 10;
            border-radius: 14px;
        }

        .encabezado {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-bottom: 2px solid var(--negro);
        }
        .logo-wrap { width: 55px; height: 55px; border: 1px solid #000; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #fff; }
        .logo-wrap img { width: 100%; height: 100%; object-fit: contain; }
        .encabezado-texto { flex: 1; text-align: center; }
        .encabezado-texto h1 { font-family: 'Cinzel', serif; font-size: 0.7rem; line-height: 1.2; }
        .titulo-doc { font-family: 'Cinzel', serif; font-size: 0.95rem; font-weight: bold; margin-top: 3px; }

        .frontal-body { padding: 15px 20px; display: flex; gap: 20px; }
        .foto-wrap { width: 130px; text-align: center; }
        .foto-box { width: 130px; height: 160px; border: 1px solid var(--gris-linea); background: #eee; margin-bottom: 5px; overflow: hidden; }
        .foto-box img { width: 100%; height: 100%; object-fit: cover; }
        .numero-carnet { font-weight: bold; font-family: 'Cinzel'; font-size: 0.8rem; }

        .frontal-campos { flex: 1; display: flex; flex-direction: column; gap: 6px; }
        .campo label { font-family: 'Cinzel'; font-size: 0.65rem; font-weight: bold; display: block; }
        .valor { border-bottom: 1px solid #ccc; font-size: 0.95rem; padding-bottom: 2px; min-height: 1.1rem; }
        .campos-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        .frontal-footer { padding: 5px 20px 12px; display: flex; justify-content: space-around; align-items: flex-end; }
        .sello-wrap { text-align: center; }
        .firma-imagen-wrap-sm {
            height: 42px;
            margin-bottom: -42px;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: none;
            position: relative;
            top: -34px;
            z-index: 5;
        }
        .firma-imagen-wrap-sm img {
            height: 100%;
            max-width: 120px;
            object-fit: contain;
        }
        .firma-linea-sm {
            width: 140px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }
        .firma-label { font-family: 'Cinzel'; font-size: 0.6rem; }
        .sello-circulo { width: 65px; height: 65px; border: 1px solid var(--gris-linea); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.5rem; font-family: 'Cinzel'; }

        /* Reverso */
        .reverso-body { padding: 15px 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .full-col { grid-column: 1 / -1; }
        .reverso-footer { padding: 10px 20px 15px; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: flex-end; margin-top: auto; }
        .huella-box { width: 75px; height: 95px; border: 1px solid #999; text-align: center; font-size: 0.55rem; }
        .huella-oval { width: 35px; height: 50px; border: 1px solid #ccc; border-radius: 50%; margin: 5px auto; }
        .ministerio-wrap { text-align: right; font-family: 'Cinzel'; font-size: 0.7rem; }
        .atendio-wrap { width: 100%; text-align: center; font-size: 0.65rem; color: #666; font-style: italic; padding: 5px; }
    </style>
</head>
<body>

    <!-- Barra de Control Superior -->
    <div class="controls-header">
        <div class="header-title">Vista 3D Interactiva</div>
        <div style="display: flex; gap: 12px;">
            <button class="btn-action btn-back" onclick="window.close() || (window.location.href = '../views/recepcion_minoridad.php')">
                <i class="bi bi-arrow-left"></i> Volver
            </button>
        </div>
    </div>

    <!-- Contenedor 3D -->
    <div class="preview-container">
        <!-- Indicador de acción -->
        <div class="preview-instruction" onclick="document.getElementById('flipCard').classList.toggle('flipped')">
            <i class="bi bi-arrow-repeat" style="font-size: 1.1rem; vertical-align: middle;"></i> Haz clic en el carnet para girarlo en 3D
        </div>

        <!-- CONTENEDOR 3D FLIP -->
        <div class="card-flip-container" id="flipCard" onclick="this.classList.toggle('flipped')">
            <div class="card-flip-inner" style="width: 100%; height: 100%; position: relative; transform-style: preserve-3d; transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);">
                
                <!-- CARA FRONTAL -->
                <div class="card-front">
                    <div class="hoja">
                        <div class="encabezado">
                            <div class="logo-wrap">
                                <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" alt="Escudo">
                            </div>
                            <div class="encabezado-texto">
                                <h1>REPÚBLICA DE EL SALVADOR<br>DOCUMENTO DE IDENTIDAD PERSONAL<br><?= strtoupper($datos_municipio['alcaldia']) ?></h1>
                                <div class="titulo-doc">Carnet de Minoridad</div>
                            </div>
                        </div>

                        <div class="frontal-body">
                            <div class="foto-wrap">
                                <div class="foto-box">
                                    <?php if ($datos_menor['foto']): ?>
                                        <img src="<?= $datos_menor['foto'] ?>" alt="Foto">
                                    <?php endif; ?>
                                </div>
                                <div class="numero-carnet"><?= $datos_menor['numero_carnet'] ?></div>
                            </div>
                            <div class="frontal-campos">
                                <div class="campo"><label>Apellidos</label><div class="valor"><?= $datos_menor['apellidos'] ?></div></div>
                                <div class="campo"><label>Nombres</label><div class="valor"><?= $datos_menor['nombres'] ?></div></div>
                                <div class="campo"><label>Lugar y Fecha de Nacimiento</label><div class="valor"><?= $datos_menor['lugar_nacimiento'] ?> | <?= $datos_menor['fecha_nacimiento'] ?></div></div>
                                <div class="campos-grid">
                                    <div class="campo"><label>Fecha Expedición</label><div class="valor"><?= $datos_menor['fecha_expedicion'] ?></div></div>
                                    <div class="campo"><label>Fecha Vencimiento</label><div class="valor"><?= $datos_menor['fecha_vencimiento'] ?></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="frontal-footer">
                            <div class="sello-wrap" style="position: relative;">
                                <div class="firma-imagen-wrap-sm">
                                    <img src="../assets/uploads/firmas/firma2.png" alt="Firma Alcalde">
                                </div>
                                <div class="firma-linea-sm"></div>
                                <div class="firma-label">Alcalde</div>
                                <div style="font-size:0.7rem"><?= $datos_footer['alcalde'] ?></div>
                            </div>
                            <div class="sello-wrap">
                                <div class="sello-circulo" style="border: none; position: relative;">
                                    <img src="../assets/Img/sello_ilobasco.png" alt="Sello" style="width: 75px; height: 75px; object-fit: contain; position: absolute; top: -5px; left: -5px; opacity: 0.85; transform: rotate(-5deg);">
                                </div>
                            </div>
                            <div class="sello-wrap" style="position: relative;">
                                <div class="firma-imagen-wrap-sm">
                                    <img src="../assets/uploads/firmas/firma1.png" alt="Firma">
                                </div>
                                <div class="firma-linea-sm"></div>
                                <div class="firma-label">Secretario(a)</div>
                                <div style="font-size:0.7rem"><?= $datos_footer['secretario'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARA POSTERIOR (REVERSO) -->
                <div class="card-back">
                    <div class="hoja">
                        <div class="reverso-body">
                            <div class="campo full-col"><label>Dirección</label><div class="valor"><?= $datos_reverso['direccion'] ?></div></div>
                            <div class="campo"><label>Nombre de la Madre</label><div class="valor"><?= $datos_reverso['nombre_madre'] ?></div></div>
                            <div class="campo"><label>Tipo de Trámite</label><div class="valor"><?= $datos_reverso['tipo_tramite'] ?></div></div>
                            <div class="campo full-col"><label>Nombre del Padre</label><div class="valor"><?= $datos_reverso['nombre_padre'] ?></div></div>
                            <div class="campo"><label>Color de Piel</label><div class="valor"><?= $datos_reverso['color_piel'] ?></div></div>
                            <div class="campo"><label>Color de Ojos</label><div class="valor"><?= $datos_reverso['color_ojos'] ?></div></div>
                            <div class="campo full-col"><label>Centro de Estudios</label><div class="valor"><?= $datos_reverso['centro_estudios'] ?></div></div>
                        </div>

                        <div class="reverso-footer">
                            <div class="sello-wrap" style="position: relative; min-width: 140px;" id="reversoFirmaSelloWrap">
                                <div class="firma-imagen-wrap-sm" id="reversoFirmaImagenWrap" style="display: none;">
                                    <img id="reversoFirmaImg" src="" alt="Firma">
                                </div>
                                <div class="firma-linea-sm" style="width:140px; margin: 0 auto 5px auto;"></div>
                                <div class="firma-label" id="reversoFirmaLabel">Firma</div>
                            </div>
                            <?php $random_huella = rand(1, 10); ?>
                            <div class="huella-box">
                                <img src="../assets/uploads/huellas/huella_<?= $random_huella ?>.png" style="width: 60px; height: 74px; object-fit: contain; border: none; opacity: 0.85; display: block; margin: 2px auto;" alt="Huella">
                                <span style="display: block; margin-top: -3px; font-weight: bold; font-family: 'Cinzel', serif;">Huella</span>
                            </div>
                            <div class="ministerio-wrap">MINISTERIO DE HACIENDA<br>No <?= $datos_menor['numero_carnet'] ?> "A"</div>
                        </div>
                        <div class="atendio-wrap"><?= $datos_footer['atendio'] ?></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const id_carnet = "<?= htmlspecialchars($id_carnet) ?>";

        window.onload = function() {
            const storedSig = localStorage.getItem('saved_signature_data');
            const storedType = localStorage.getItem('saved_signature_type');
            
            if (storedSig) {
                const imgWrap = document.getElementById('reversoFirmaImagenWrap');
                const img = document.getElementById('reversoFirmaImg');
                const label = document.getElementById('reversoFirmaLabel');
                
                if (img && imgWrap && label) {
                    img.src = storedSig;
                    imgWrap.style.display = 'flex';
                    label.textContent = storedType === 'menor' ? 'Firma del Menor' : 'Firma del Padre/Tutor';
                }
                
                // Rotar automáticamente el carnet a la cara posterior en 3D
                const flipCard = document.getElementById('flipCard');
                if (flipCard) {
                    setTimeout(() => {
                        flipCard.classList.add('flipped');
                    }, 650);
                }
            }
        };
    </script>
</body>
</html>
