<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción de Testamentos - Munify</title>
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

    <!-- MODAL TESTAMENTO (Para Registrar la Recepción) -->
    <div class="modal fade" id="modalTestamento" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-medical-fill me-2"></i>Ingreso de Acto Testamentario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formTestamento">
                        
                        <!-- SECCIÓN 1: DATOS DEL TESTADOR -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-person-fill me-2"></i>Datos del Testador</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark small">Nombre Completo</label>
                                    <input type="text" id="regNombreTestador" class="form-control border-secondary-subtle shadow-none" placeholder="Tal como aparece en el DUI">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">DUI</label>
                                    <input type="text" id="regDui" class="form-control border-secondary-subtle shadow-none dui-mask" placeholder="00000000-0" maxlength="10">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Edad (Años)</label>
                                    <input type="number" id="regEdad" class="form-control border-secondary-subtle shadow-none" min="18">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Estado Civil</label>
                                    <select id="regEstadoCivil" class="form-select border-secondary-subtle shadow-none">
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option value="Soltero/a">Soltero/a</option>
                                        <option value="Casado/a">Casado/a</option>
                                        <option value="Divorciado/a">Divorciado/a</option>
                                        <option value="Viudo/a">Viudo/a</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark small">Domicilio Habitual</label>
                                    <input type="text" id="regDomicilio" class="form-control border-secondary-subtle shadow-none" placeholder="Dirección completa del testador">
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 2: HEREDEROS Y BENEFICIARIOS -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-people-fill me-2"></i>Herederos y Beneficiarios</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-7">
                                    <label class="form-label fw-bold text-dark small">Nombre del Heredero Principal</label>
                                    <input type="text" id="regHeredero" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold text-dark small">Parentesco / Relación</label>
                                    <input type="text" id="regParentesco" class="form-control border-secondary-subtle shadow-none" placeholder="Ej. Hijo, Cónyuge, Hermano...">
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 3: BIENES Y VOLUNTAD -->
                        <div>
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-journal-text me-2"></i>Declaraciones del Acto</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark small">Descripción de Bienes Declarados</label>
                                    <textarea id="regBienes" class="form-control border-secondary-subtle shadow-none" rows="2" placeholder="Detalle de inmuebles, cuentas, vehículos o legados..."></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark small">Voluntad Testamentaria / Cláusulas Especiales</label>
                                    <textarea id="regDeclaracion" class="form-control border-secondary-subtle shadow-none" rows="3" placeholder="Cláusula de última voluntad del otorgante..."></textarea>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer bg-light border-0 mt-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardarTestamento" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-save-fill me-2"></i> Guardar en Sistema
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL VISTA PREVIA / PASAR A IMPRESIÓN -->
    <div class="modal fade" id="modalPartida" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-pdf-fill me-2"></i>Generar Ficha de Testamento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="card bg-light border-0 shadow-sm mb-4">
                        <div class="card-body p-3">
                            <h6 class="text-muted mb-3 border-bottom pb-1"><i class="bi bi-info-circle me-1"></i> Resumen del Testador</h6>
                            <div class="row g-2 text-dark small">
                                <div class="col-12">
                                    <span class="text-muted">Nombre:</span> <strong id="lblNombre">---</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">DUI:</span> <strong id="lblDui">---</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">Heredero:</span> <strong id="lblHeredero">---</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small">Al presionar el botón de impresión, el sistema cargará los datos capturados directamente en el formato de papel legal del Estado Familiar.</p>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnImprimirTestamento" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-printer-fill me-2"></i> Cargar Formato de Impresión
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL DE AYUDA (OFFCANVAS) -->
    <div class="offcanvas offcanvas-end help-panel" tabindex="-1" id="ayudaMunify" aria-labelledby="ayudaLabel">
        <div class="offcanvas-header help-header shadow-sm">
            <h5 class="offcanvas-title" id="ayudaLabel">
                <i class="bi bi-patch-question-fill me-2"></i> Guía - Testamentos
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-4">
            <div class="help-section-title">Flujo de Recepción</div>
            
            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">1</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Consulta:</strong> Digite el DUI o el nombre del ciudadano para verificar si ya posee un testamento cargado en la base del Estado Familiar.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">2</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Filiación y Bienes:</strong> Ingrese minuciosamente los datos de domicilio, herederos, la descripción de patrimonio y las cláusulas de última voluntad.</p>
                </div>
            </div>

            <div class="help-card d-flex align-items-start shadow-sm">
                <div class="help-step-badge me-3">3</div>
                <div>
                    <p class="small text-dark mb-0"><strong>Impresión del Libro:</strong> Una vez guardado el registro, haga clic en "Generar Ficha" para transferir la información a la vista de impresión en hoja timbrada.</p>
                </div>
            </div>

            <div class="mt-5 pt-4 text-center border-top">
                <img src="../assets/Img/escudo.jpeg" alt="Escudo" style="width: 30px; opacity: 0.3; filter: grayscale(1);">
                <p class="text-muted mt-2" style="font-size: 0.65rem; font-weight: bold;">SISTEMA MUNIFY v1.0</p>
            </div>
        </div>
    </div>

    <!-- ESTRUCTURA PRINCIPAL DEL DASHBOARD -->
    <div class="dashboard-container">
        <?php include 'layouts/sidebar.php'; ?>

        <main class="main-content">
            <div class="container-fluid py-4 px-4">
                
                <!-- Encabezado de Página -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: var(--color-3);">
                            Testamentos
                            <button class="btn btn-sm btn-outline-secondary rounded-circle shadow-sm ms-2" data-bs-toggle="offcanvas" data-bs-target="#ayudaMunify" style="width: 24px; height: 24px; padding: 0; font-size: 0.75rem;">
                                <i class="bi bi-info-lg"></i>
                            </button>
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a></li>
                                <li class="breadcrumb-item active fw-semibold small" style="color: var(--color-3);"> Testamentos</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <button class="btn-asiento shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTestamento">
                            <i class="bi bi-file-earmark-plus-fill me-2"></i> Registrar Testamento
                        </button>
                    </div>
                </div>

                <!-- Barra de Búsqueda Centrada -->
                <div class="search-container mb-5 text-center">
                    <h5 class="mb-3 text-muted">Consultar Registro del Estado Familiar</h5>
                    <form id="searchForm" class="input-group input-group-lg shadow-sm" style="border-radius: 8px; overflow: hidden; border: 2px solid var(--color-3);">
                        <span class="input-group-text bg-white border-0 text-muted px-4">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-0 ps-0 shadow-none" placeholder="Ingrese el DUI o Nombre Completo del Testador" autofocus autocomplete="off">
                        <button class="btn border-0 text-white px-4" type="submit" id="btnBuscar" style="background-color: var(--color-3); font-weight: bold;">Buscar</button>
                    </form>
                </div>

                <!-- Contenedor de Respuestas AJAX -->
                <div id="resultContainer" class="d-none mb-5">
                    
                    <!-- Tarjeta Éxito (Registro Existente) -->
                    <div id="cardSuccess" class="card result-card result-card-success d-none">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8 d-flex align-items-center gap-4">
                                    <div class="avatar-circle flex-shrink-0">
                                        <i class="bi bi-file-earmark-check-fill"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-1" id="resNombre" style="color: var(--color-3);">---</h4>
                                        <div class="text-muted">
                                            <span class="me-3"><i class="bi bi-card-text me-1"></i> <strong id="resDui">---</strong></span>
                                            <span><i class="bi bi-person-hearts me-1"></i> Beneficiario: <strong id="resHeredero">---</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <button id="btnGenerarFicha"
                                            class="btn-action-primary btn-lg shadow-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalTestamento">
                                                     <i class="bi bi-file-earmark-pdf me-2"></i>
                                                         Generar Ficha
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Múltiples Resultados -->
                    <div id="cardMultipleResults" class="card result-card d-none">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: var(--color-3);">Coincidencias de Testadores</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre Completo</th>
                                            <th>DUI</th>
                                            <th>Heredero Principal</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyMultipleResults"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta Error (No encontrado) -->
                    <div id="cardError" class="card result-card result-card-error d-none">
                        <div class="card-body p-4 text-center">
                            <i class="bi bi-folder-plus text-danger mb-3" style="font-size: 3rem;"></i>
                            <h4 class="fw-bold text-danger mb-2">Sin registro testamentario</h4>
                            <p class="text-muted mb-4">No se encuentra ningún testamento asociado a los criterios ingresados.</p>
                            <button class="btn btn-danger btn-lg px-4" data-bs-toggle="modal" data-bs-target="#modalTestamento">
                                <i class="bi bi-file-earmark-plus-fill me-2"></i> Aperturar Nuevo Registro
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
    <script src="../assets/Js/recepcion_testamento.js?v=<?php echo time(); ?>"></script>
</body>
</html>