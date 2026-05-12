<?php
// Configuración de datos (Simulando la base de datos o POST)
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
    'numero_carnet'      => '0601-' . rand(100000, 999999),
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet de Minoridad – <?= htmlspecialchars($datos_menor['nombres']) ?></title>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap');

        /* Estilos Base */
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

        /* Botón Flotante */
        .btn-imprimir {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: var(--negro);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Cinzel', serif;
            font-size: 0.8rem;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: 0.3s;
        }
        .btn-imprimir:hover { background: var(--azul-oscuro); }

        .cara-label {
            font-family: 'Cinzel', serif;
            font-size: 0.7rem;
            margin: 15px 0 5px;
            color: #555;
            text-transform: uppercase;
            width: 760px;
        }

        /* Estructura del Carnet */
        .hoja {
            width: 760px;
            background: white;
            border: 1px solid #999;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            margin-bottom: 20px; /* Reducido para que quepa en una hoja */
        }

        /* Encabezado */
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

        /* Cuerpo Frontal */
        .frontal-body { padding: 15px 20px; display: flex; gap: 20px; }
        .foto-wrap { width: 130px; text-align: center; }
        .foto-box { width: 130px; height: 160px; border: 2px solid #000; background: #eee; margin-bottom: 5px; overflow: hidden; }
        .foto-box img { width: 100%; height: 100%; object-fit: cover; }
        .numero-carnet { font-weight: bold; font-family: 'Cinzel'; font-size: 0.8rem; }

        .frontal-campos { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .campo label { font-family: 'Cinzel'; font-size: 0.65rem; font-weight: bold; display: block; }
        .valor { border-bottom: 1px solid #ccc; font-size: 0.95rem; padding-bottom: 2px; min-height: 1.1rem; }
        .campos-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        /* Firmas y Sellos */
        .frontal-footer { padding: 5px 20px 15px; display: flex; justify-content: space-around; align-items: flex-end; }
        .sello-wrap { text-align: center; }
        .firma-linea-sm { width: 140px; border-bottom: 1px solid #000; margin-bottom: 5px; }
        .firma-label { font-family: 'Cinzel'; font-size: 0.6rem; }
        .sello-circulo { width: 65px; height: 65px; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.5rem; font-family: 'Cinzel'; }

        /* Reverso */
        .reverso-body { padding: 15px 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .full-col { grid-column: 1 / -1; }
        .reverso-footer { padding: 15px 20px; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: flex-end; }
        .huella-box { width: 60px; height: 75px; border: 1px solid #999; text-align: center; font-size: 0.5rem; }
        .huella-oval { width: 35px; height: 50px; border: 1px solid #ccc; border-radius: 50%; margin: 5px auto; }
        .ministerio-wrap { text-align: right; font-family: 'Cinzel'; font-size: 0.7rem; }
        .atendio-wrap { width: 100%; text-align: center; font-size: 0.65rem; color: #666; font-style: italic; padding: 5px; }

        /* ── CONFIGURACIÓN DE IMPRESIÓN (UNA SOLA PÁGINA) ── */
        @media print {
            body { background: white; padding: 0; margin: 0; }
            .btn-imprimir, .cara-label { display: none !important; }
            .hoja { 
                margin: 20px auto !important; /* Espacio pequeño entre caras */
                box-shadow: none !important;
                border: 1px solid #000 !important;
                page-break-after: avoid; /* EVITA SALTO DE PÁGINA */
                page-break-inside: avoid;
                display: block !important;
            }
        }
    </style>
</head>
<body>

<button class="btn-imprimir" onclick="confirmarImpresion()">&#128438; Imprimir Carnet</button>

<!-- CARA FRONTAL -->
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
        <div class="logo-wrap">
            <div style="font-size: 8px; text-align: center; padding: 5px;">LOGO ALCALDÍA</div>
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
        <div class="sello-wrap"><div class="firma-linea-sm"></div><div class="firma-label">Alcalde</div><div style="font-size:0.7rem"><?= $datos_footer['alcalde'] ?></div></div>
        <div class="sello-wrap"><div class="sello-circulo">SELLO<br>ALCALDÍA</div></div>
        <div class="sello-wrap"><div class="firma-linea-sm"></div><div class="firma-label">Secretario(a)</div><div style="font-size:0.7rem"><?= $datos_footer['secretario'] ?></div></div>
    </div>
</div>

<!-- CARA POSTERIOR -->
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
        <div class="sello-wrap"><div class="firma-linea-sm" style="width:100px"></div><div class="firma-label">Firma</div></div>
        <div class="huella-box"><div class="huella-oval"></div><span>Huella</span></div>
        <div class="ministerio-wrap">MINISTERIO DE HACIENDA<br>No <?= $datos_menor['numero_carnet'] ?> "A"</div>
    </div>
    <div class="atendio-wrap"><?= $datos_footer['atendio'] ?></div>
</div>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    function confirmarImpresion() {
        Swal.fire({
            title: '¿Imprimir Carnet?',
            text: "Se imprimirán ambas caras en una sola página.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#003366',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, imprimir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                
                Toast.fire({
                    icon: 'info',
                    title: 'Preparando documento...'
                });

                
                setTimeout(() => {
                    
                    Swal.close(); 
                    window.print();
                }, 2500); 
            }
        });
    }
</script>

</body>
</html>