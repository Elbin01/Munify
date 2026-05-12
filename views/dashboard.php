<?php session_start(); ?>
<?php
require_once __DIR__ . '/../models/CiudadanoModel.php';
require_once __DIR__ . '/../models/PartidaModel.php';

$ciudadanoModel = new CiudadanoModel();
$partidaModel = new PartidaModel();

$totalCiudadanos = $ciudadanoModel->contarCiudadanos();
$totalPartidas = $partidaModel->contarPartidas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Munify</title>
    <!-- Fonts -->
    <?php include 'layouts/fonts.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css">
    <link rel="stylesheet" href="../assets/Css/sidebar.css">
    <link rel="stylesheet" href="../assets/Css/footer.css">
    <style>
        body {
            width: 100%;
            overflow-x: hidden;
            display: block !important;
        }
        .dashboard-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            background-color: var(--bg-light);
        }
        .main-content {
            display: flex;
            flex-direction: column;
            min-height: 100vh;  
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: var(--bg-light);
        }

        .main-content > .container-fluid {
    flex: 1;
}
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card .card-body {
            padding: 1.5rem;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .bg-primary-soft { background-color: rgba(28, 49, 102, 0.1); color: var(--color-3); }
        .bg-success-soft { background-color: rgba(64, 255, 220, 0.1); color: #00A9D4; }
        .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container-fluid py-4 px-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold" style="color: var(--color-3);">Panel de Control</h2>
                    <div class="user-info">
                        <span class="text-muted">Bienvenido, <strong>Administrador</strong></span>
                    </div>
                </div>

                <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-primary-soft me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Ciudadanos Registrados</h6>
                                <h3 class="mb-0 fw-bold"><?= number_format($totalCiudadanos) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-primary-soft me-3">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Partidas Emitidas</h6>
                                <h3 class="mb-0 fw-bold"><?= number_format($totalPartidas) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-primary-soft me-3">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Trámites Pendientes</h6>
                                <h3 class="mb-0 fw-bold">18</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row g-4">
                <!-- Recent Activity Section (Left Column) -->
                <div class="col-12 col-lg-8">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4" style="color: var(--color-3);">Actividad Reciente</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Trámite</th>
                                            <th>Solicitante</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $recientes = $partidaModel->obtenerRecientesHoy();
                                        if (!empty($recientes)): 
                                            foreach ($recientes as $r):
                                        ?>
                                        <tr>
                                            <td>Partida Nacimiento</td>
                                            <td><?= htmlspecialchars($r['nombres'] . ' ' . $r['apellidos']) ?></td>
                                            <td>Hoy</td>
                                            <td><span class="badge bg-success">Emitido</span></td>
                                            <td><a href="../reportes/partida_nacimiento.php?id=<?= $r['id_partida'] ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
                                        </tr>
                                        <?php 
                                            endforeach;
                                        else:
                                        ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No hay actividad reciente registrada hoy.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Citas Solicitadas Section (Right Column) -->
                <div class="col-12 col-lg-4">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4" style="color: var(--color-3);">Citas Solicitadas</h5>
                            
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="bg-primary-soft p-2 rounded me-3 text-center" style="min-width: 55px;">
                                    <div class="fw-bold" style="font-size: 1.1rem; line-height: 1;">12</div>
                                    <small style="font-size: 0.75rem; opacity: 0.8;">MAY</small>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Carnet de Minoridad</h6>
                                    <p class="mb-0 text-muted small">Luis Mendoza • 09:00 AM</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="bg-primary-soft p-2 rounded me-3 text-center" style="min-width: 55px;">
                                    <div class="fw-bold" style="font-size: 1.1rem; line-height: 1;">12</div>
                                    <small style="font-size: 0.75rem; opacity: 0.8;">MAY</small>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Carta de Defunción</h6>
                                    <p class="mb-0 text-muted small">Ana Suárez • 10:30 AM</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start">
                                <div class="bg-primary-soft p-2 rounded me-3 text-center" style="min-width: 55px;">
                                    <div class="fw-bold" style="font-size: 1.1rem; line-height: 1;">13</div>
                                    <small style="font-size: 0.75rem; opacity: 0.8;">MAY</small>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Partida de Nacimiento</h6>
                                    <p class="mb-0 text-muted small">Pedro Gómez • 08:15 AM</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <a href="SolicitudCitas.php" class="btn btn-sm btn-outline-primary w-100" style="color: var(--color-3); border-color: var(--color-3);">Ver todas las citas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
