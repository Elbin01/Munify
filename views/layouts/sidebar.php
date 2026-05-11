<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="d-flex flex-column flex-shrink-0 p-3 custom-sidebar">
    <a href="principal.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none justify-content-center w-100">
        <img src="../assets/Img/logo_munify/logo_negativo.png" alt="Munify Logo" style="width: 180px; height: auto;">
    </a>
    <hr class="sidebar-divider">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-house-door me-2"></i>
                Inicio
            </a>
        </li>
        <li>
            <a href="SolicitudCitas.php" class="nav-link <?= $current_page == 'SolicitudCitas.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-calendar-check me-2"></i>
                Citas
            </a>
        </li>
        <li>
            <a href="Carnet minoridad.php" class="nav-link <?= $current_page == 'Carnet minoridad.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-person-badge me-2"></i>
                Carnet Minoridad
            </a>
        </li>
        <li>
            <a href="CartaDefuncion.php" class="nav-link <?= $current_page == 'CartaDefuncion.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-file-earmark-x me-2"></i>
                Carta de Defunción
            </a>
        </li>
        <li>
            <a href="recepcion_partida.php" class="nav-link <?= $current_page == 'recepcion_partida.php' ? 'active' : 'text-white' ?>">
                <i class="bi bi-file-earmark-person me-2"></i>
                Partida de Nacimiento
            </a>
        </li>
    </ul>
    <hr class="sidebar-divider">
    <div class="dropdown mt-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="user-avatar-placeholder me-2 d-flex align-items-center justify-content-center rounded-circle bg-white text-dark" style="width: 32px; height: 32px; font-weight: bold;">U</div>
            <strong>Usuario</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Configuración</a></li>
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="login.php">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>
