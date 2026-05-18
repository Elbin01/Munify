<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Munify - Gestión de Usuarios</title>
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
        .notification.error { border-left-color: var(--danger); }
        .notification.success { border-left-color: var(--success); }

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
        
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }
        
        .table { margin-bottom: 0; }
        .table thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.025em;
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #334155;
            font-size: 0.875rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            border: none;
        }

        .btn-edit-user { background-color: #f1f5f9; color: #475569; }
        .btn-delete-user { background-color: #fee2e2; color: #ef4444; }
        .btn-view-docs { background-color: #dbeafe; color: #2563eb; }
        
        .btn-action:hover { transform: translateY(-2px); filter: brightness(0.95); }

        .badge-role {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }
        .modal-header {
            background-color: var(--primary);
            color: white;
            padding: 1.5rem;
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
                    <h2 class="fw-bold mb-1" style="color: var(--primary);">Gestión de Usuarios</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted small">Dashboard</a></li>
                            <li class="breadcrumb-item active fw-semibold small" style="color: var(--primary);">Usuarios</li>
                        </ol>
                    </nav>
                </div>
                <button class="btn btn-primary shadow-sm px-4" onclick="openModal()" style="background-color: var(--primary); border-radius: 10px;">
                    <i class="bi bi-person-plus-fill me-2"></i> Nuevo Usuario
                </button>
            </div>

            <!-- Filtros -->
            <div class="filter-container">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="userSearch" class="form-control border-start-0 shadow-none" placeholder="Filtrar por nombre, correo o rol..." onkeyup="filterUsers()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="usersTable">
                        <thead>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Correo Electrónico</th>
                                <th>Rol / Acceso</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="usersBody">
                            <!-- Dinámico -->
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <?php include 'layouts/footer.php'; ?>
    </main>
</div>

<!-- MODAL USUARIO -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header" style="background-color: var(--primary); color: white;">
                <h5 class="modal-title fw-bold" id="modalTitle"><i class="bi bi-person-plus-fill me-2"></i>Nuevo Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="userForm">
                    <input type="hidden" name="id_usuario" id="userId">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nombre Completo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="nombre" id="userName" class="form-control shadow-none" placeholder="Ej: Juan Pérez" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="correo" id="userEmail" class="form-control shadow-none" placeholder="correo@ejemplo.com" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" id="userPass" class="form-control shadow-none" placeholder="Mínimo 8 caracteres">
                        </div>
                        <div class="form-text mt-2 small text-muted">Dejar en blanco para mantener la contraseña actual.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Rol del Sistema</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-shield-lock text-muted"></i></span>
                            <select name="id_rol" id="userRole" class="form-select shadow-none">
                                <option value="1">Administrador</option>
                                <option value="2">Ciudadano</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: var(--primary);">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- NOTIFICATIONS CONTAINER -->
<div id="notificationContainer" class="notification-container"></div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/Js/notifications.js?v=<?= time() ?>"></script>
<script>
    const usersBody = document.getElementById('usersBody');
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');

    // Cargar Usuarios
    async function loadUsers() {
        const resp = await fetch('../controller/UsuarioController.php?action=listar');
        const data = await resp.json();
        renderUsers(data);
    }

    function renderUsers(users) {
        usersBody.innerHTML = users.map(u => `
            <tr>
                <td><div class="fw-bold">${u.nombre}</div></td>
                <td><span class="text-muted small">${u.correo}</span></td>
                <td><span class="badge-role" style="background-color: var(--primary-light); color: var(--primary);">${u.rol || 'USUARIO'}</span></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn-action btn-edit-user" onclick="editUser(${JSON.stringify(u).replace(/"/g, '&quot;')})" title="Editar"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn-action btn-view-docs" onclick="searchDocsFromUser('${u.nombre}')" title="Ver Documentos"><i class="bi bi-file-earmark-person"></i></button>
                        <button class="btn-action btn-delete-user" onclick="deleteUser(${u.id_usuario})" title="Eliminar"><i class="bi bi-trash3"></i></button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function filterUsers() {
        const query = document.getElementById('userSearch').value.toLowerCase();
        const rows = usersBody.getElementsByTagName('tr');
        Array.from(rows).forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // CRUD Operaciones
    userForm.onsubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData(userForm);
        const resp = await fetch('../controller/UsuarioController.php?action=guardar', {
            method: 'POST',
            body: formData
        });
        const res = await resp.json();
        if(res.success) {
            closeModal();
            loadUsers();
            notify(res.message);
        }
    };

    async function deleteUser(id) {
        if(confirm('¿Estás seguro de eliminar este usuario?')) {
            const resp = await fetch(`../controller/UsuarioController.php?action=eliminar&id=${id}`);
            const res = await resp.json();
            if(res.success) loadUsers();
        }
    }

    function searchDocsFromUser(name) {
        window.location.href = 'buscador_documentos.php?q=' + encodeURIComponent(name);
    }

    // Modal Helpers
    let bsUserModal = new bootstrap.Modal(document.getElementById('userModal'));

    function openModal() {
        userForm.reset();
        document.getElementById('userId').value = '';
        document.getElementById('userRole').value = '2'; // default ciudadano
        document.getElementById('modalTitle').innerText = 'Nuevo Usuario';
        bsUserModal.show();
    }

    function editUser(u) {
        document.getElementById('userId').value = u.id_usuario;
        document.getElementById('userName').value = u.nombre;
        document.getElementById('userEmail').value = u.correo;
        document.getElementById('userPass').value = '';
        document.getElementById('userRole').value = u.id_rol;
        document.getElementById('modalTitle').innerText = 'Editar Usuario';
        bsUserModal.show();
    }

    function closeModal() {
        bsUserModal.hide();
    }

    loadUsers();
</script>

</body>
</html>
