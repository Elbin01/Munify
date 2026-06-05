<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Defunción - Munify</title>
    <!-- Fonts -->
    <?php include 'layouts/fonts.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/partida.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/panel_ayuda.css?v=<?= time() ?>">
    <style>
        body { width: 100%; overflow-x: hidden; }
        .dashboard-container { display: flex; width: 100%; min-height: 100vh; background-color: var(--bg-light); }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            background-color: var(--bg-light);
        }
        .main-content > .container-fluid {
            flex: 1;
        }
        .btn-asiento {
            background-color: var(--color-3);
            color: white !important;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        .btn-asiento:hover {
            background-color: var(--color-4);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(28, 49, 102, 0.25);
            color: white !important;
        }
    </style>
</head>
<body>

    <!-- MODAL DEFUNCIÓN (Para Registrar) -->
    <div class="modal fade" id="modalDefuncion" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-person-x-fill me-2"></i>Registro de Defunción</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formDefuncion">
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-person-heart me-2"></i>Datos del Fallecido</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">Nombres</label>
                                    <input type="text" id="regNombres" class="form-control border-secondary-subtle shadow-none letras-only">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">Apellidos</label>
                                    <input type="text" id="regApellidos" class="form-control border-secondary-subtle shadow-none letras-only">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">DUI del Fallecido</label>
                                    <input type="text" id="modalRegDui" class="form-control border-secondary-subtle shadow-none dui-mask" placeholder="00000000-0" maxlength="10">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Fecha de Defunción</label>
                                    <input type="date" id="regFechaDef" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Hora de Defunción</label>
                                    <input type="time" id="regHoraDef" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark small">Lugar de Defunción</label>
                                    <input type="text" id="regLugarDef" class="form-control border-secondary-subtle shadow-none" placeholder="Ej. Hospital, Domicilio...">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-person-check me-2"></i>Datos del Declarante</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-12">
                                    <div class="card bg-light border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <label class="fw-bold form-label text-dark small">DUI Declarante</label>
                                                    <div class="input-group mb-2 shadow-sm">
                                                        <input type="text" class="form-control form-control-sm border-0 dui-mask" placeholder="Buscar DUI..." id="duiDeclarante" maxlength="10">
                                                        <button id="btnBuscarDeclarante" class="btn btn-sm text-white fw-bold" type="button" style="background-color: var(--color-3);">Buscar</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="fw-bold form-label text-dark small">Nombre Completo</label>
                                                    <input type="text" id="regNombreDeclarante" class="form-control form-control-sm border-secondary-subtle shadow-none letras-only" placeholder="Nombre completo del declarante">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0 mt-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardarDefuncion" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-save-fill me-2"></i> Guardar Acta
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CARTA DE DEFUNCIÓN (Para Generar) -->
    <div class="modal fade" id="modalPartida" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-x me-2"></i>Generar Carta de Defunción</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card bg-light border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h6 class="text-muted mb-4 border-bottom pb-2"><i class="bi bi-info-circle me-1"></i> Datos del Fallecido</h6>
                            <div class="row g-3 text-dark">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small mb-1">Nombre Completo:</span>
                                    <strong id="lblNombre" class="fs-6">---</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small mb-1">Fecha de Defunción:</span>
                                    <strong id="lblFechaDef" class="fs-6">---</strong>
                                </div>
                                <div class="col-sm-12">
                                    <span class="text-muted d-block small mb-1">Declarante:</span>
                                    <strong id="lblDeclarante" class="fs-6">---</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="formGenerarPartida" class="row g-3">
                        <div class="col-12 mb-1"><h6 class="border-bottom pb-2 text-muted"><i class="bi bi-folder2-open me-1"></i> Información del Folio</h6></div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Número de Acta</label>
                            <input type="text" id="partidaNum" class="form-control form-control-lg border-secondary-subtle shadow-none numeros-only" placeholder="Ej: 1542">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Libro</label>
                            <input type="text" id="partidaLibro" class="form-control form-control-lg border-secondary-subtle shadow-none numeros-only" placeholder="Ej: 12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Folio</label>
                            <input type="text" id="partidaFolio" class="form-control form-control-lg border-secondary-subtle shadow-none numeros-only" placeholder="Ej: 45">
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnImprimirDefuncion" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-printer-fill me-2"></i> Imprimir Documento
                    </button>
                </div>
            </div>
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
            <div class="help-section-title">Pasos del Trámite</div>
            
            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">1</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Localización:</strong> Busque al fallecido por nombre o DUI para verificar si el acta ya ha sido iniciada.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">2</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Nueva Acta:</strong> Si no hay registros, use <strong>"Registrar Defunción"</strong> e ingrese los datos del certificado médico.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">3</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Declarante:</strong> Registre el DUI y nombre de la persona que reporta el hecho como responsable legal.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">4</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Impresión:</strong> Complete el folio y libro físico, luego presione <strong>"Imprimir Documento"</strong>.</p>
                </div>
            </div>

            <div class="mt-5 pt-4 text-center border-top">
                <img src="../assets/Img/escudo.jpeg" alt="Escudo" style="width: 30px; opacity: 0.3; filter: grayscale(1);">
                <p class="text-muted mt-2" style="font-size: 0.65rem; font-weight: bold;">SISTEMA MUNIFY v1.0</p>
            </div>
        </div>
    </div>

    <div class="dashboard-container">
        <?php include 'layouts/sidebar.php'; ?>

        <main class="main-content">
            <div class="container-fluid py-4 px-4">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: var(--color-3);">
                            Carta de Defunción
                            <button class="btn btn-sm btn-outline-secondary rounded-circle shadow-sm ms-2" data-bs-toggle="offcanvas" data-bs-target="#ayudaMunify" style="width: 24px; height: 24px; padding: 0; font-size: 0.75rem;">
                                <i class="bi bi-info-lg"></i>
                            </button>
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a></li>
                                <li class="breadcrumb-item active fw-semibold small" style="color: var(--color-3);">Defunción</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <button class="btn-asiento shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDefuncion">
                            <i class="bi bi-person-x-fill me-2"></i> Registrar Defunción
                        </button>
                    </div>
                </div>

                <div class="search-container mb-5 text-center">
                    <h5 class="mb-3 text-muted">Consultar Fallecido</h5>
                    <form id="searchForm" class="input-group input-group-lg shadow-sm" style="border-radius: 8px; overflow: hidden; border: 2px solid var(--color-3);">
                        <span class="input-group-text bg-white border-0 text-muted px-4">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-0 ps-0 shadow-none" placeholder="Ingrese Nombres, Apellidos o DUI del fallecido" autofocus autocomplete="off">
                        <button class="btn border-0 text-white px-4" type="submit" id="btnBuscar" style="background-color: var(--color-3); font-weight: bold;">Buscar</button>
                    </form>
                </div>

                <div id="resultContainer" class="d-none mb-5">
                    <!-- Éxito -->
                    <div id="cardSuccess" class="card result-card result-card-success d-none">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8 d-flex align-items-center gap-4">
                                    <div class="avatar-circle flex-shrink-0">
                                        <i class="bi bi-person-check-fill"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-1" id="resNombre" style="color: var(--color-3);">---</h4>
                                        <div class="text-muted">
                                            <span class="me-3"><i class="bi bi-card-text me-1"></i> <strong id="resDui">---</strong></span>
                                            <span><i class="bi bi-calendar-x me-1"></i> Def: <strong id="resNac">---</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <button id="btnAccionPartida" class="btn-action-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPartida">
                                        <i class="bi bi-printer-fill me-2"></i> Generar Carta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Múltiples -->
                    <div id="cardMultipleResults" class="card result-card d-none">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: var(--color-3);">Coincidencias encontradas</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre Completo</th>
                                            <th>DUI</th>
                                            <th>Fecha Defunción</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyMultipleResults"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Error -->
                    <div id="cardError" class="card result-card result-card-error d-none">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-exclamation-circle text-danger mb-3" style="font-size: 3rem;"></i>
                            <h4 class="fw-bold text-danger mb-2">Registro no encontrado</h4>
                            <p class="text-muted mb-4">No se encontró ninguna acta de defunción con los datos ingresados.</p>
                            <button class="btn btn-danger btn-lg px-4" data-bs-toggle="modal" data-bs-target="#modalDefuncion">
                                <i class="bi bi-person-plus-fill me-2"></i> Registrar Nueva Defunción
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/Js/recepcion_defuncion.js?v=<?php echo time(); ?>"></script>
</body>
</html>
