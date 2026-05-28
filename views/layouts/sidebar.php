<?php
$current_page = basename($_SERVER['PHP_SELF']);

$nombre_usuario = $_SESSION['usuario'] ?? 'Usuario';

$servicios_pages = [
    'recepcion_minoridad.php',
    'recepcion_defuncion.php',
    'recepcion_partida.php',
    'recepcion_testamento.php',
    'solicitud_matrimonio_civil.php'

];

$servicios_active = in_array($current_page, $servicios_pages);

function isActive($page, $current_page)
{
    return $current_page === $page
        ? 'active'
        : 'text-white';
}
?>

<!-- MOBILE BUTTON -->
<button
    class="btn btn-primary mobile-sidebar-toggle d-lg-none"
    id="btnMobileSidebar"
    type="button"
    aria-controls="sidebar"
    aria-expanded="false"
    aria-label="Abrir menú">

    <i class="bi bi-list"></i>
</button>

<!-- BACKDROP -->
<div class="sidebar-backdrop d-lg-none" id="sidebarBackdrop"></div>

<!-- SIDEBAR -->
<aside
    class="custom-sidebar d-flex flex-column flex-shrink-0 p-3"
    id="sidebar"
    aria-label="Menú principal">

    <!-- LOGO -->
    <div class="d-flex align-items-center justify-content-between mb-1 px-1">

        <a
            href="dashboard.php"
            class="logo-container d-flex align-items-center text-decoration-none text-white">

            <img
                src="../assets/Img/logo_munify/logo_negativo.png"
                alt="Munify Logo"
                class="sidebar-logo"
                style="width: 140px; height: auto;">
        </a>

        <button
            id="btnToggleSidebar"
            class="btn btn-sm text-white border-0 p-0 fs-4 ms-2"
            type="button"
            aria-label="Contraer menú">

            <i class="bi bi-list"></i>
        </button>
    </div>

    <hr class="sidebar-divider">

    <!-- MENU -->
    <ul class="nav nav-pills flex-column mb-auto">

        <!-- INICIO -->
        <li class="nav-item">
            <a
                href="dashboard.php"
                class="nav-link <?= isActive('dashboard.php', $current_page) ?>">

                <i class="bi bi-house-door me-2"></i>

                <span class="nav-text">
                    Inicio
                </span>
            </a>
        </li>

        <!-- CITAS -->
        <li class="nav-item">
            <a
                href="recepcion_citas.php"
                class="nav-link <?= isActive('recepcion_citas.php', $current_page) ?>">

                <i class="bi bi-calendar-check me-2"></i>

                <span class="nav-text">
                    Citas
                </span>
            </a>
        </li>

        <!-- SERVICIOS -->
        <li class="nav-item sidebar-dropdown">

            <a
                class="nav-link d-flex justify-content-between align-items-center <?= $servicios_active ? 'active' : 'text-white' ?>"
                data-bs-toggle="collapse"
                href="#menuServicios"
                role="button"
                aria-expanded="<?= $servicios_active ? 'true' : 'false' ?>"
                aria-controls="menuServicios">

                <div class="d-flex align-items-center">

                    <i class="bi bi-folder2-open me-2"></i>

                    <span class="nav-text">
                        Servicios
                    </span>
                </div>

                <i class="bi bi-chevron-down sidebar-arrow"></i>
            </a>

            <!-- SUBMENU -->
            <div
                class="collapse sidebar-submenu <?= $servicios_active ? 'show' : '' ?>"
                id="menuServicios">

                <ul class="list-unstyled small mb-0">

                    <li>
                        <a
                            href="recepcion_minoridad.php"
                            class="nav-link py-2 <?= isActive('recepcion_minoridad.php', $current_page) ?>">

                            <i class="bi bi-person-badge me-2"></i>

                            <span class="nav-text">
                                Carnet Minoridad
                            </span>
                        </a>
                    </li>

                    <li>
                        <a
                            href="recepcion_defuncion.php"
                            class="nav-link py-2 <?= isActive('recepcion_defuncion.php', $current_page) ?>">

                            <i class="bi bi-file-earmark-x me-2"></i>

                            <span class="nav-text">
                                Carta de Defunción
                            </span>
                        </a>
                    </li>

                    <li>
                        <a
                            href="recepcion_partida.php"
                            class="nav-link py-2 <?= isActive('recepcion_partida.php', $current_page) ?>">

                            <i class="bi bi-file-earmark-person me-2"></i>

                            <span class="nav-text">
                                Partida de Nacimiento
                            </span>
                        </a>
                    </li>

                    
                    <li>
                        <a
                            href="recepcion_testamento.php"
                            class="nav-link py-2 <?= isActive('recepcion_testamento.php', $current_page) ?>">

                            <i class="bi bi-file-earmark-x me-2"></i>

                            <span class="nav-text">
                                Testamento
                            </span>
                        </a>
                    </li>
                    <li>
    <a
        href="solicitud_matrimonio_civil.php"
        class="nav-link py-2 <?= isActive('solicitud_matrimonio_civil.php', $current_page) ?>">

        <i class="bi bi-heart me-2"></i>

        <span class="nav-text">
            Acta de Matrimonio
        </span>
    </a>
