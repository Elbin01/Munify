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
    // Lógica original de la vista (POST)
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
    <title>Carnet de Minoridad – <?= htmlspecialchars($datos_menor['nombres']) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --negro: #000000;
            --azul-oscuro: #003366;
            --blanco: #ffffff;
            --gris-claro: #f5f5f5;
            --gris-linea: #cccccc;
            --texto: #111111;
        }

        body {
            font-family: 'EB Garamond', Georgia, serif;
            background: #e0e0e0;
            color: var(--texto);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
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
            bottom: 20px;
            left: 20px;
            padding: 10px 20px;
            background: var(--azul-oscuro);
            color: var(--blanco);
            border: 2px solid var(--negro);
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-volver:hover { 
            background: var(--negro); 
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(28, 49, 102, 0.4);
        }

        .cara-label {
            font-family: 'Cinzel', serif;
            font-size: 0.7rem;
            margin: 15px 0 5px;
            color: #555;
            text-transform: uppercase;
            width: 760px;
        }

        .hoja {
            width: 760px;
            background: white;
            border: 1px solid #999;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            margin-bottom: 20px;
        }

        .encabezado {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            border-bottom: 2px solid var(--negro);
        }
        .logo-wrap { width: 60px; height: 60px; border: 1px solid #000; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #fff; }
        .logo-wrap img { width: 100%; height: 100%; object-fit: contain; }
        .encabezado-texto { flex: 1; text-align: center; }
        .encabezado-texto h1 { font-family: 'Cinzel', serif; font-size: 0.7rem; line-height: 1.2; }
        .titulo-doc { font-family: 'Cinzel', serif; font-size: 1rem; font-weight: bold; margin-top: 5px; }

        .frontal-body { padding: 15px 20px; display: flex; gap: 20px; }
        .foto-wrap { width: 130px; text-align: center; }
        .foto-box { width: 130px; height: 160px; border: 1px solid var(--gris-linea); background: #eee; margin-bottom: 5px; overflow: hidden; }
        .foto-box img { width: 100%; height: 100%; object-fit: cover; }
        .numero-carnet { font-weight: bold; font-family: 'Cinzel'; font-size: 0.8rem; }

        .frontal-campos { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .campo label { font-family: 'Cinzel'; font-size: 0.65rem; font-weight: bold; display: block; }
        .valor { border-bottom: 1px solid #ccc; font-size: 0.95rem; padding-bottom: 2px; min-height: 1.1rem; }
        .campos-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        .frontal-footer { padding: 5px 20px 15px; display: flex; justify-content: space-around; align-items: flex-end; }
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

        .reverso-body { padding: 15px 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .full-col { grid-column: 1 / -1; }
        .reverso-footer { padding: 15px 20px; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: flex-end; }
        .huella-box { width: 75px; height: 95px; border: 1px solid #999; text-align: center; font-size: 0.55rem; }
        .huella-oval { width: 35px; height: 50px; border: 1px solid #ccc; border-radius: 50%; margin: 5px auto; }
        .ministerio-wrap { text-align: right; font-family: 'Cinzel'; font-size: 0.7rem; }
        .atendio-wrap { width: 100%; text-align: center; font-size: 0.65rem; color: #666; font-style: italic; padding: 5px; }

        .btn-3d-floating {
            position: fixed;
            top: 1rem;
            right: 11rem;
            padding: 0.4rem 0.9rem;
            background: #2e7d32;
            color: var(--blanco);
            border: 2px solid var(--negro);
            border-radius: 3px;
            cursor: pointer;
            font-family: 'Cinzel', serif;
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            box-shadow: 0 2px 8px rgba(0,0,0,0.25);
            z-index: 999;
            display: none;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }
        .btn-3d-floating:hover {
            background: var(--negro);
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

            body { background: white; padding: 0; margin: 0; }
            .btn-imprimir, .btn-volver, .cara-label, .btn-3d-floating { display: none !important; }
            .hoja { 
                margin: 20px auto !important;
                box-shadow: none !important;
                border: 1px solid #000 !important;
                page-break-after: avoid;
                page-break-inside: avoid;
                display: block !important;
            }
        }
    </style>
</head>
<body>

<button class="btn-3d-floating no-print" id="btnVer3D" onclick="irAVer3D()">Ver Carnet 3D</button>
<button class="btn-imprimir" onclick="preguntarFirmaReverso()">Imprimir Carnet</button>

<div class="cara-label">▶ Cara frontal</div>
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

<div class="cara-label">▶ Cara posterior</div>
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

<button class="btn-volver" onclick="window.close() || (window.location.href = '../views/recepcion_minoridad.php')">Volver</button>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function preguntarFirmaReverso() {
    Swal.fire({
        title: '¿Agregar firma al reverso?',
        text: '¿Desea dibujar e incorporar la firma del menor o la del padre/tutor en la parte trasera del carnet?',
        icon: 'question',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Firma del Menor',
        denyButtonText: 'Firma del Padre/Tutor',
        cancelButtonText: 'Omitir y continuar',
        confirmButtonColor: '#1C3166',
        denyButtonColor: '#2e7d32',
        cancelButtonColor: '#757575',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            abrirModalFirma('menor');
        } else if (result.isDenied) {
            abrirModalFirma('padre');
        } else {
            confirmarImpresion();
        }
    });
}

function abrirModalFirma(tipo) {
    const titulo = tipo === 'menor' ? 'Firma del Menor' : 'Firma del Padre / Madre / Tutor';
    Swal.fire({
        title: `Dibujar ${titulo}`,
        html: `
            <div style="text-align: center; font-family: 'EB Garamond', Georgia, serif;">
                <p style="color: #555; font-size: 0.9rem; margin-bottom: 15px;">
                    Dibuje la firma dentro del recuadro blanco usando su ratón, panel táctil o pantalla móvil.
                </p>
                <div style="position: relative; width: 100%; max-width: 440px; margin: 0 auto; background: #FFFFFF; border: 2px dashed #1C3166; border-radius: 12px; overflow: hidden; aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 8px rgba(0,0,0,0.1);">
                    <canvas id="modalFirmaCanvas" style="width: 100%; height: 100%; display: block; cursor: crosshair; touch-action: none;"></canvas>
                    <div id="modalFirmaHint" style="position: absolute; pointer-events: none; color: #aaa; font-weight: bold; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; transition: opacity 0.2s;">
                         Dibuje la firma aquí
                    </div>
                </div>
                <div style="margin-top: 15px; display: flex; justify-content: center; gap: 10px;">
                    <button type="button" id="btnLimpiarModalFirma" class="swal2-styled" style="background-color: #757575; color: white; margin: 0; padding: 6px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: bold;">
                        Limpiar
                    </button>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: ' Guardar Firma',
        cancelButtonText: 'Atrás',
        confirmButtonColor: '#1C3166',
        cancelButtonColor: '#d33',
        allowOutsideClick: false,
        preConfirm: () => {
            const canvas = document.getElementById('modalFirmaCanvas');
            const cropped = getCroppedCanvas(canvas);
            if (!cropped) {
                Swal.showValidationMessage('Por favor, dibuje una firma antes de guardar.');
                return false;
            }
            return {
                dataURL: cropped.toDataURL('image/png'),
                tipo: tipo
            };
        },
        didOpen: () => {
            const canvas = document.getElementById('modalFirmaCanvas');
            const ctx = canvas.getContext('2d');
            const hint = document.getElementById('modalFirmaHint');
            const btnLimpiar = document.getElementById('btnLimpiarModalFirma');
            
            let drawing = false;
            
            // Adjust canvas size to client dimensions
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
            
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.strokeStyle = '#1C3166';
            ctx.lineWidth = 3;
            
            function getCoordinates(e) {
                const r = canvas.getBoundingClientRect();
                if (e.touches && e.touches.length > 0) {
                    return {
                        x: e.touches[0].clientX - r.left,
                        y: e.touches[0].clientY - r.top
                    };
                } else {
                    return {
                        x: e.clientX - r.left,
                        y: e.clientY - r.top
                    };
                }
            }
            
            function startDrawing(e) {
                e.preventDefault();
                drawing = true;
                hint.style.opacity = '0';
                const coords = getCoordinates(e);
                ctx.beginPath();
                ctx.moveTo(coords.x, coords.y);
                ctx.lineTo(coords.x, coords.y);
                ctx.stroke();
            }
            
            function draw(e) {
                if (!drawing) return;
                e.preventDefault();
                const coords = getCoordinates(e);
                ctx.lineTo(coords.x, coords.y);
                ctx.stroke();
            }
            
            function stopDrawing() {
                if (drawing) {
                    drawing = false;
                    ctx.closePath();
                }
            }
            
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            window.addEventListener('mouseup', stopDrawing);
            
            canvas.addEventListener('touchstart', startDrawing, { passive: false });
            canvas.addEventListener('touchmove', draw, { passive: false });
            window.addEventListener('touchend', stopDrawing);
            
            btnLimpiar.addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                hint.style.opacity = '1';
            });
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            aplicarFirmaReverso(result.value.dataURL, result.value.tipo);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            preguntarFirmaReverso();
        }
    });
}

function getCroppedCanvas(canvas) {
    const ctx = canvas.getContext('2d');
    const w = canvas.width;
    const h = canvas.height;
    
    const imgData = ctx.getImageData(0, 0, w, h);
    const data = imgData.data;
    
    let minX = w, minY = h, maxX = 0, maxY = 0;
    let hasPixels = false;
    
    for (let y = 0; y < h; y++) {
        for (let x = 0; x < w; x++) {
            const alphaIndex = ((y * w) + x) * 4 + 3;
            if (data[alphaIndex] > 0) {
                hasPixels = true;
                if (x < minX) minX = x;
                if (x > maxX) maxX = x;
                if (y < minY) minY = y;
                if (y > maxY) maxY = y;
            }
        }
    }
    
    if (!hasPixels) return null;
    
    const croppedCanvas = document.createElement('canvas');
    const croppedCtx = croppedCanvas.getContext('2d');
    
    const padding = 10;
    const croppedWidth = (maxX - minX) + (padding * 2);
    const croppedHeight = (maxY - minY) + (padding * 2);
    
    croppedCanvas.width = croppedWidth;
    croppedCanvas.height = croppedHeight;
    
    croppedCtx.drawImage(
        canvas,
        minX, minY, (maxX - minX), (maxY - minY),
        padding, padding, (maxX - minX), (maxY - minY)
    );
    
    return croppedCanvas;
}

const id_carnet = "<?= htmlspecialchars($id_carnet ?? '') ?>";

function irAVer3D() {
    if (id_carnet) {
        window.open(`ver_carnet_3d.php?id=${id_carnet}`, '_blank');
    }
}

function aplicarFirmaReverso(dataURL, tipoFirma) {
    const imgWrap = document.getElementById('reversoFirmaImagenWrap');
    const img = document.getElementById('reversoFirmaImg');
    const label = document.getElementById('reversoFirmaLabel');
    
    img.src = dataURL;
    imgWrap.style.display = 'flex';
    
    if (tipoFirma === 'menor') {
        label.textContent = 'Firma del Menor';
    } else {
        label.textContent = 'Firma del Padre/Tutor';
    }

    // 1. Guardar en localStorage para coordinar con la pestaña 3D
    localStorage.setItem('saved_signature_data', dataURL);
    localStorage.setItem('saved_signature_type', tipoFirma);

    // 2. Activar y mostrar el botón de ver en 3D en la parte superior
    const btn3D = document.getElementById('btnVer3D');
    if (btn3D) {
        btn3D.style.display = 'flex';
    }
    
    setTimeout(() => {
        confirmarImpresion();
    }, 500);
}

function confirmarImpresion() {
    Swal.fire({
        title: 'Firma Guardada',
        text: 'La firma ha sido agregada con éxito. ¿Qué acción desea realizar a continuación con el carnet firmado?',
        icon: 'success',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonColor: '#1C3166',
        denyButtonColor: '#2e7d32',
        cancelButtonColor: '#757575',
        confirmButtonText: 'Imprimir',
        denyButtonText: 'Ver en 3D',
        cancelButtonText: 'Ver en pantalla'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.close();
            setTimeout(function() {
                window.print();
            }, 350);
        } else if (result.isDenied) {
            irAVer3D();
        }
    });
}

<?php if ($id_carnet): ?>
window.onload = function() { 
    // Limpiar firmas antiguas al cargar
    localStorage.removeItem('saved_signature_data');
    localStorage.removeItem('saved_signature_type');
    
    setTimeout(function() { preguntarFirmaReverso(); }, 500); 
};
<?php endif; ?>
</script>
</body>
</html>
