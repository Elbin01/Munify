<?php
$current_page = basename($_SERVER['PHP_SELF']);
$nombre_usuario = $_SESSION['usuario'] ?? 'Usuario';
$inicial_usuario = strtoupper(substr($nombre_usuario, 0, 1));
?>
<div class="d-flex flex-column flex-shrink-0 p-3 custom-sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-between mb-1 px-1">
        <a href="../views/dashboard.php" class="d-flex align-items-center text-white text-decoration-none logo-container">
            <img src="../assets/Img/logo_munify/logo_negativo.png" alt="Munify Logo" class="sidebar-logo" style="width: 140px; height: auto;">
        </a>
        <button id="btnToggleSidebar" class="btn btn-sm text-white border-0 p-0 fs-4 ms-2">
            <i class="bi bi-list"></i>
        </button>
    </div>
    <hr class="sidebar-divider">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-house-door me-2"></i>
                <span class="nav-text">Inicio</span>
            </a>
        </li>
        <li>
            <a href="recepcion_citas.php" class="nav-link <?= $current_page == 'recepcion_citas.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-calendar-check me-2"></i>
                <span class="nav-text">Citas</span>
            </a>
        </li>
        <li>
            <a href="recepcion_minoridad.php" class="nav-link <?= $current_page == 'recepcion_minoridad.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-person-badge me-2"></i>
                <span class="nav-text">Carnet Minoridad</span>
            </a>
        </li>
        <li>
            <a href="recepcion_defuncion.php" class="nav-link <?= $current_page == 'recepcion_defuncion.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-file-earmark-x me-2"></i>
                <span class="nav-text">Carta de Defunción</span>
            </a>
        </li>
        <li>
            <a href="recepcion_partida.php" class="nav-link <?= $current_page == 'recepcion_partida.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-file-earmark-person me-2"></i>
                <span class="nav-text">Partida de Nacimiento</span>
            </a>
        </li>
        <li>
            <a href="estadisticas.php" class="nav-link <?= $current_page == 'estadisticas.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-bar-chart-line me-2"></i>
                <span class="nav-text">Estadísticas</span>
            </a>
        </li>
        <li>
            <a href="Usuarios.php" class="nav-link <?= $current_page == 'Usuarios.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-people me-2"></i>
                <span class="nav-text">Usuarios</span>
            </a>
        </li>
    </ul>
    <hr class="sidebar-divider">
    <div class="dropdown mt-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-4 me-2 user-icon"></i>
            <strong class="nav-text"><?= $nombre_usuario ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Configuración</a></li>
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="login.php">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('btnToggleSidebar');
    
    // Cargar estado guardado
    if (localStorage.getItem('sidebar-collapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
    });
});
</script>