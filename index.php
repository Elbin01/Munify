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
            --color-1: #1C3166;
            --color-2: #550000;
            --color-3: #FFFFFF;
            --color-4: #333333;
            --color-5: #F4F7F6;
            --color-6: #00A9D4;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; background: var(--color-5); color: var(--color-4); overflow-x: hidden; }

        /* ══════════════ NAVBAR ══════════════ */
        nav {
            position: fixed; top: 0; width: 100%; z-index: 300;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 4rem;
            background: rgba(28, 49, 102, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 3px solid var(--color-2);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .nav-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .nav-logo {
            width: 42px; height: 42px; border-radius: 50%;
            border: 2px solid var(--color-3);
            background: var(--color-3);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; overflow: hidden;
        }
        .nav-logo img { width: 100%; height: 100%; object-fit: cover; }
        .nav-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 700;
            color: var(--color-3);
        }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a {
            color: rgba(255,255,255,0.85);
            font-size: 0.84rem; font-weight: 500;
            text-decoration: none; transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--color-3); text-shadow: 0 0 8px rgba(255,255,255,0.5); }
        .btn-login {
            background: var(--color-3) !important;
            color: var(--color-1) !important;
            padding: 0.48rem 1.4rem; border-radius: 50px;
            font-size: 0.82rem !important; font-weight: 700 !important;
            letter-spacing: 0.04em; transition: all 0.25s !important;
        }
        .btn-login:hover { background: var(--color-2) !important; color: #fff !important; }
        .hamburger { display: none; background: none; border: none; color: var(--color-3); font-size: 1.3rem; cursor: pointer; }

        /* ══════════════ HERO ══════════════ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex; align-items: center;
            overflow: hidden;
            background: linear-gradient(135deg, var(--color-1) 0%, var(--color-2) 100%);
        }

        /* Efecto de malla luminosa */
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 15% 50%, rgba(255, 255, 255,0.12) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 20%, rgba(28, 49, 102,0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 75% 80%, rgba(85, 0, 0,0.4) 0%, transparent 50%);
        }

        /* Partículas */
        .hero-particles {
            position: absolute; inset: 0; z-index: 1;
            display: flex; justify-content: space-around; pointer-events: none;
        }
        .hero-particles span {
            position: relative; width: 14px; height: 14px;
            background: var(--color-3); border-radius: 50%;
            box-shadow: 0 0 20px var(--color-3), 0 0 50px var(--color-3);
            animation: floatUp calc(150s / var(--i)) linear infinite; opacity: 0.15;
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
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px; padding: 0.35rem 1.1rem;
            font-size: 0.7rem; letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--color-3); margin-bottom: 1.5rem;
            animation: up 0.6s ease both;
        }

        .hero-title {
            font-size: clamp(2.6rem, 6vw, 4.4rem);
            font-weight: 800; line-height: 1.08; color: var(--color-3);
            margin-bottom: 1.2rem;
            animation: up 0.6s 0.1s ease both;
        }
        .hero-title em {
            font-style: italic; color: #40FFDC;
            font-family: 'Playfair Display', serif;
        }

        .hero-sub {
            font-size: 1.05rem; font-weight: 400; line-height: 1.78;
            color: rgba(255,255,255,0.9); max-width: 460px;
            margin-bottom: 2.4rem;
            animation: up 0.6s 0.2s ease both;
        }

        .hero-btns {
            display: flex; gap: 1rem; flex-wrap: wrap;
            animation: up 0.6s 0.3s ease both;
        }
        .btn-cta {
            background: var(--color-3); color: var(--color-1); border: none;
            padding: 0.9rem 2rem; border-radius: 50px;
            font-family: 'Poppins', sans-serif; font-size: 0.85rem;
            font-weight: 700; letter-spacing: 0.05em; cursor: pointer;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.25s;
        }
        .btn-cta:hover { background: var(--color-2); color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }

        .btn-ghost {
            background: rgba(255,255,255,0.1); color: #fff;
            border: 1px solid rgba(255,255,255,0.3); padding: 0.9rem 1.6rem;
            border-radius: 50px; font-family: 'Poppins', sans-serif; font-size: 0.85rem;
            cursor: pointer; text-decoration: none; font-weight: 600;
            display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.25s; backdrop-filter: blur(6px);
        }
        .btn-ghost:hover { border-color: var(--color-3); background: rgba(255,255,255,0.2); }

        /* Tarjeta flotante */
        .hero-card {
            background: #ffffff;
            border-radius: 16px; padding: 2.5rem 2rem;
            width: 300px; flex-shrink: 0; color: var(--color-4);
            box-shadow: 0 25px 50px rgba(0,0,0,0.3), border-bottom: 4px solid var(--color-2);
            animation: up 0.7s 0.45s ease both;
            border-bottom: 4px solid var(--color-2);
        }
        .hc-icon {
            width: 60px; height: 60px; background: rgba(28, 49, 102, 0.1);
            border-radius: 14px; display: flex; align-items: center;
            justify-content: center; font-size: 1.6rem; color: var(--color-1);
            margin-bottom: 1.2rem;
        }
        .hero-card h3 { font-size: 1.15rem; font-weight: 700; color: var(--color-1); margin-bottom: 0.5rem; }
        .hero-card p { font-size: 0.85rem; color: #666; line-height: 1.65; margin-bottom: 1.5rem; }
        .hc-pills { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .hc-pill {
            background: rgba(85, 0, 0, 0.1); color: var(--color-2);
            border-radius: 50px; padding: 0.35rem 0.9rem;
            font-size: 0.75rem; font-weight: 600;
        }

        /* Indicador de scroll */
        .scroll-hint {
            position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 0.4rem;
            color: rgba(255,255,255,0.7); font-size: 0.65rem; letter-spacing: 0.2em;
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
            background: linear-gradient(to right, transparent, rgba(28, 49, 102, 0.2));
        }
        .sep::after { background: linear-gradient(to left, transparent, rgba(28, 49, 102, 0.2)); }
        .sep span { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.2em; color: var(--color-2); text-transform: uppercase; white-space: nowrap; }

        section { position: relative; z-index: 10; }
        .si { max-width: 1040px; margin: 0 auto; padding: 5.5rem 2rem; }
        .stag { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: var(--color-2); margin-bottom: 0.4rem; }
        .sh { font-family: 'Playfair Display', serif; font-size: clamp(2rem,3vw,2.6rem); font-weight: 700; color: var(--color-1); margin-bottom: 1rem; }
        .sb { font-size: 0.95rem; font-weight: 400; color: #555; line-height: 1.8; max-width: 600px; }

        /* ══════════════ QUIÉNES SOMOS ══════════════ */
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 3.5rem; }
        .vals { display: flex; flex-direction: column; gap: 1rem; margin-top: 1.8rem; }
        .val { display: flex; align-items: flex-start; gap: 1.2rem; background: #ffffff; border: 1px solid #E2E8F0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border-radius: 12px; padding: 1.2rem 1.4rem; transition: border-color 0.2s, box-shadow 0.2s; }
        .val:hover { border-color: rgba(28, 49, 102, 0.3); box-shadow: 0 10px 20px rgba(0,0,0,0.06); }
        .vi { width: 44px; height: 44px; flex-shrink: 0; background: rgba(85, 0, 0, 0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--color-2); font-size: 1.2rem; }
        .val h4 { font-size: 0.95rem; font-weight: 700; color: var(--color-1); margin-bottom: 0.3rem; }
        .val p { font-size: 0.8rem; color: #666; line-height: 1.5; }
        .stats-vis { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .sc { background: #ffffff; border: 1px solid #E2E8F0; box-shadow: 0 4px 10px rgba(0,0,0,0.04); border-radius: 16px; padding: 2rem; text-align: center; transition: transform 0.2s; }
        .sc:hover { transform: translateY(-5px); border-color: var(--color-1); }
        .sc:nth-child(2) { margin-top: 2rem; }
        .sc:nth-child(4) { margin-top: -2rem; }
        .sn { font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 700; color: var(--color-2); line-height: 1; margin-bottom: 0.5rem; }
        .sl { font-size: 0.8rem; font-weight: 600; color: var(--color-1); letter-spacing: 0.05em; text-transform: uppercase;}

        /* ══════════════ SERVICIOS ══════════════ */
        .svc-section { background: rgba(28, 49, 102, 0.03); border-top: 1px solid rgba(0,0,0,0.05); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .svc-grid { display: grid; grid-template-columns: repeat(auto-fit,minmax(240px,1fr)); gap: 1.5rem; margin-top: 3rem; }
        .svc { background: #ffffff; border: 1px solid #E2E8F0; border-radius: 14px; padding: 2rem 1.8rem; transition: all 0.3s; position: relative; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        .svc::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: var(--color-2); transform: scaleX(0); transition: transform 0.3s; transform-origin: left; }
        .svc:hover { border-color: rgba(85, 0, 0, 0.2); transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .svc:hover::after { transform: scaleX(1); }
        .svc-ico { width: 56px; height: 56px; background: rgba(28, 49, 102, 0.06); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: var(--color-1); font-size: 1.5rem; margin-bottom: 1.2rem; }
        .svc h3 { font-size: 1.05rem; font-weight: 700; color: var(--color-1); margin-bottom: 0.6rem; }
        .svc p { font-size: 0.85rem; color: #666; line-height: 1.65; }

        /* ══════════════ SERVICIO DESTACADO ══════════════ */
        .featured-svc {
            display: flex; align-items: center; justify-content: space-between; gap: 2.5rem;
            background: linear-gradient(135deg, var(--color-1) 0%, var(--color-2) 100%);
            border-radius: 16px; padding: 2.5rem; margin: 2rem 0 3rem;
            box-shadow: 0 15px 35px rgba(28, 49, 102, 0.25);
        }
        .featured-svc-img {
            flex-shrink: 0; width: 220px; height: 220px; border-radius: 12px;
            overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .featured-svc-img img { width: 100%; height: 100%; object-fit: cover; }
        .featured-svc-content { flex: 1; }
        .featured-svc-title { font-size: 2rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem; font-family: 'Poppins', sans-serif; }
        .featured-svc-subtitle { font-size: 0.9rem; color: #40FFDC; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.2rem; }
        .featured-svc-desc { font-size: 0.95rem; color: rgba(255,255,255,0.9); line-height: 1.7; max-width: 650px; }
        .btn-featured {
            background: #ffffff; color: var(--color-1); padding: 0.9rem 2rem; border-radius: 50px;
            font-weight: 700; text-decoration: none; display: inline-flex; align-items: center;
            gap: 0.5rem; transition: all 0.25s; white-space: nowrap; font-size: 0.95rem;
        }
        .btn-featured:hover { background: #f0f0f0; color: var(--color-2); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        
        @media (max-width: 900px) {
            .featured-svc { flex-direction: column; text-align: center; padding: 2rem; }
            .featured-svc-img { width: 100%; height: 250px; }
            .featured-svc-desc { margin: 0 auto; }
        }

        /* ══════════════ UBICACIÓN ══════════════ */
        .loc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 3.5rem; align-items: start; }
        .loc-info { display: flex; flex-direction: column; gap: 1rem; }
        .ir { display: flex; align-items: flex-start; gap: 1rem; background: #ffffff; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1.2rem 1.4rem; transition: border-color 0.2s, box-shadow 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .ir:hover { border-color: rgba(28, 49, 102, 0.3); box-shadow: 0 10px 20px rgba(0,0,0,0.06); }
        .ii { width: 44px; height: 44px; flex-shrink: 0; background: rgba(85, 0, 0, 0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--color-2); font-size: 1.2rem; }
        .ir h4 { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-1); margin-bottom: 0.25rem; }
        .ir p { font-size: 0.9rem; color: #555; line-height: 1.5; }
        .sched { background: #ffffff; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .sd-item { text-align: center; }
        .sd-day { font-size: 0.7rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-1); margin-bottom: 0.3rem; }
        .sd-time { font-size: 0.95rem; font-weight: 700; color: #333; }
        .sd-line { width: 1px; height: 36px; background: #E2E8F0; }
        .map-box { border-radius: 14px; overflow: hidden; border: 1px solid #E2E8F0; aspect-ratio: 4/3; background: #E2E8F0; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .map-box iframe { width: 100%; height: 100%; border: none; filter: saturate(0.9); }

        /* ══════════════ REDES ══════════════ */
        .social-wrap { text-align: center; }
        .social-grid { display: flex; justify-content: center; gap: 1.1rem; flex-wrap: wrap; margin-top: 2.5rem; }
        .soc { display: flex; flex-direction: column; align-items: center; gap: 0.8rem; background: #ffffff; border: 1px solid #E2E8F0; border-radius: 14px; padding: 1.8rem; text-decoration: none; color: #333; transition: all 0.25s; min-width: 130px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .soc:hover { border-color: var(--c); transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        .soc i { font-size: 1.8rem; color: var(--c); }
        .soc span { font-size: 0.85rem; font-weight: 600; color: #555; }

        /* ══════════════ FOOTER ══════════════ */
        footer { position: relative; z-index: 10; background: var(--color-1); border-top: 5px solid var(--color-2); padding: 3rem 4rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem; }
        .fb { display: flex; align-items: center; gap: 1rem; }
        .fb img { width: 44px; height: 44px; border-radius: 50%; border: 2px solid #ffffff; object-fit: cover; }
        .fb span { font-size: 0.95rem; font-weight: 600; color: #ffffff; }
        .fl { display: flex; gap: 2rem; }
        .fl a { font-size: 0.85rem; font-weight: 500; color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.2s; }
        .fl a:hover { color: #ffffff; text-decoration: underline; }
        .copy { font-size: 0.8rem; color: rgba(255,255,255,0.5); width: 100%; text-align: center; margin-top: 1rem; }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 900px) {
            .hero-card { display: none; }
            .hero-inner { justify-content: flex-start; }
        }
        @media (max-width: 680px) {
            nav { padding: 0.9rem 1.5rem; }
            .nav-links { display: none; position: absolute; top: 100%; left: 0; right: 0; flex-direction: column; align-items: flex-start; background: var(--color-1); padding: 1.5rem; gap: 1.2rem; border-bottom: 3px solid var(--color-2); }
            .nav-links.open { display: flex; }
            .hamburger { display: block; color: #ffffff; }
            .hero-inner { padding: 7rem 1.5rem 4rem; }
            .hero-title { font-size: 2.3rem; }
            .about-grid, .loc-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .stats-vis { order: -1; }
            .sched { justify-content: center; }
            .sd-line { display: none; }
            footer { padding: 2.5rem 1.5rem; flex-direction: column; align-items: flex-start; }
            .copy { text-align: left; }
        }
    </style>
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
    <button class="hamburger" id="hamburger-btn" aria-label="Menú">
        <i class="fas fa-bars" id="ham-icon"></i>
    </button>
    <div class="nav-links" id="nav-menu">
        <a href="#nosotros">Inicio</a>
        <a href="#servicios">Servicios</a>
        <a href="#nosotros">Nosotros</a>
        <a href="#ubicacion">Contacto</a>
        <a href="views/login.php" class="btn-login" id="btn-login-nav">Iniciar sesión</a>
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
                <a href="views/login.php" class="btn-ghost" id="btn-login-hero"><i class="fas fa-arrow-right-to-bracket"></i> Acceder al sistema</a>
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
            <div class="stats-vis">
                <div class="sc"><div class="sn">+12k</div><div class="sl">Partidas Emitidas</div></div>
                <div class="sc"><div class="sn">+3.8k</div><div class="sl">Carnets de Minoridad</div></div>
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
        
        <!-- Tarjeta de Servicio Destacado (Estilo Simple.sv) -->
        <div class="featured-svc">
            <div class="featured-svc-img">
                <img src="https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Ciudadana consultando documento">
            </div>
            <div class="featured-svc-content">
                <h3 class="featured-svc-title">Certificación de partidas</h3>
                <p class="featured-svc-subtitle">Ciudadano</p>
                <p class="featured-svc-desc">Documento emitido por la alcaldía municipal que certifica la o las partidas que se encontraron con los datos proporcionados para la búsqueda en los sistemas que esta institución administra.</p>
            </div>
            <div>
                <a href="views/login.php" class="btn-featured">Iniciar trámite</a>
            </div>
        </div>

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
                <h3>Duplicado y reposición</h3>
            </div>
            <div class="svc">
                <div class="svc-ico"><i class="fas fa-magnifying-glass"></i></div>
                <h3>Consultas de trámite</h3>
                <p>Revisa el estado de tu solicitud en tiempo real con tu número de referencia.</p>
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
        <img src="assets/Img/MUNIFY.jpeg" alt="Logo" onerror="this.style.display='none'">
        <span>Alcaldía Municipal — MUNIFY</span>
    </div>
    <div class="fl">
        <a href="#nosotros">Institución</a>
        <a href="#servicios">Servicios</a>
        <a href="#ubicacion">Contacto</a>
        <a href="views/login.php">Sistema</a>
    </div>
    <p class="copy">&copy; <?= date('Y') ?> Alcaldía Municipal. Todos los derechos reservados.</p>
</footer>

<script src="assets/Js/principal.js"></script>

</body>
</html>


