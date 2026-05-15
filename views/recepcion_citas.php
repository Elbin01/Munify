<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción de Citas - Munify</title>
    <!-- Fonts -->
    <?php include 'layouts/fonts.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css">
    <link rel="stylesheet" href="../assets/Css/sidebar.css">
    <link rel="stylesheet" href="../assets/Css/recepcion_partida.css">
    <link rel="stylesheet" href="../assets/Css/footer.css">
    <style>
        .filter-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
        }
        .status-badge {
            padding: 0.5em 1em;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .bg-pendiente { background-color: #FEF3C7; color: #92400E; }
        .bg-confirmada { background-color: #D1FAE5; color: #065F46; }
        .bg-denegada { background-color: #FEE2E2; color: #991B1B; }

        #tablaCitas thead th {
            background-color: #f8f9fa;
            color: var(--color-3);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eef2f7;
            padding: 1.2rem 1rem;
        }

        #tablaCitas tbody td {
            padding: 1rem;
            color: #475569;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <?php include 'layouts/sidebar.php'; ?>

        <main class="main-content">
            <div class="container-fluid py-4 px-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-0" style="color: var(--color-3);">Control de Citas y Solicitudes</h2>
                        <p class="text-muted mb-0">Gestión de trámites ciudadanos</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="filter-container">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Filtrar por Trámite</label>
                            <select id="filterTramite" class="form-select border-secondary-subtle">
                                <option value="">Todos los trámites</option>
                                <option value="Partida de nacimiento">Partida de nacimiento</option>
                                <option value="Carta de defunción">Carta de defunción</option>
                                <option value="Carnet de menoridad">Carnet de menoridad</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Filtrar por Estado</label>
                            <select id="filterEstado" class="form-select border-secondary-subtle">
                                <option value="">Todos los estados</option>
                                <option value="pendiente" selected>Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="denegada">Denegada</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button id="btnLimpiarFiltros" class="btn btn-outline-secondary w-100 fw-bold">
                                <i class="bi bi-eraser-fill me-2"></i> Limpiar Filtros
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal de Detalles de Cita -->
                <div class="modal fade" id="modalDetalleCita" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-primary text-white" style="background-color: var(--color-3) !important;">
                                <h5 class="modal-title"><i class="bi bi-info-circle-fill me-2"></i>Detalles de la Solicitud</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div id="detalleContenido">
                                    <!-- Cargando... -->
                                    <div class="text-center p-5">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="mt-2 text-muted">Cargando información...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light border-0">
                                <input type="hidden" id="citaIdActual">
                                <button type="button" class="btn btn-danger px-4 fw-bold" onclick="procesarDesdeModal('denegada')">
                                    <i class="bi bi-x-circle me-2"></i> Denegar Solicitud
                                </button>
                                <button type="button" class="btn btn-success px-4 fw-bold shadow-sm" onclick="procesarDesdeModal('confirmada')">
                                    <i class="bi bi-check-circle me-2"></i> Aceptar y Notificar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Citas -->
                <div class="table-container shadow-sm border-0 bg-white p-4" style="border-radius: 15px;">
                    <div class="table-responsive">
                        <table id="tablaCitas" class="table table-hover align-middle w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Ciudadano</th>
                                    <th>Trámite</th>
                                    <th>Fecha Solicitada</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los datos se cargarán por AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="../assets/Js/recepcion_citas.js?v=<?php echo time(); ?>"></script>
</body>
</html>
