<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - MUNIFY</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="#" class="nav-brand">
        <div class="nav-logo">
            <img src="assets/Img/MUNIFY.jpeg" alt="Logo"
                 onerror="this.style.display='none';this.parentElement.innerHTML='🏛️'">
        </div>
        <span class="nav-name">MUNIFY</span>
    </a>
    <button class="hamburger" onclick="toggleMenu()" aria-label="Menú">
        <i class="fas fa-bars" id="ham-icon"></i>
    </button>
    <div class="nav-links" id="nav-menu">
        <a href="#nosotros">Inicio</a>
        <a href="#servicios">Servicios</a>
        <a href="#nosotros">Nosotros</a>
        <a href="#ubicacion">Contacto</a>
        <a href="index.php" class="btn-login">Iniciar sesión</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-particles">
        <span style="--i:11"></span><span style="--i:18"></span>
        <span style="--i:24"></span><span style="--i:14"></span><span style="--i:20"></span>
    </div>

    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-badge">
                <i class="fas fa-landmark"></i>
                Institución &bull; Servicio &bull; Comunidad
            </div>
            <h1 class="hero-title">
                Bienvenido a<br><em>MUNIFY</em>
            </h1>
            <p class="hero-sub">
                Sistema de registro civil municipal. Tramita Partidas de Nacimiento, Carnets de Minoridad y más de forma rápida, segura y sin filas.
            </p>
            <div class="hero-btns">
                <a href="#servicios" class="btn-cta"><i class="fas fa-list-check"></i> Ver servicios</a>
                <a href="index.php" class="btn-ghost"><i class="fas fa-arrow-right-to-bracket"></i> Acceder al sistema</a>
            </div>
        </div>

        <!-- Tarjeta flotante -->
        <div class="hero-card">
            <div class="hc-icon"><i class="fas fa-landmark"></i></div>
            <h3>Gestión con identidad</h3>
            <p>Documentos oficiales para cada ciudadano, con atención ágil y proceso 100% verificado por la alcaldía.</p>
            <div class="hc-pills">
                <span class="hc-pill">Partida de Nacimiento</span>
                <span class="hc-pill">Carnet Minoridad</span>
                 <span class="hc-pill">Acta de defuncion</span>
            </div>
        </div>
    </div>

    <div class="scroll-hint">
        <span>Explorar</span>
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- QUIÉNES SOMOS -->
<div class="sep"><span>Nuestra institución</span></div>
<section id="nosotros">
    <div class="si">
        <p class="stag">¿Quiénes somos?</p>
        <h2 class="sh">Comprometidos con la Comunidad</h2>
        <div class="about-grid">
            <div>
                <p class="sb">
                    Somos la Alcaldía Municipal, la institución de gobierno local dedicada al bienestar y desarrollo de todos los ciudadanos.<br><br>
                    Nuestro equipo trabaja cada día para ofrecer servicios de registro civil ágiles, confiables y accesibles para toda la población.
                </p>
                <div class="vals">
                    <div class="val">
                        <div class="vi"><i class="fas fa-shield-halved"></i></div>
                        <div><h4>Transparencia</h4><p>Cada trámite gestionado con honestidad y rendición de cuentas a los ciudadanos.</p></div>
                    </div>
                    <div class="val">
                        <div class="vi"><i class="fas fa-people-group"></i></div>
                        <div><h4>Servicio ciudadano</h4><p>El ciudadano es el centro de todo lo que hacemos. Su tiempo y dignidad importan.</p></div>
                    </div>
                    <div class="val">
                        <div class="vi"><i class="fas fa-bolt"></i></div>
                        <div><h4>Eficiencia digital</h4><p>Procesos de trámites municipales presenciales.</p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-main">
            <div class="login-form-container">
                <div class="mobile-logo">
                    <img src="../assets/Img/MUNIFY.jpeg" alt="Logo Alcaldía" onerror="this.style.display='none'">
                    <h2>MUNIFY</h2>
                </div>
                <div class="form-header">
                    <h1>Acceso al Sistema</h1>
                    <p>Ingrese sus credenciales oficiales para continuar</p>
                </div>
                
                <form action="#" method="POST" id="loginForm" class="flat-form">
                    <div class="form-group">
                        <label for="username">Usuario Institucional</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" placeholder="Ej: admin" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key"></i>
                            <input type="password" id="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="#" class="forgot-link">¿Olvidó su contraseña?</a>
                    </div>

                    <button type="button" id="loginBtn" class="btn-flat">
                        <span class="btn-text">Ingresar al sistema</span>
                        <div class="loader" style="display: none;">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                    </button>
                    
                    <div class="back-link-container">
                         <a href="../index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver al portal principal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Bienvenida -->
    <div class="welcome-modal" id="welcomeModal">
        <div class="modal-content">
            <i class="fas fa-check-circle success-icon"></i>
            <h3>Identidad Verificada</h3>
            <p>Bienvenido al sistema, <strong id="welcomeUser"></strong>.</p>
            <p class="redirect-text">Redirigiendo al panel de control...</p>
        </div>
    </div>

    <script src="../assets/Js/Login.js?v=<?php echo time(); ?>"></script>
</body>
</html>