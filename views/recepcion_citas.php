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
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/recepcion_partida.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">
    <style>
        :root {
            --primary: #1C3166;
            --primary-light: rgba(28, 49, 102, 0.1);
            --secondary: #64748b;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --bg-body: #f8fafc;
        }
        
        body { background-color: var(--bg-body); font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        
        .main-content { padding: 0; }
        
        .filter-container {
            background: white;
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }
        
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        #tablaCitas { margin: 0 !important; }
        #tablaCitas thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        #tablaCitas tbody td { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; }
        
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .bg-pendiente { background-color: #fffbeb; color: #92400E; border: 1px solid #fef3c7; }
        .bg-confirmada { background-color: #ecfdf5; color: #065F46; border: 1px solid #d1fae5; }
        .bg-denegada { background-color: #fef2f2; color: #991B1B; border: 1px solid #fee2e2; }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .btn-accept-batch {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-accept-batch:hover {
            background-color: #15254d;
            box-shadow: 0 4px 12px rgba(28, 49, 102, 0.3);
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate { padding: 1.25rem; }

        @media (max-width: 767.98px) {
            #tablaCitas thead th,
            #tablaCitas tbody td {
                padding: 0.85rem;
            }

            .btn-accept-batch,
            #btnAceptarTodas,
            #btnLimpiarFiltros {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <?php include 'layouts/sidebar.php'; ?>

        <main class="main-content">
            <div class="container-fluid py-2">
                
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: var(--primary);">Recepción de Trámites</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a></li>
                                <li class="breadcrumb-item active fw-semibold small" style="color: var(--primary);">Citas y Solicitudes</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Filtros y Acciones -->
                <div class="filter-container">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label fw-bold small text-muted mb-1">Trámite</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-journal-text text-muted"></i></span>
                                <select id="filterTramite" class="form-select border-start-0 shadow-none">
                                    <option value="">Todos</option>
                                    <option value="Partida de nacimiento">Partida Nac.</option>
                                    <option value="Carta de defunción">Carta Def.</option>
                                    <option value="Carnet de minoridad">Carnet Min.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <label class="form-label fw-bold small text-muted mb-1">Estado</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-activity text-muted"></i></span>
                                <select id="filterEstado" class="form-select border-start-0 shadow-none">
                                    <option value="">Todos</option>
                                    <option value="pendiente" selected>Pendiente</option>
                                    <option value="confirmada">Confirmada</option>
                                    <option value="denegada">Denegada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-4">
                            <label class="form-label d-none d-md-block" style="visibility: hidden;">Acciones</label>
                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                                <button id="btnAceptarSeleccionadas" class="btn-accept-batch shadow-sm">
                                    <i class="bi bi-check-all me-1"></i> Aceptar Seleccionadas
                                </button>
                                <button id="btnAceptarTodas" class="btn btn-sm btn-outline-success fw-bold px-3 border-2" style="border-radius: 10px;">
                                    Aceptar Todas
                                </button>
                                <button id="btnLimpiarFiltros" class="btn btn-sm btn-light border px-3" style="border-radius: 10px;" title="Limpiar Filtros">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </div>
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
                                    <i class="bi bi-x-circle me-2"></i> Denegar
                                </button>
                                <button type="button" class="btn btn-success px-4 fw-bold shadow-sm" onclick="procesarDesdeModal('confirmada')">
                                    <i class="bi bi-check-circle me-2"></i> Aceptar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Citas -->
                <div class="table-container shadow-sm border-0 bg-white p-3" style="border-radius: 12px;">
                    <div class="table-responsive">
                        <table id="tablaCitas" class="table table-hover align-middle w-100" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                    <th>ID</th>
                                    <th>Ciudadano</th>
                                    <th>Trámite</th>
                                    <th>Fecha Solicitada</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th class="text-end">Acciones</th>
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
