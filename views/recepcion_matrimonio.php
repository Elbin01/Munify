<?php
session_start();
require_once __DIR__ . '/../models/ActaMatrimonioModel.php';

$modelo = new ActaMatrimonioModel();
$actas = $modelo->obtenerTodas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Actas de Matrimonio - Munify</title>
    
    <?php include 'layouts/fonts.php'; ?>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/panel_ayuda.css?v=<?= time() ?>">

    <style>
        .form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,.05);
            padding: 30px;
            margin-bottom: 20px;
        }
        .section-title {
            color: var(--color-3);
            border-bottom: 2px solid var(--color-3);
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        /* Wizard Styles */
        .step { display: none; }
        .step.active { display: block; }
        .wizard-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }
        .wizard-header::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }
        .step-indicator {
            position: relative;
            z-index: 2;
            background: white;
            padding: 0 10px;
            text-align: center;
            color: #6c757d;
            font-weight: 600;
        }
        .step-indicator .circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
            transition: all 0.3s;
        }
        .step-indicator.active .circle {
            background: var(--color-3);
            color: white;
        }
        .step-indicator.active { color: var(--color-3); }
        .step-indicator.completed .circle {
            background: #198754;
            color: white;
        }
        
        /* Table Styles */
        .table-custom th {
            background-color: var(--color-3) !important;
            color: white !important;
            font-weight: 600;
        }
        .table-custom tbody tr { cursor: pointer; }
        .table-custom tbody tr:hover { background-color: #f1f3f5; }
        
        /* Offcanvas Custom */
        .offcanvas-body-custom {
            background: #f8f9fa;
        }
        .info-block {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<div class="dashboard-container d-flex">

    <?php include 'layouts/sidebar.php'; ?>

    <main class="main-content flex-grow-1" style="background:#f8f9fa; min-height:100vh;">
        <div class="container-fluid py-4 px-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color: var(--color-3);">
                        Actas de Matrimonio
                        <button class="btn btn-sm btn-outline-secondary rounded-circle shadow-sm ms-2" data-bs-toggle="offcanvas" data-bs-target="#ayudaMunify" style="width: 24px; height: 24px; padding: 0; font-size: 0.75rem;">
                            <i class="bi bi-info-lg"></i>
                        </button>
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a></li>
                            <li class="breadcrumb-item active fw-semibold small" style="color: var(--color-3);">Gestión de Actas</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaActa" style="background-color: var(--color-3); border-color: var(--color-3); border-radius: 10px;">
                        <i class="bi bi-plus-circle me-2"></i> Nueva Acta
                    </button>
                </div>
            </div>

            <!-- TABLA DE ACTAS -->
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="tablaActas" class="table table-custom table-hover align-middle w-100">
                            <thead>
                                <tr>
                                    <th>N° Acta</th>
                                    <th>Fecha Boda</th>
                                    <th>Novio</th>
                                    <th>Novia</th>
                                    <th>Fecha Registro</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($actas as $acta): ?>
                                <tr data-id="<?= $acta['id_acta'] ?>" class="fila-acta">
                                    <td class="fw-bold"><?= htmlspecialchars($acta['numero_acta']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($acta['fecha_matrimonio'])) ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= htmlspecialchars($acta['novio_nombre_completo']) ?></div>
                                        <small class="text-muted">DUI: <?= htmlspecialchars($acta['novio_dui']) ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= htmlspecialchars($acta['novia_nombre_completo']) ?></div>
                                        <small class="text-muted">DUI: <?= htmlspecialchars($acta['novia_dui']) ?></small>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($acta['fecha_registro'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary btn-ver-acta" data-id="<?= $acta['id_acta'] ?>" title="Ver Datos del Formulario">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <a href="acta_de_matrimonio.php?id=<?= $acta['id_acta'] ?>" target="_blank" class="btn btn-outline-secondary" title="Ver Acta">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>
                                            <a href="certificacion_matrimonio.php?id=<?= $acta['id_acta'] ?>" target="_blank" class="btn btn-outline-success" title="Ver Certificado">
                                                <i class="bi bi-file-earmark-check"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        
        <?php include 'layouts/footer.php'; ?>
    </main>
</div>

<!-- MODAL NUEVA ACTA (WIZARD) -->
<div class="modal fade" id="modalNuevaActa" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header" style="background-color: var(--color-3); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title"><i class="bi bi-journal-plus me-2"></i> Registrar Nueva Acta de Matrimonio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                
                <div class="wizard-header px-5">
                    <div class="step-indicator active" id="ind-step-1">
                        <div class="circle">1</div>
                        <small>Contrayentes</small>
                    </div>
                    <div class="step-indicator" id="ind-step-2">
                        <div class="circle">2</div>
                        <small>Detalles</small>
                    </div>
                    <div class="step-indicator" id="ind-step-3">
                        <div class="circle">3</div>
                        <small>Oficial</small>
                    </div>
                </div>

                <form id="formMatrimonio">
                    
                    <!-- PASO 1: Contrayentes -->
                    <div class="step active" id="step-1">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-card shadow-sm border-0">
                                    <h5 class="section-title">Datos del Novio</h5>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Nombre Completo</label>
                                        <input type="text" class="form-control letras-only" name="novio_nombre_completo" required>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Edad</label>
                                            <input type="number" class="form-control numeros-only" name="novio_edad" min="18" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Profesión</label>
                                            <input type="text" class="form-control letras-only" name="novio_profesion" required>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Nacionalidad</label>
                                            <input type="text" class="form-control" name="novio_nacionalidad" value="Salvadoreña" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">DUI</label>
                                            <input type="text" class="form-control dui-mask" name="novio_dui" placeholder="00000000-0" maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Domicilio</label>
                                        <input type="text" class="form-control" name="novio_domicilio" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-card shadow-sm border-0">
                                    <h5 class="section-title">Datos de la Novia</h5>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Nombre Completo</label>
                                        <input type="text" class="form-control letras-only" name="novia_nombre_completo" required>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Edad</label>
                                            <input type="number" class="form-control numeros-only" name="novia_edad" min="18" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Profesión</label>
                                            <input type="text" class="form-control letras-only" name="novia_profesion" required>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Nacionalidad</label>
                                            <input type="text" class="form-control" name="novia_nacionalidad" value="Salvadoreña" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">DUI</label>
                                            <input type="text" class="form-control dui-mask" name="novia_dui" placeholder="00000000-0" maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Domicilio</label>
                                        <input type="text" class="form-control" name="novia_domicilio" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 2: Detalles del Acta y Boda -->
                    <div class="step" id="step-2">
                        <div class="form-card shadow-sm border-0">
                            <h5 class="section-title">Datos del Registro Físico</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Número de Acta</label>
                                    <input type="text" class="form-control numeros-only" name="numero_acta" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Libro (Tomo)</label>
                                    <input type="text" class="form-control numeros-only" name="libro" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Folio</label>
                                    <input type="text" class="form-control numeros-only" name="folio" required>
                                </div>
                            </div>

                            <h5 class="section-title mt-4">Detalles del Matrimonio</h5>
                            <div class="row g-3 mb-2">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Régimen Patrimonial</label>
                                    <select class="form-select" name="regimen_patrimonial" required>
                                        <option value="Comunidad Diferida">Comunidad Diferida</option>
                                        <option value="Separación de Bienes">Separación de Bienes</option>
                                        <option value="Participación en las Ganancias">Participación en las Ganancias</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Fecha de Matrimonio</label>
                                    <input type="date" class="form-control" name="fecha_matrimonio" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Hora de Matrimonio</label>
                                    <input type="time" class="form-control" name="hora_matrimonio" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 3: Oficial y Testigos -->
                    <div class="step" id="step-3">
                        <div class="form-card shadow-sm border-0">
                            <h5 class="section-title">Autoridad que Celebra</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nombre del Oficial</label>
                                    <input type="text" class="form-control letras-only" name="nombre_oficial" value="Carlos Antonio Méndez" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Cargo</label>
                                    <input type="text" class="form-control letras-only" name="cargo_oficial" value="Alcalde Municipal" required>
                                </div>
                            </div>

                            <h5 class="section-title mt-4">Testigos Presenciales</h5>
                            <div class="row g-3 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nombre Testigo 1</label>
                                    <input type="text" class="form-control letras-only" name="testigo1_nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nombre Testigo 2</label>
                                    <input type="text" class="form-control letras-only" name="testigo2_nombre" required>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer border-0 bg-white">
                <button type="button" class="btn btn-secondary px-4" id="btnAnterior" style="display: none;">Anterior</button>
                <button type="button" class="btn btn-primary px-4" id="btnSiguiente" style="background-color: var(--color-3); border: none;">Siguiente</button>
                <button type="button" class="btn btn-success px-4" id="btnGuardar" style="display: none;"><i class="bi bi-save me-2"></i> Guardar Acta</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VER DETALLES DE ACTA -->
<div class="modal fade" id="modalVerActa" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background-color: var(--color-3); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i> Detalles del Acta N° <span id="ocNumero">---</span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-block h-100">
                            <h6 class="text-muted border-bottom pb-2 mb-3"><i class="bi bi-calendar-heart me-2"></i>Datos de la Boda</h6>
                            <div class="mb-2"><small class="text-muted d-block">Fecha:</small><strong id="ocFechaBoda">---</strong></div>
                            <div class="mb-2"><small class="text-muted d-block">Régimen:</small><strong id="ocRegimen">---</strong></div>
                            <div class="mb-2"><small class="text-muted d-block">Ubicación Física:</small><strong id="ocUbicacion">Libro ---, Folio ---</strong></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-block h-100">
                            <h6 class="text-muted border-bottom pb-2 mb-3"><i class="bi bi-person-badge me-2"></i>Autoridad</h6>
                            <div class="mb-2"><strong id="ocOficial">---</strong></div>
                            <div class="small text-muted" id="ocCargo">---</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-block">
                            <h6 class="text-muted border-bottom pb-2 mb-3"><i class="bi bi-people me-2"></i>Contrayentes</h6>
                            <div class="row">
                                <div class="col-6 border-end">
                                    <small class="text-muted d-block">El Novio:</small>
                                    <strong id="ocNovio" class="d-block text-primary">---</strong>
                                    <small id="ocNovioDui" class="text-secondary">DUI: ---</small>
                                </div>
                                <div class="col-6 ps-3">
                                    <small class="text-muted d-block">La Novia:</small>
                                    <strong id="ocNovia" class="d-block" style="color: #d81b60;">---</strong>
                                    <small id="ocNoviaDui" class="text-secondary">DUI: ---</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-white">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- PANEL DE AYUDA (OFFCANVAS) -->
<div class="offcanvas offcanvas-end help-panel" tabindex="-1" id="ayudaMunify" aria-labelledby="ayudaLabel">
    <div class="offcanvas-header help-header shadow-sm">
        <h5 class="offcanvas-title" id="ayudaLabel">
            <i class="bi bi-patch-question-fill me-2"></i> Guía de Usuario
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="help-section-title">Opciones del Módulo</div>
        
        <div class="help-card d-flex align-items-start shadow-sm">
            <div class="help-step-badge me-3"><i class="bi bi-plus-circle"></i></div>
            <div>
                <p class="small text-dark mb-0"><strong>Nueva Acta:</strong> Haga clic en este botón para registrar un nuevo matrimonio. Llenará los datos de los novios, la fecha y régimen, y finalmente los detalles del oficial y testigos.</p>
            </div>
        </div>

        <div class="help-card d-flex align-items-start shadow-sm">
            <div class="help-step-badge me-3 bg-info"><i class="bi bi-eye text-white"></i></div>
            <div>
                <p class="small text-dark mb-0"><strong>Ver Detalles:</strong> Use el botón del "ojo" en la tabla para revisar rápidamente los datos ingresados en el formulario de registro de cada acta.</p>
            </div>
        </div>

        <div class="help-card d-flex align-items-start shadow-sm">
            <div class="help-step-badge me-3 bg-secondary"><i class="bi bi-file-earmark-text text-white"></i></div>
            <div>
                <p class="small text-dark mb-0"><strong>Imprimir Acta:</strong> El botón gris le abrirá directamente el documento "Acta de Matrimonio Civil" en formato completo con toda la redacción legal.</p>
            </div>
        </div>

        <div class="help-card d-flex align-items-start shadow-sm">
            <div class="help-step-badge me-3 bg-success"><i class="bi bi-file-earmark-check text-white"></i></div>
            <div>
                <p class="small text-dark mb-0"><strong>Certificación:</strong> El botón verde le generará el "Certificado de Partida de Matrimonio", que es el formato tabular con los extractos del libro para entregar a los esposos.</p>
            </div>
        </div>

        <div class="mt-5 pt-4 text-center border-top">
            <img src="../assets/Img/escudo.jpeg" alt="Escudo" style="width: 30px; opacity: 0.3; filter: grayscale(1);">
            <p class="text-muted mt-2" style="font-size: 0.65rem; font-weight: bold;">SISTEMA MUNIFY v1.0</p>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Inicializar DataTable
    $('#tablaActas').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        order: [[4, 'desc']]
    });

    // Máscara automática para DUI (formato: 00000000-0)
    $('.dui-mask').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Eliminar caracteres no numéricos
        if (value.length > 8) {
            value = value.substring(0, 8) + '-' + value.substring(8, 9);
        }
        $(this).val(value);
    });

    // WIZARD LOGIC
    let currentStep = 1;
    const totalSteps = 3;

    function updateWizard() {
        $('.step').removeClass('active');
        $(`#step-${currentStep}`).addClass('active');

        // Actualizar indicadores
        for(let i=1; i<=totalSteps; i++) {
            if (i < currentStep) {
                $(`#ind-step-${i}`).addClass('completed').removeClass('active');
            } else if (i === currentStep) {
                $(`#ind-step-${i}`).addClass('active').removeClass('completed');
            } else {
                $(`#ind-step-${i}`).removeClass('active completed');
            }
        }

        // Botones
        if (currentStep === 1) {
            $('#btnAnterior').hide();
            $('#btnSiguiente').show();
            $('#btnGuardar').hide();
        } else if (currentStep === totalSteps) {
            $('#btnAnterior').show();
            $('#btnSiguiente').hide();
            $('#btnGuardar').show();
        } else {
            $('#btnAnterior').show();
            $('#btnSiguiente').show();
            $('#btnGuardar').hide();
        }
    }

    $('#btnSiguiente').click(function() {
        // Validación básica (HTML5 checkValidity no funciona directo sin trigger, hacemos un hack o validamos required)
        const inputs = $(`#step-${currentStep} [required]`);
        let valid = true;
        inputs.each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!valid) {
            Swal.fire('Atención', 'Complete los campos obligatorios antes de continuar.', 'warning');
            return;
        }

        if (currentStep < totalSteps) {
            currentStep++;
            updateWizard();
        }
    });

    $('#btnAnterior').click(function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizard();
        }
    });

    // Guardar Acta (AJAX)
    $('#btnGuardar').click(function() {
        const form = document.getElementById('formMatrimonio');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: '¿Registrar Acta?',
            text: '¿Está seguro que todos los datos están correctos?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Guardando...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

                $.ajax({
                    url: '../controller/guardar_matrimonio.php',
                    type: 'POST',
                    data: $('#formMatrimonio').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Ocultar modal y form
                            $('#modalNuevaActa').modal('hide');
                            
                            Swal.fire({
                                icon: 'success',
                                title: '¡Acta Guardada!',
                                text: '¿Desea imprimir los documentos generados?',
                                showCancelButton: true,
                                confirmButtonColor: '#1C3166',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: '<i class="bi bi-printer me-2"></i>Sí, imprimir',
                                cancelButtonText: 'No, solo cerrar'
                            }).then((resPrint) => {
                                if (resPrint.isConfirmed) {
                                    // Abrir pestañas
                                    const id = response.id_acta; 
                                    window.open(`acta_de_matrimonio.php?id=${id}`, '_blank');
                                    window.open(`certificacion_matrimonio.php?id=${id}`, '_blank');
                                }
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un problema de conexión con el servidor.', 'error');
                    }
                });
            }
        });
    });

    // MODAL DETALLES LOGIC
    $('.fila-acta').click(function(e) {
        if($(e.target).closest('a').length) return; // Si clickea en link, no hace nada

        const id = $(this).data('id');
        
        // Obtener detalles del acta por AJAX
        $.ajax({
            url: '../controller/obtener_acta_json.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    $('#ocNumero').text(data.numero_acta);
                    $('#ocFechaBoda').text(data.fecha_matrimonio);
                    $('#ocRegimen').text(data.regimen_patrimonial);
                    $('#ocUbicacion').text(`Libro ${data.libro}, Folio ${data.folio}`);
                    
                    $('#ocNovio').text(data.novio_nombre_completo);
                    $('#ocNovioDui').text('DUI: ' + data.novio_dui);
                    
                    $('#ocNovia').text(data.novia_nombre_completo);
                    $('#ocNoviaDui').text('DUI: ' + data.novia_dui);

                    $('#ocOficial').text(data.nombre_oficial);
                    $('#ocCargo').text(data.cargo_oficial);

                    var miModal = new bootstrap.Modal(document.getElementById('modalVerActa'));
                    miModal.show();
                } else {
                    Swal.fire('Error', 'No se pudo cargar la información.', 'error');
                }
            }
        });
    });

    // Reiniciar Wizard al cerrar modal
    $('#modalNuevaActa').on('hidden.bs.modal', function () {
        document.getElementById('formMatrimonio').reset();
        currentStep = 1;
        updateWizard();
    });

});
</script>

</body>
</html>
