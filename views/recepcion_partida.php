<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida de Nacimiento - Munify</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css">
    <link rel="stylesheet" href="../assets/Css/sidebar.css">
    <link rel="stylesheet" href="../assets/Css/partida.css">
    <style>
        body { width: 100%; overflow-x: hidden; display: block !important; }
        .dashboard-container { display: flex; width: 100%; min-height: 100vh; background-color: var(--bg-light); }
        .main-content { flex: 1; overflow-y: auto; overflow-x: hidden; background-color: var(--bg-light); }
    </style>
</head>
<body>

    <!-- MODAL CIUDADANO (Para Registrar) -->
    <div class="modal fade" id="modalCiudadano" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-person-plus-fill me-2"></i>Registro de Nuevo Ciudadano</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formCiudadano">
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-card-text me-2"></i>Datos Principales</h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">Nombres</label>
                                    <input type="text" id="regNombres" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small">Apellidos</label>
                                    <input type="text" id="regApellidos" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Sexo</label>
                                    <select id="regSexo" class="form-select border-secondary-subtle shadow-none"><option>Masculino</option><option>Femenino</option></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Fecha Nacimiento</label>
                                    <input type="date" id="regFechaNac" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Hora Nacimiento</label>
                                    <input type="time" id="regHoraNac" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">DUI (Si aplica)</label>
                                    <input type="text" id="modalRegDui" class="form-control border-secondary-subtle shadow-none" placeholder="00000000-0">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Lugar Nacimiento</label>
                                    <input type="text" id="regLugarNac" class="form-control border-secondary-subtle shadow-none">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark small">Hospital / Clínica</label>
                                    <input type="text" id="regHospital" class="form-control border-secondary-subtle shadow-none">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h6 class="border-bottom pb-2 text-muted fw-bold"><i class="bi bi-people-fill me-2"></i>Datos de los Padres</h6>
                            <div class="row g-3 mt-1">
                                <!-- Padre -->
                                <div class="col-md-6">
                                    <div class="card bg-light border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label class="fw-bold form-label text-dark small"><i class="bi bi-person me-1"></i> Padre</label>
                                            <div class="input-group mb-2 shadow-sm">
                                                <input type="text" class="form-control form-control-sm border-0" placeholder="Buscar DUI..." id="duiPadre">
                                                <button class="btn btn-sm text-white fw-bold" type="button" style="background-color: var(--color-3);">Buscar</button>
                                            </div>
                                            <input type="text" id="regNombrePadre" class="form-control form-control-sm border-secondary-subtle shadow-none" placeholder="Nombre completo">
                                        </div>
                                    </div>
                                </div>
                                <!-- Madre -->
                                <div class="col-md-6">
                                    <div class="card bg-light border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label class="fw-bold form-label text-dark small"><i class="bi bi-person me-1"></i> Madre</label>
                                            <div class="input-group mb-2 shadow-sm">
                                                <input type="text" class="form-control form-control-sm border-0" placeholder="Buscar DUI..." id="duiMadre">
                                                <button class="btn btn-sm text-white fw-bold" type="button" style="background-color: var(--color-3);">Buscar</button>
                                            </div>
                                            <input type="text" id="regNombreMadre" class="form-control form-control-sm border-secondary-subtle shadow-none" placeholder="Nombre completo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0 mt-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardarCiudadano" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-save-fill me-2"></i> Guardar Ciudadano
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARTIDA (Para Generar) -->
    <div class="modal fade" id="modalPartida" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--color-3); color: white;">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-person me-2"></i>Generar Partida de Nacimiento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Lectura de Datos Precargados -->
                    <div class="card bg-light border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h6 class="text-muted mb-4 border-bottom pb-2"><i class="bi bi-info-circle me-1"></i> Datos del Ciudadano a Imprimir</h6>
                            <div class="row g-3 text-dark">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small mb-1">Nombre Completo:</span>
                                    <strong id="lblNombre" class="fs-6">---</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small mb-1">Fecha de Nacimiento:</span>
                                    <strong id="lblFechaNac" class="fs-6">---</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small mb-1">Nombre del Padre:</span>
                                    <strong id="lblPadre" class="fs-6">---</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block small mb-1">Nombre de la Madre:</span>
                                    <strong id="lblMadre" class="fs-6">---</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Campos a llenar por recepcionista -->
                    <form id="formGenerarPartida" class="row g-3">
                        <div class="col-12 mb-1"><h6 class="border-bottom pb-2 text-muted"><i class="bi bi-folder2-open me-1"></i> Información del Folio</h6></div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Número de Partida</label>
                            <input type="text" id="partidaNum" class="form-control form-control-lg border-secondary-subtle shadow-none" placeholder="Ej: 1542">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Libro (Tomo)</label>
                            <input type="text" id="partidaLibro" class="form-control form-control-lg border-secondary-subtle shadow-none" placeholder="Ej: 12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Folio</label>
                            <input type="text" id="partidaFolio" class="form-control form-control-lg border-secondary-subtle shadow-none" placeholder="Ej: 45">
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnImprimirPartida" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="bi bi-printer-fill me-2"></i> Imprimir Documento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-container">
        <?php include 'layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container-fluid py-4 px-4">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h2 class="fw-bold mb-0" style="color: var(--color-3);">Trámite: Partida de Nacimiento</h2>
                        <p class="text-muted mb-0">Recepción y emisión de documentos</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCiudadano" style="border-color: var(--color-3); color: var(--color-3);">
                            <i class="bi bi-person-plus-fill me-2"></i> Nuevo Ciudadano
                        </button>
                    </div>
                </div>

                <!-- Buscador Central -->
                <div class="search-container mb-5 text-center">
                    <h5 class="mb-3 text-muted">Consultar Ciudadano</h5>
                    <form id="searchForm" class="input-group input-group-lg shadow-sm" style="border-radius: 8px; overflow: hidden; border: 2px solid var(--color-3);">
                        <span class="input-group-text bg-white border-0 text-muted px-4">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-0 ps-0 shadow-none" placeholder="Ingrese Nombres, Apellidos o DUI" autofocus autocomplete="off" style="outline: none; box-shadow: none;">
                        <button class="btn border-0 text-white px-4" type="submit" id="btnBuscar" style="background-color: var(--color-3); font-weight: bold;">Buscar</button>
                    </form>
                </div>

                <!-- Contenedor de Resultados (Oculto por defecto) -->
                <div id="resultContainer" class="d-none mb-5">
                    
                    <!-- Tarjeta: Éxito (Ciudadano Encontrado) -->
                    <div id="cardSuccess" class="card result-card result-card-success d-none">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar-circle">
                                        <i class="bi bi-person-check-fill"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-1" id="resNombre" style="color: var(--color-3);">---</h4>
                                        <div class="text-muted">
                                            <span class="me-3"><i class="bi bi-card-text me-1"></i> <strong id="resDui">---</strong></span>
                                            <span><i class="bi bi-calendar-date me-1"></i> Nac: <strong id="resNac">---</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button id="btnAccionPartida" class="btn-action-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPartida">
                                        <i class="bi bi-printer-fill me-2"></i> Generar Partida
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta: Múltiples Resultados -->
                    <div id="cardMultipleResults" class="card result-card d-none">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: var(--color-3);">Se encontraron múltiples coincidencias</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre Completo</th>
                                            <th>DUI</th>
                                            <th>Fecha Nacimiento</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyMultipleResults">
                                        <!-- Filas dinámicas aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta: Error (Ciudadano No Encontrado) -->
                    <div id="cardError" class="card result-card result-card-error d-none">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="bi bi-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="fw-bold text-danger mb-2">Ciudadano no encontrado</h4>
                            <p class="text-muted mb-4">No existen registros en el sistema para el documento ingresado.</p>
                            <button class="btn btn-danger btn-lg shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalCiudadano">
                                <i class="bi bi-person-plus-fill me-2"></i> Registrar Nuevo Ciudadano
                            </button>
                        </div>
                    </div>

                </div>



            </div>
        </main>
    </div>


    <!-- Bootstrap JS y jQuery (Simulador) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="../assets/Js/recepcion_partida.js"></script>
</body>
</html>
