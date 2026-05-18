<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet de Minoridad - Munify</title>
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
        .photo-preview {
            width: 120px;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #adb5bd;
            cursor: pointer;
            overflow: hidden;
        }
        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- MODAL MINORIDAD (Para Registrar) -->
    <div class="modal fade" id="modalMinoridad" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-person-badge-fill me-2"></i>Registro de Carnet de Minoridad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formMinoridad">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark small">Fotografía</label>
                                <div class="photo-preview" onclick="document.getElementById('regFoto').click()">
                                    <i class="bi bi-camera fs-1" id="photoIcon"></i>
                                    <img id="photoImg" style="display: none;">
                                </div>
                                <input type="file" id="regFoto" style="display: none;" accept="image/*">
                            </div>
                            <div class="col-md-9">
                                <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-person-fill me-2"></i>Datos del Menor</h6>
                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small">Nombres</label>
                                        <input type="text" id="regNombres" class="form-control border-secondary-subtle shadow-none">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small">Apellidos</label>
                                        <input type="text" id="regApellidos" class="form-control border-secondary-subtle shadow-none">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small">Fecha Nacimiento</label>
                                        <input type="date" id="regFechaNac" class="form-control border-secondary-subtle shadow-none">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small">Sexo</label>
                                        <select id="regSexo" class="form-select border-secondary-subtle shadow-none">
                                            <option>Masculino</option>
                                            <option>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark small">Lugar de Nacimiento</label>
                                        <input type="text" id="regLugarNac" class="form-control border-secondary-subtle shadow-none" placeholder="Ciudad, Departamento">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small">Nombre del Padre</label>
                                        <input type="text" id="regNombrePadre" class="form-control border-secondary-subtle shadow-none">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small">Nombre de la Madre</label>
                                        <input type="text" id="regNombreMadre" class="form-control border-secondary-subtle shadow-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-body-text me-2"></i>Descripción Física</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Color de Piel</label>
                                    <input type="text" id="regColorPiel" class="form-control border-secondary-subtle shadow-none" placeholder="Ej: Trigueño, Blanco">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Color de Ojos</label>
                                    <input type="text" id="regColorOjos" class="form-control border-secondary-subtle shadow-none" placeholder="Ej: Café, Negro">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Color de Cabello</label>
                                    <input type="text" id="regColorCabello" class="form-control border-secondary-subtle shadow-none" placeholder="Ej: Negro, Castaño">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark small">Señas Especiales</label>
                                    <input type="text" id="regSenales" class="form-control border-secondary-subtle shadow-none" placeholder="Cicatrices, lunares, etc.">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-shield-fill-check me-2"></i>Datos del Responsable (Padre/Madre/Tutor)</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">DUI Responsable</label>
                                    <div class="input-group mb-2 shadow-sm">
                                        <input type="text" class="form-control border-0 dui-mask" placeholder="00000000-0" id="duiResponsable" maxlength="10">
                                        <button id="btnBuscarResponsable" class="btn btn-sm text-white fw-bold" type="button" style="background-color: var(--color-3);">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-bold text-dark small">Nombre Completo</label>
                                    <input type="text" id="regNombreResponsable" class="form-control border-secondary-subtle shadow-none">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-geo-alt-fill me-2"></i>Información Adicional</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">Dirección Residencial</label>
                                    <input type="text" id="regDireccion" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">Centro de Estudios</label>
                                    <input type="text" id="regLugarEstudio" class="form-control border-secondary-subtle shadow-none">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0 mt-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardarMinoridad" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-save-fill me-2"></i> Guardar Expediente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL GENERAR CARNET (Para Generar) -->
    <div class="modal fade" id="modalPartida" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-id-card me-2"></i>Emitir Carnet de Minoridad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="avatar-circle-large mx-auto mb-3" style="width: 100px; height: 100px; background: var(--bg-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--color-3);">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h4 class="fw-bold mb-1" id="lblNombre">---</h4>
                    <p class="text-muted mb-4">Se generará el carnet oficial con vigencia de 5 años.</p>
                    
                    <div class="alert alert-info border-0 text-start shadow-sm small">
                        <i class="bi bi-info-circle-fill me-2"></i> Asegúrese de que la fotografía sea reciente y cumpla con los requisitos institucionales.
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnImprimirCarnet" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-printer-fill me-2"></i> Imprimir Carnet
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
                    <p class="small text-dark mb-0"><strong>Consulta:</strong> Ingrese el nombre del menor para verificar si ya posee un expediente en el sistema.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">2</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Registro:</strong> Si es primera vez, use <strong>"Nuevo Registro"</strong> para cargar los datos y la fotografía del menor.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">3</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Responsable:</strong> Asegúrese de vincular al padre o tutor legal mediante su número de DUI vigente.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">4</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Emisión:</strong> Una vez seleccionado el menor, presione <strong>"Imprimir Carnet"</strong> para finalizar el trámite.</p>
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
                            Carnet de Minoridad
                            <button class="btn btn-sm btn-outline-secondary rounded-circle shadow-sm ms-2" data-bs-toggle="offcanvas" data-bs-target="#ayudaMunify" style="width: 24px; height: 24px; padding: 0; font-size: 0.75rem;">
                                <i class="bi bi-info-lg"></i>
                            </button>
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a></li>
                                <li class="breadcrumb-item active fw-semibold small" style="color: var(--color-3);">Minoridad</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <button class="btn-asiento shadow-sm" data-bs-toggle="modal" data-bs-target="#modalMinoridad">
                            <i class="bi bi-person-badge-fill me-2"></i> Nuevo Registro
                        </button>
                    </div>
                </div>

                <div class="search-container mb-5 text-center">
                    <h5 class="mb-3 text-muted">Consultar Menor</h5>
                    <form id="searchForm" class="input-group input-group-lg shadow-sm" style="border-radius: 8px; overflow: hidden; border: 2px solid var(--color-3);">
                        <span class="input-group-text bg-white border-0 text-muted px-4">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-0 ps-0 shadow-none" placeholder="Ingrese Nombres o Apellidos del menor" autofocus autocomplete="off">
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
                                        <i class="bi bi-person-vcard-fill"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-1" id="resNombre" style="color: var(--color-3);">---</h4>
                                        <div class="text-muted small">
                                            <span><i class="bi bi-calendar-event me-1"></i> Nac: <strong id="resNac">---</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <button id="btnAccionPartida" class="btn-action-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPartida">
                                        <i class="bi bi-printer-fill me-2"></i> Generar Carnet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Múltiples -->
                    <div id="cardMultipleResults" class="card result-card d-none">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: var(--color-3);">Resultados de búsqueda</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre Completo</th>
                                            <th>Fecha Nacimiento</th>
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
                            <i class="bi bi-person-fill-slash text-danger mb-3" style="font-size: 3rem;"></i>
                            <h4 class="fw-bold text-danger mb-2">Expediente no encontrado</h4>
                            <p class="text-muted mb-4">No se encontraron registros del menor en el sistema.</p>
                            <button class="btn btn-danger btn-lg px-4" data-bs-toggle="modal" data-bs-target="#modalMinoridad">
                                <i class="bi bi-person-plus-fill me-2"></i> Registrar Nuevo Menor
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
    <script src="../assets/Js/recepcion_minoridad.js?v=<?php echo time(); ?>"></script>
</body>
</html>
