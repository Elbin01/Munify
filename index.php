<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alcaldía Municipal — MUNIFY</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --color-1: #40FFDC;
            --color-2: #00A9D4;
            --color-3: #1C3166;
            --color-4: #240047;
            --color-5: #1C0021;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; background: var(--color-5); color: #fff; overflow-x: hidden; }

        /* ══════════════ NAVBAR ══════════════ */
        nav {
            position: fixed; top: 0; width: 100%; z-index: 300;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 4rem;
            background: rgba(8, 8, 8, 0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(64, 255, 220, 0.15);
        }
        .nav-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .nav-logo {
            width: 45px; height: auto;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .nav-logo img { width: 100%; height: 100%; object-fit: cover; }
        .nav-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 700;
            color: var(--color-1);
        }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a {
            color: rgba(255,255,255,0.65);
            font-size: 0.84rem; font-weight: 400;
            text-decoration: none; transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--color-1); }
        .btn-login {
            background: var(--color-1) !important;
            color: var(--color-5) !important;
            padding: 0.48rem 1.4rem; border-radius: 5px;
            font-size: 0.82rem !important; font-weight: 700 !important;
            letter-spacing: 0.04em; transition: background 0.25s !important;
        }
        .btn-login:hover { background: var(--color-2) !important; color: #fff !important; }
        .hamburger { display: none; background: none; border: none; color: var(--color-1); font-size: 1.3rem; cursor: pointer; }

        /* ══════════════ HERO ══════════════ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex; align-items: center;
            overflow: hidden;
            /* Degradado institucional de fondo — no necesita imagen */
            background: linear-gradient(135deg, var(--color-3) 0%, #100938 45%, var(--color-3) 100%);
        }

        /* Efecto de malla luminosa */
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 15% 50%, rgba(64,255,220,0.12) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 20%, rgba(0,169,212,0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 75% 80%, rgba(36,0,71,0.6) 0%, transparent 50%);
        }

        /* Líneas decorativas tipo grid */
        .hero::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(64,255,220,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(64,255,220,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Partículas */
        .hero-particles {
            position: absolute; inset: 0; z-index: 1;
            display: flex; justify-content: space-around; pointer-events: none;
        }
        .hero-particles span {
            position: relative; width: 14px; height: 14px;
            background: var(--color-1); border-radius: 50%;
            box-shadow: 0 0 20px var(--color-1), 0 0 50px var(--color-1);
            animation: floatUp calc(150s / var(--i)) linear infinite; opacity: 0.12;
        }
        @keyframes floatUp {
            0%   { transform: translateY(100vh) scale(0); }
            100% { transform: translateY(-10vh) scale(1.2); }
        }

        /* Contenido hero */
        .hero-inner {
            position: relative; z-index: 10;
            width: 100%; max-width: 1100px; margin: 0 auto;
            padding: 8rem 4rem 5rem;
            display: flex; align-items: center;
            justify-content: space-between; gap: 3rem;
        }
        .hero-left { flex: 1; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(64,255,220,0.09);
            border: 1px solid rgba(64,255,220,0.3);
            border-radius: 50px; padding: 0.35rem 1.1rem;
            font-size: 0.7rem; letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--color-1); margin-bottom: 1.5rem;
            animation: up 0.6s ease both;
        }

        .hero-title {
            font-size: clamp(2.6rem, 6vw, 4.4rem);
            font-weight: 800; line-height: 1.08;
            margin-bottom: 1.2rem;
            animation: up 0.6s 0.1s ease both;
        }
        .hero-title em {
            font-style: italic; color: var(--color-1);
            font-family: 'Playfair Display', serif;
        }

        .hero-sub {
            font-size: 1rem; font-weight: 300; line-height: 1.78;
            color: rgba(255,255,255,0.58); max-width: 460px;
            margin-bottom: 2.4rem;
            animation: up 0.6s 0.2s ease both;
        }

        .hero-btns {
            display: flex; gap: 1rem; flex-wrap: wrap;
            animation: up 0.6s 0.3s ease both;
        }
        .btn-cta {
            background: var(--color-1); color: var(--color-5); border: none;
            padding: 0.9rem 2rem; border-radius: 6px;
            font-family: 'Poppins', sans-serif; font-size: 0.85rem;
            font-weight: 700; letter-spacing: 0.05em; cursor: pointer;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.25s;
        }
        .btn-cta:hover { background: var(--color-2); color: #fff; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,169,212,0.4); }

        .btn-ghost {
            background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.82);
            border: 1px solid rgba(255,255,255,0.2); padding: 0.9rem 1.6rem;
            border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 0.85rem;
            cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.25s; backdrop-filter: blur(6px);
        }
        .btn-ghost:hover { border-color: var(--color-1); color: var(--color-1); }

        /* Tarjeta flotante */
        .hero-card {
            background: rgba(255,255,255,0.97);
            border-radius: 20px; padding: 2rem 1.8rem;
            width: 270px; flex-shrink: 0; color: #1a1a2e;
            box-shadow: 0 30px 70px rgba(0,0,0,0.5), 0 0 0 1px rgba(64,255,220,0.1);
            animation: up 0.7s 0.45s ease both;
        }
        .hc-icon {
            width: 54px; height: 54px; background: var(--color-3);
            border-radius: 14px; display: flex; align-items: center;
            justify-content: center; font-size: 1.4rem; color: var(--color-1);
            margin-bottom: 1.1rem;
        }
        .hero-card h3 { font-size: 1.05rem; font-weight: 700; color: var(--color-3); margin-bottom: 0.5rem; }
        .hero-card p { font-size: 0.78rem; color: #666; line-height: 1.65; margin-bottom: 1.3rem; }
        .hc-pills { display: flex; flex-wrap: wrap; gap: 0.4rem; }
        .hc-pill {
            background: rgba(28,49,102,0.09); color: var(--color-3);
            border-radius: 50px; padding: 0.28rem 0.8rem;
            font-size: 0.68rem; font-weight: 600;
        }

        /* Indicador de scroll */
        .scroll-hint {
            position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 0.4rem;
            color: rgba(255,255,255,0.25); font-size: 0.6rem; letter-spacing: 0.2em;
            text-transform: uppercase; z-index: 10;
            animation: bob 2.2s ease-in-out infinite;
        }
        @keyframes bob { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(7px)} }
        @keyframes up  { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

        /* ══════════════ LAYOUT GENERAL ══════════════ */
        .sep {
            position: relative; z-index: 10;
            display: flex; align-items: center; gap: 1rem;
            max-width: 1040px; margin: 0 auto; padding: 0 2rem;
        }
        .sep::before, .sep::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(to right, transparent, rgba(64,255,220,0.22));
        }
        .sep::after { background: linear-gradient(to left, transparent, rgba(64,255,220,0.22)); }
        .sep span { font-size: 0.6rem; letter-spacing: 0.2em; color: rgba(64,255,220,0.45); text-transform: uppercase; white-space: nowrap; }

        section { position: relative; z-index: 10; }
        .si { max-width: 1040px; margin: 0 auto; padding: 5.5rem 2rem; }
        .stag { font-size: 0.68rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--color-1); margin-bottom: 0.4rem; }
        .sh { font-family: 'Playfair Display', serif; font-size: clamp(1.7rem,3vw,2.4rem); font-weight: 700; margin-bottom: 1rem; }
        .sb { font-size: 0.9rem; font-weight: 300; color: rgba(255,255,255,0.5); line-height: 1.8; max-width: 580px; }

        /* ══════════════ QUIÉNES SOMOS ══════════════ */
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 3.5rem; }
        .vals { display: flex; flex-direction: column; gap: 1rem; margin-top: 1.8rem; }
        .val { display: flex; align-items: flex-start; gap: 1rem; background: rgba(60, 101, 206, 0.28); border: 1px solid rgba(64,255,220,0.1); border-radius: 10px; padding: 1rem 1.2rem; transition: border-color 0.2s; }
        .val:hover { border-color: rgba(64,255,220,0.3); }
        .vi { width: 38px; height: 38px; flex-shrink: 0; background: rgba(64,255,220,0.1); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: var(--color-1); font-size: 1rem; }
        .val h4 { font-size: 0.85rem; font-weight: 600; margin-bottom: 0.2rem; }
        .val p { font-size: 0.75rem; color: rgba(255,255,255,0.42); line-height: 1.5; }
        .stats-vis { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .sc { background: rgba(66, 74, 143, 0.35); border: 1px solid rgba(64,255,220,0.12); border-radius: 12px; padding: 1.5rem; text-align: center; transition: transform 0.2s, border-color 0.2s; }
        .sc:hover { transform: translateY(-3px); border-color: rgba(64,255,220,0.3); }
        .sc:nth-child(2) { margin-top: 1.5rem; }
        .sc:nth-child(4) { margin-top: -1.5rem; }
        .sn { font-family: 'Playfair Display', serif; font-size: 2.1rem; font-weight: 700; color: var(--color-1); line-height: 1; margin-bottom: 0.3rem; }
        .sl { font-size: 0.7rem; color: rgba(255,255,255,0.38); letter-spacing: 0.08em; }

        /* ══════════════ SERVICIOS ══════════════ */
        .svc-section { background: rgba(28,49,102,0.1); border-top: 1px solid rgba(64,255,220,0.07); border-bottom: 1px solid rgba(64,255,220,0.07); }
        .svc-grid { display: grid; grid-template-columns: repeat(auto-fit,minmax(220px,1fr)); gap: 1.25rem; margin-top: 3rem; }
        .svc { background: rgba(28,0,33,0.65); border: 1px solid rgba(64,255,220,0.1); border-radius: 12px; padding: 1.75rem 1.5rem; transition: all 0.25s; position: relative; overflow: hidden; }
        .svc::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg,var(--color-1),var(--color-2)); transform: scaleX(0); transition: transform 0.3s; }
        .svc:hover { border-color: rgba(64,255,220,0.3); transform: translateY(-4px); box-shadow: 0 18px 40px rgba(0,0,0,0.4); }
        .svc:hover::after { transform: scaleX(1); }
        .svc-ico { width: 50px; height: 50px; background: rgba(64,255,220,0.08); border: 1px solid rgba(64,255,220,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--color-1); font-size: 1.2rem; margin-bottom: 1.1rem; }
        .svc h3 { font-size: 0.95rem; font-weight: 600; margin-bottom: 0.5rem; }
        .svc p { font-size: 0.78rem; color: rgba(255,255,255,0.42); line-height: 1.65; }

        /* ══════════════ UBICACIÓN ══════════════ */
        .loc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 3.5rem; align-items: start; }
        .loc-info { display: flex; flex-direction: column; gap: 1rem; }
        .ir { display: flex; align-items: flex-start; gap: 1rem; background: rgba(28,49,102,0.25); border: 1px solid rgba(64,255,220,0.1); border-radius: 10px; padding: 1.1rem 1.25rem; transition: border-color 0.2s; }
        .ir:hover { border-color: rgba(64,255,220,0.28); }
        .ii { width: 36px; height: 36px; flex-shrink: 0; background: rgba(64,255,220,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--color-1); font-size: 0.9rem; }
        .ir h4 { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--color-1); margin-bottom: 0.25rem; }
        .ir p { font-size: 0.82rem; color: rgba(255,255,255,0.62); line-height: 1.5; }
        .sched { background: rgba(64,255,220,0.06); border: 1px solid rgba(64,255,220,0.15); border-radius: 10px; padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .sd-item { text-align: center; }
        .sd-day { font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.35); margin-bottom: 0.2rem; }
        .sd-time { font-size: 0.9rem; font-weight: 600; color: var(--color-1); }
        .sd-line { width: 1px; height: 36px; background: rgba(64,255,220,0.18); }
        .map-box { border-radius: 14px; overflow: hidden; border: 1px solid rgba(64,255,220,0.15); aspect-ratio: 4/3; background: rgba(28,49,102,0.3); }
        .map-box iframe { width: 100%; height: 100%; border: none; filter: saturate(0.5) brightness(0.72); }

        /* ══════════════ REDES ══════════════ */
        .social-wrap { text-align: center; }
        .social-grid { display: flex; justify-content: center; gap: 1.1rem; flex-wrap: wrap; margin-top: 2.5rem; }
        .soc { display: flex; flex-direction: column; align-items: center; gap: 0.6rem; background: rgba(28,49,102,0.3); border: 1px solid rgba(64,255,220,0.1); border-radius: 14px; padding: 1.5rem 1.8rem; text-decoration: none; color: #fff; transition: all 0.25s; min-width: 120px; }
        .soc:hover { border-color: var(--c); transform: translateY(-3px); }
        .soc i { font-size: 1.6rem; color: var(--c); }
        .soc span { font-size: 0.72rem; color: rgba(255,255,255,0.5); }

        /* ══════════════ FOOTER ══════════════ */
        footer { position: relative; z-index: 10; border-top: 1px solid rgba(64,255,220,0.1); padding: 2.5rem 4rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.2rem; }
        .fb { display: flex; align-items: center; gap: 0.7rem; }
        .fb img { width: 38px; height: auto; object-fit: cover; }
        .fb span { font-size: 0.8rem; color: rgba(255,255,255,0.3); }
        .fl { display: flex; gap: 2rem; }
        .fl a { font-size: 0.74rem; color: rgba(255,255,255,0.3); text-decoration: none; transition: color 0.2s; }
        .fl a:hover { color: var(--color-1); }
        .copy { font-size: 0.68rem; color: rgba(255,255,255,0.18); }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 900px) {
            .hero-card { display: none; }
            .hero-inner { justify-content: flex-start; }
        }
        @media (max-width: 680px) {
            nav { padding: 0.9rem 1.5rem; }
            .nav-links { display: none; position: absolute; top: 100%; left: 0; right: 0; flex-direction: column; align-items: flex-start; background: rgba(28,0,33,0.97); padding: 1.5rem; gap: 1.2rem; border-bottom: 1px solid rgba(64,255,220,0.12); }
            .nav-links.open { display: flex; }
            .hamburger { display: block; }
            .hero-inner { padding: 7rem 1.5rem 4rem; }
            .hero-title { font-size: 2.3rem; }
            .about-grid, .loc-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .stats-vis { order: -1; }
            .sched { justify-content: center; }
            .sd-line { display: none; }
            footer { padding: 2rem 1.5rem; flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="#" class="nav-brand">
        <img src="assets/Img/logo_munify/logo_negativo.png" alt="Munify Logo" style="height: 40px; width: auto;">
    </a>
    <button class="hamburger" id="hamburger-btn" aria-label="Menú">
        <i class="fas fa-bars" id="ham-icon"></i>
    </button>
    <div class="nav-links" id="nav-menu">
        <a href="#nosotros">Inicio</a>
        <a href="#servicios">Servicios</a>
        <a href="#nosotros">Nosotros</a>
        <a href="#ubicacion">Contacto</a>
        <a href="views/principal.php" class="btn-login" id="btn-login-nav">Iniciar sesión</a>
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
                <a href="views/principal.php" class="btn-ghost" id="btn-login-hero"><i class="fas fa-arrow-right-to-bracket"></i> Acceder al sistema</a>
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
                <span class="hc-pill">Acta de Defunción</span>
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
    </div>
</section>

<!-- SERVICIOS -->
<div class="sep"><span>Lo que ofrecemos</span></div>
<section id="servicios" class="svc-section">
    <div class="si">
        <p class="stag">Nuestros servicios</p>
        <h2 class="sh">¿Qué necesitas tramitar?</h2>
        <p class="sb">Documentos oficiales, trámites civiles y atención ciudadana desde un mismo lugar.</p>
        <div class="svc-grid">
            <div class="svc">
                <div class="svc-ico"><i class="fas fa-baby"></i></div>
                <h3>Partida de Nacimiento</h3>
                <p>Primera Emisión y copias certificadas del acta de nacimiento para uso oficial y personal.</p>
            </div>
            <div class="svc">
                <div class="svc-ico"><i class="fas fa-id-card"></i></div>
                <h3>Carnet de Minoridad</h3>
                <p>Identificación oficial para menores de 18 años con validez a nivel Nacional.</p>
            </div>
            <div class="svc">
                <div class="svc-ico"><i class="fas fa-copy"></i></div>
                <h3>Acta de Defunción</h3>
                <p>Documento Legal a Través del Cual Se Certifica El Fallecimiento de Una Persona y El Lugar Donde El Fallecimiento Fue Inscrito.</p>
            </div>
            
        </div>
    </div>
</section>

<!-- UBICACIÓN -->
<div class="sep"><span>Dónde encontrarnos</span></div>
<section id="ubicacion">
    <div class="si">
        <p class="stag">Ubicación y contacto</p>
        <h2 class="sh">Estamos aquí para atenderte</h2>
        <div class="loc-grid">
            <div class="loc-info">
                <div class="ir">
                    <div class="ii"><i class="fas fa-location-dot"></i></div>
                    <div>
                        <h4>Dirección</h4>
                        <p>Universidad Catolica  Regional de Ilobasco, El Salvador</p>
                    </div>
                </div>
                <div class="ir">
                    <div class="ii"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Teléfono</h4>
                        <p>2222-3333 &nbsp;|&nbsp; 2222-4444</p>
                    </div>
                </div>
                <div class="ir">
                    <div class="ii"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4>Correo electrónico</h4>
                        <p>registro.civil@alcaldia.gob.sv</p>
                    </div>
                </div>
                <div class="sched">
                    <div class="sd-item">
                        <div class="sd-day">Lunes — Viernes</div>
                        <div class="sd-time">8:00 a.m. — 3:00 p.m.</div>
                    </div>
                    <div class="sd-line"></div>
                    <div class="sd-item">
                        <div class="sd-day">Sábado</div>
                        <div class="sd-time">Cerrado</div>
                    </div>
                    <div class="sd-line"></div>
                    <div class="sd-item">
                        <div class="sd-day">Domingo</div>
                        <div class="sd-time">Cerrado</div>
                    </div>
                </div>
            </div>

            <!-- ✏️ Reemplaza el src con el embed real de tu alcaldía en Google Maps -->
            <div class="map-box">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.5!2d-89.2182!3d13.6929!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDQxJzM0LjQiTiA4OcKwMTMnMDUuNSJX!5e0!3m2!1ses!2ssv!4v1700000000000"
                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- REDES SOCIALES -->
<div class="sep"><span>Síguenos</span></div>
<section id="contacto" class="svc-section">
    <div class="si social-wrap">
        <p class="stag">Redes sociales</p>
        <h2 class="sh">Conéctate con nosotros</h2>
        <p class="sb" style="margin: 0.5rem auto 0;">Entérate de noticias, horarios especiales y avisos de tu alcaldía.</p>
        <div class="social-grid">
            <!-- ✏️ Cambia los href por las URLs reales -->
            <a href="https://facebook.com/" target="_blank" class="soc" style="--c:#1877F2">
                <i class="fab fa-facebook-f"></i><span>Facebook</span>
            </a>
            <a href="https://instagram.com/" target="_blank" class="soc" style="--c:#E1306C">
                <i class="fab fa-instagram"></i><span>Instagram</span>
            </a>
            <a href="https://twitter.com/" target="_blank" class="soc" style="--c:#1DA1F2">
                <i class="fab fa-x-twitter"></i><span>Twitter / X</span>
            </a>
            <a href="https://wa.me/50300000000" target="_blank" class="soc" style="--c:#25D366">
                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="fb">
        <img src="assets/Img/logo_munify/logo_negativo.png" alt="Munify Logo" style="height: 35px; width: auto;">
    </div>
    <div class="fl">
        <a href="#nosotros">Institución</a>
        <a href="#servicios">Servicios</a>
        <a href="#ubicacion">Contacto</a>
        <a href="views/principal.php">Sistema</a>
    </div>
    <p class="copy">&copy; <?= date('Y') ?> Alcaldía Municipal. Todos los derechos reservados.</p>
</footer>

<script src="assets/Js/principal.js"></script>

</body>
</html>
