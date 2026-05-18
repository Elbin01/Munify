<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Munify - Buscador de Documentos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <?php include 'layouts/fonts.php'; ?>
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">
    <style>
        :root {
            --primary: #1C3166;
            --primary-light: #f0f4ff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-body: #f8fafc;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Outfit', sans-serif; 
            color: #1e293b;
            margin: 0;
            display: block !important;
        }

        .dashboard-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            background-color: var(--bg-body);
        }
        
        .main-content { 
            padding: 0; 
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .filter-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .badge-role {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
        }
        
        /* Notificaciones */
        .notification-container {
            position: fixed; top: 2rem; right: 2rem;
            z-index: 2000; display: flex; flex-direction: column; gap: 1rem;
        }
        .notification {
            background: white; border-radius: 16px; padding: 1.2rem 1.5rem;
            box-shadow: 0 15px 35px rgba(28, 49, 102, 0.15);
            border-left: 6px solid var(--primary);
            display: flex; align-items: center; gap: 1.2rem;
            min-width: 350px;
            color: #1e293b;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="container-fluid py-4 px-4" style="flex: 1;">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color: var(--primary);">Buscador de Documentos</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a></li>
                            <li class="breadcrumb-item active fw-semibold small" style="color: var(--primary);">Buscador de Documentos</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Buscador de Documentos -->
            <div class="filter-container">
                <p class="text-muted small mb-3">Consulta cualquier documento (Partida de Nacimiento, Carnet de Minoridad, Acta de Defunción) registrado buscando por el nombre del ciudadano.</p>
                <div class="row g-3 align-items-center">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-file-earmark-text text-muted"></i></span>
                            <input type="text" id="docSearch" class="form-control border-start-0 shadow-none" placeholder="Ingresa nombres o apellidos del ciudadano..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" onkeypress="handleEnter(event)">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100 shadow-sm" onclick="searchDocs()" style="background-color: var(--primary); border-radius: 10px;">
                            <i class="bi bi-search me-2"></i> Buscar
                        </button>
                    </div>
                </div>
                <div id="docsResults" class="mt-4">
                    <div class="text-center py-4">
                        <i class="bi bi-info-circle text-muted mb-2 fs-3"></i>
                        <p class="text-muted small">Ingresa un nombre para ver los documentos asociados.</p>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'layouts/footer.php'; ?>
    </main>
</div>

<!-- NOTIFICATIONS CONTAINER -->
<div id="notificationContainer" class="notification-container"></div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/Js/notifications.js?v=<?= time() ?>"></script>
<script>
    function handleEnter(e) {
        if (e.key === 'Enter') {
            searchDocs();
        }
    }

    async function searchDocs() {
        const termino = document.getElementById('docSearch').value.trim();
        if(!termino) return;

        const resultsDiv = document.getElementById('docsResults');
        resultsDiv.innerHTML = '<div class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div><p class="mt-2 text-muted small">Buscando...</p></div>';

        try {
            const resp = await fetch(`../controller/UsuarioController.php?action=buscar_docs&termino=${encodeURIComponent(termino)}`);
            const data = await resp.json();

            if(!data || data.length === 0) {
                resultsDiv.innerHTML = '<div class="text-center py-4"><i class="bi bi-exclamation-circle text-muted fs-3"></i><p class="mt-2 text-muted small">No se encontraron documentos para este nombre.</p></div>';
                return;
            }

            resultsDiv.innerHTML = data.map(d => {
                // Configurar redirección a impresión según el tipo de documento
                let printAction = `notify('Funcionalidad de impresión en desarrollo para ${d.tipo}', 'info')`;
                
                if (d.tipo.includes('Nacimiento')) {
                    printAction = `window.open('../reportes/partida_nacimiento.php?id=${d.id_doc}', '_blank')`;
                } else if (d.tipo.includes('Defunción')) {
                    printAction = `window.open('../reportes/carta_defuncion.php?id=${d.id_doc}', '_blank')`;
                } else if (d.tipo.includes('Minoridad')) {
                    printAction = `window.open('../reportes/carnet_minoridad.php?id=${d.id_doc}', '_blank')`;
                }

                return `
                <div class="result-item p-4 mb-3 border-0 rounded-4 shadow-sm bg-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div class="result-info flex-grow-1" style="min-width: 0;">
                        <span class="badge-role" style="background: var(--primary-light); color: var(--primary); border: none; padding: 0.4em 0.8em;">${d.tipo}</span>
                        <h5 class="mb-1 mt-3 fw-bold text-truncate" style="color: var(--primary);" title="${d.nombres} ${d.apellidos}">${d.nombres} ${d.apellidos}</h5>
                        <div class="text-muted small">
                            <i class="bi bi-hash"></i> ID Doc: ${d.id_doc} &nbsp;|&nbsp; 
                            <i class="bi bi-calendar3"></i> Emitido: ${new Date(d.fecha_emision).toLocaleDateString()}
                        </div>
                    </div>
                    <div class="flex-shrink-0 w-100" style="max-width: 200px;">
                        <button class="btn btn-primary shadow-sm w-100 d-flex align-items-center justify-content-center py-2" style="background-color: var(--primary); border-radius: 10px; font-weight: 500;" onclick="${printAction}">
                            <i class="bi bi-file-earmark-pdf-fill me-2 fs-5"></i> Abrir
                        </button>
                    </div>
                </div>
            `}).join('');
        } catch (error) {
            resultsDiv.innerHTML = '<div class="text-center py-4"><i class="bi bi-x-circle text-danger fs-3"></i><p class="mt-2 text-danger small">Error al conectar con el servidor.</p></div>';
        }
    }

    // Auto-search if query param 'q' exists
    window.onload = function() {
        if(document.getElementById('docSearch').value.trim() !== '') {
            searchDocs();
        }
    };
</script>
</body>
</html>