</li>

                </ul>
            </div>
        </li>

        <!-- BUSCADOR -->
        <li class="nav-item">
            <a
                href="buscador_documentos.php"
                class="nav-link <?= isActive('buscador_documentos.php', $current_page) ?>">

                <i class="bi bi-search me-2"></i>

                <span class="nav-text">
                    Buscar Documentos
                </span>
            </a>
        </li>

        <!-- ESTADISTICAS -->
        <li class="nav-item">
            <a
                href="estadisticas.php"
                class="nav-link <?= isActive('estadisticas.php', $current_page) ?>">

                <i class="bi bi-bar-chart-line me-2"></i>

                <span class="nav-text">
                    Estadísticas
                </span>
            </a>
        </li>

        <!-- USUARIOS -->
        <li class="nav-item">
            <a
                href="Usuarios.php"
                class="nav-link <?= isActive('Usuarios.php', $current_page) ?>">

                <i class="bi bi-people me-2"></i>

                <span class="nav-text">
                    Usuarios
                </span>
            </a>
        </li>

    </ul>

    <hr class="sidebar-divider">

    <!-- USER -->
    <div class="dropdown mt-auto">

        <a
            href="#"
            class="dropdown-toggle d-flex align-items-center text-decoration-none text-white"
            id="dropdownUser1"
            data-bs-toggle="dropdown"
            aria-expanded="false">

            <i class="bi bi-person-circle fs-4 me-2 user-icon"></i>

            <strong class="nav-text">
                <?= htmlspecialchars($nombre_usuario) ?>
            </strong>
        </a>

        <ul
            class="dropdown-menu dropdown-menu-dark text-small shadow"
            aria-labelledby="dropdownUser1">

            <li>
                <a class="dropdown-item" href="#">
                    Configuración
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="perfil.php">
                    Perfil
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a
                    class="dropdown-item"
                    href="../controller/logout.php">

                    Cerrar Sesión
                </a>
            </li>

        </ul>
    </div>

</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.getElementById('sidebar');

    const toggleBtn = document.getElementById('btnToggleSidebar');

    const mobileBtn = document.getElementById('btnMobileSidebar');

    const backdrop = document.getElementById('sidebarBackdrop');

    const desktopQuery = window.matchMedia('(min-width: 992px)');

    // MOBILE SIDEBAR
    const setMobileSidebar = (open) => {

        document.body.classList.toggle(
            'sidebar-open',
            open
        );

        mobileBtn?.setAttribute(
            'aria-expanded',
            open ? 'true' : 'false'
        );
    };

    // LOAD COLLAPSED STATE
    if (
        desktopQuery.matches &&
        localStorage.getItem('sidebar-collapsed') === 'true'
    ) {
        sidebar.classList.add('collapsed');
    }

    // TOGGLE SIDEBAR
    toggleBtn?.addEventListener('click', () => {

        if (desktopQuery.matches) {

            sidebar.classList.toggle('collapsed');

            localStorage.setItem(
                'sidebar-collapsed',
                sidebar.classList.contains('collapsed')
            );

            return;
        }

        setMobileSidebar(false);
    });

    // MOBILE BUTTON
    mobileBtn?.addEventListener('click', () => {

        setMobileSidebar(
            !document.body.classList.contains('sidebar-open')
        );
    });

    // BACKDROP
    backdrop?.addEventListener('click', () => {
        setMobileSidebar(false);
    });

    // CLOSE MOBILE MENU
    sidebar.querySelectorAll('.nav-link, .dropdown-item').forEach(link => {

        link.addEventListener('click', function() {

            // Ignore collapse button
            if (this.dataset.bsToggle === 'collapse') {
                return;
            }

            if (!desktopQuery.matches) {
                setMobileSidebar(false);
            }
        });
    });

    // DESKTOP CHANGE
    desktopQuery.addEventListener('change', event => {

        setMobileSidebar(false);

        if (
            event.matches &&
            localStorage.getItem('sidebar-collapsed') === 'true'
        ) {
            sidebar.classList.add('collapsed');

        } else {

            sidebar.classList.remove('collapsed');
        }
    });

});
</script>