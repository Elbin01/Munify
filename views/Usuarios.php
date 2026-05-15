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
    <link rel="stylesheet" href="../assets/Css/components.css">
    <link rel="stylesheet" href="../assets/Css/sidebar.css">
    <style>
        :root {
            --color-1: #1C3166;
            --color-2: #000000;
            --color-3: #FFFFFF;
            --color-4: #000000;
            --color-5: #FFFFFF;
            --bg-light: #f4f7fb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--bg-light); 
            color: var(--color-4);
            min-height: 100vh;
            display: block !important;
        }

        .dashboard-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            background-color: var(--bg-light);
        }

        /* ════════ MAIN CONTENT ════════ */
        .main-content {
            display: flex;
            flex-direction: column;
            min-height: 100vh;  
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: var(--bg-light);
            padding: 2.5rem;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .header-section h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--color-1);
        }

        .btn-primary {
            background: var(--color-1);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--color-2);
            transform: translateY(-2px);
        }

        /* ════════ CARDS & TABLES ════════ */
        .card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .search-box {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-box input {
            flex: 1;
            padding: 0.8rem 1.2rem;
            border: 1.5px solid #eee;
            border-radius: 10px;
            font-family: inherit;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th {
            text-align: left;
            padding: 1rem;
            background: #F1F5F9;
            color: #475569;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.95rem;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit { background: #E2E8F0; color: #475569; }
        .btn-delete { background: #FEE2E2; color: #EF4444; }
        .btn-search { background: #DBEAFE; color: #2563EB; }

        .btn-icon:hover { transform: scale(1.1); }

        /* ════════ MODAL ════════ */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
            display: none; justify-content: center; align-items: center; z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        }

        .modal-content h2 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 1.5rem;
            color: var(--color-1);
        }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; }
        .form-group input { 
            width: 100%; padding: 0.8rem; 
            border: 1.5px solid #eee; border-radius: 10px;
        }

        /* ════════ SEARCH RESULTS ════════ */
        .result-item {
            padding: 1rem;
            border: 1px solid #eee;
            border-radius: 10px;
            margin-bottom: 0.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .result-info h4 { color: var(--color-1); margin-bottom: 0.2rem; }
        .result-info p { font-size: 0.85rem; color: #666; }

        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-partida { background: #DCFCE7; color: #166534; }
        .badge-defuncion { background: #FEE2E2; color: #991B1B; }
        .badge-minoridad { background: #DBEAFE; color: #1E40AF; }

    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="header-section">
            <div>
                <h1>Gestión de Usuarios</h1>
                <p>Administra los accesos y consulta documentos del sistema.</p>
            </div>
            <button class="btn-primary" onclick="openModal()">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </button>
        </div>

        <div class="card">
            <div class="search-box">
                <input type="text" id="userSearch" placeholder="Filtrar usuarios por nombre o correo..." onkeyup="filterUsers()">
            </div>
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="usersBody">
                    <!-- Dinámico -->
                </tbody>
            </table>
        </div>

        <div class="header-section" style="margin-top: 4rem;">
            <div>
                <h1>Buscador de Documentos</h1>
                <p>Busca cualquier documento registrado por nombre del ciudadano.</p>
            </div>
        </div>

        <div class="card">
            <div class="search-box">
                <input type="text" id="docSearch" placeholder="Ingresa nombres o apellidos del ciudadano...">
                <button class="btn-primary" onclick="searchDocs()">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
            <div id="docsResults">
                <p style="color: #94a3b8; text-align: center; padding: 2rem;">Ingresa un nombre para ver los documentos asociados.</p>
            </div>
        </div>
    </main>
</div>

<!-- MODAL USUARIO -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <h2 id="modalTitle">Nuevo Usuario</h2>
        <form id="userForm">
            <input type="hidden" name="id_usuario" id="userId">
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" id="userName" required>
            </div>
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" id="userEmail" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" id="userPass" placeholder="Dejar en blanco para mantener actual">
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn-primary" style="background: #e2e8f0; color: #475569;" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn-primary" style="flex: 1; justify-content: center;">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- NOTIFICATIONS CONTAINER -->
<div id="notificationContainer" class="notification-container"></div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/Js/notifications.js"></script>
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
                <td><strong>${u.nombre}</strong></td>
                <td>${u.correo}</td>
                <td><span class="badge" style="background: #f1f5f9; color: #475569;">${u.rol || 'Usuario'}</span></td>
                <td class="actions">
                    <button class="btn-icon btn-edit" onclick="editUser(${JSON.stringify(u).replace(/"/g, '&quot;')})" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon btn-search" onclick="searchDocsFromUser('${u.nombre}')" title="Ver Documentos"><i class="fas fa-file-alt"></i></button>
                    <button class="btn-icon btn-delete" onclick="deleteUser(${u.id_usuario})" title="Eliminar"><i class="fas fa-trash"></i></button>
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

    // Búsqueda de Documentos
    async function searchDocs() {
        const termino = document.getElementById('docSearch').value;
        if(!termino) return;

        const resultsDiv = document.getElementById('docsResults');
        resultsDiv.innerHTML = '<p style="text-align:center">Buscando...</p>';

        const resp = await fetch(`../controller/UsuarioController.php?action=buscar_docs&termino=${termino}`);
        const data = await resp.json();

        if(data.length === 0) {
            resultsDiv.innerHTML = '<p style="text-align:center; padding: 2rem; color: #94a3b8;">No se encontraron documentos para este nombre.</p>';
            return;
        }

        resultsDiv.innerHTML = data.map(d => `
            <div class="result-item">
                <div class="result-info">
                    <span class="badge ${getBadgeClass(d.tipo)}">${d.tipo}</span>
                    <h4 style="margin-top: 0.5rem;">${d.nombres} ${d.apellidos}</h4>
                    <p>ID Documento: <strong>${d.id_doc}</strong> | Emitido: ${new Date(d.fecha_emision).toLocaleDateString()}</p>
                </div>
                <button class="btn-primary" onclick="notify('Funcionalidad de impresión en desarrollo', 'info')"><i class="fas fa-print"></i> Ver/Imprimir</button>
            </div>
        `).join('');
    }

    function searchDocsFromUser(name) {
        document.getElementById('docSearch').value = name;
        searchDocs();
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }

    function getBadgeClass(tipo) {
        if(tipo.includes('Nacimiento')) return 'badge-partida';
        if(tipo.includes('Defunción')) return 'badge-defuncion';
        return 'badge-minoridad';
    }

    // Modal Helpers
    function openModal() {
        userForm.reset();
        document.getElementById('userId').value = '';
        document.getElementById('modalTitle').innerText = 'Nuevo Usuario';
        userModal.style.display = 'flex';
    }

    function editUser(u) {
        document.getElementById('userId').value = u.id_usuario;
        document.getElementById('userName').value = u.nombre;
        document.getElementById('userEmail').value = u.correo;
        document.getElementById('userPass').value = '';
        document.getElementById('modalTitle').innerText = 'Editar Usuario';
        userModal.style.display = 'flex';
    }

    function closeModal() {
        userModal.style.display = 'none';
    }

    loadUsers();
</script>

</body>
</html>
