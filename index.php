<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alcaldía Municipal — MUNIFY</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/Css/footer.css">
        <style>
        :root {
            --color-1: #1C3166;
            --color-2: #FFFFFF;
            --color-3: #FFFFFF;
            --color-4: #000000;
            --color-5: #FFFFFF;
            --color-6: #1C3166;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; width: 100%; overflow-x: clip; }
        body { width: 100%; min-width: 0; font-family: 'Poppins', sans-serif; background: var(--color-5); color: var(--color-4); overflow-x: hidden; }
        img, iframe { max-width: 100%; }

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
        }
        .nav-logo img { width: 100%; height: auto; object-fit: contain; }
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
        .nav-links a:not(.btn-login):not(.btn-ghost):hover { color: var(--color-3); text-shadow: 0 0 8px rgba(255,255,255,0.5); }
        .btn-login {
            background: var(--color-3) !important;
            color: var(--color-1) !important;
            padding: 0.48rem 1.4rem; border-radius: 50px;
            font-size: 0.82rem !important; font-weight: 700 !important;
            letter-spacing: 0.04em; transition: all 0.25s !important;
        }
        .btn-login:hover { background: var(--color-2) !important; color: var(--color-1) !important; }
        .hamburger { display: none; background: none; border: none; color: var(--color-3); font-size: 1.3rem; cursor: pointer; }

        /* ══════════════ USER DROPDOWN ══════════════ */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }
        .nav-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #ffffff;
            min-width: 150px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.15);
            border-radius: 8px;
            z-index: 400;
            overflow: hidden;
            margin-top: 5px;
            border: 1px solid rgba(0,0,0,0.08);
            text-align: left;
        }
        .nav-dropdown.active .nav-dropdown-content {
            display: block;
        }
        .nav-dropdown-content a {
            color: #333 !important;
            padding: 10px 16px !important;
            text-decoration: none;
            display: flex !important;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            transition: background-color 0.2s;
            text-shadow: none !important;
        }
        .nav-dropdown-content a:hover {
            background-color: #f0f4ff !important;
            color: var(--color-1) !important;
        }
        .nav-username {
            color: rgba(255,255,255,0.95);
            font-size: 0.84rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            gap: 6px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        /* ══════════════ HERO ══════════════ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex; align-items: center;
            overflow: hidden;
            background-color: var(--color-1);
            background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
        }

        /* Efecto de malla luminosa simplificado para estilo flat */
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(to right, rgba(28, 49, 102, 0.95) 0%, rgba(28, 49, 102, 0.4) 100%);
            z-index: 0;
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
        .hero-left { flex: 1; min-width: 0; }

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
            font-style: italic; color: #FFFFFF;
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
        .btn-cta:hover { background: var(--color-2) !important; color: var(--color-1) !important; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }

        .btn-ghost {
            background: rgba(255,255,255,0.1); color: #fff;
            border: 1px solid rgba(255,255,255,0.3); padding: 0.9rem 1.6rem;
            border-radius: 50px; font-family: 'Poppins', sans-serif; font-size: 0.85rem;
            cursor: pointer; text-decoration: none; font-weight: 600;
            display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.25s; backdrop-filter: blur(6px);
        }
        .btn-ghost:hover { border-color: var(--color-3) !important; background: var(--color-3) !important; color: var(--color-1) !important; }

        /* Tarjeta flotante */
        .hero-card {
            background: #ffffff;
            border-radius: 16px; padding: 2.5rem 2rem;
            width: 380px; flex-shrink: 0; color: var(--color-4);
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            animation: up 0.7s 0.45s ease both;
            border-bottom: 4px solid var(--color-2);
            text-align: center;
        }
        .hc-icon {
            width: 80px; height: 80px; background: rgba(28, 49, 102, 0.1);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 2.5rem; color: var(--color-1);
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 15px rgba(28, 49, 102, 0.15);
        }
        .hero-card h3 { font-size: 1.25rem; font-weight: 700; color: var(--color-1); margin-bottom: 0.5rem; }
        .hero-card p { font-size: 0.88rem; color: #666; line-height: 1.65; margin-bottom: 1.5rem; }
        .hc-pills { display: flex; flex-wrap: wrap; gap: 0.6rem; justify-content: center; }
        .hc-pill {
            background: var(--color-1); color: #ffffff;
            border-radius: 50%; 
            width: 46px;
            height: 46px;
            font-size: 0.78rem; font-weight: 600;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 10px rgba(28, 49, 102, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            overflow: hidden;
            white-space: nowrap;
        }
        .hc-pill:hover { 
            transform: translateY(-2px); 
            background: var(--color-2); 
            color: var(--color-1);
            width: 150px;
            border-radius: 50px;
        }
        .hc-pill i { font-size: 0.95rem; }
        .hc-pill .pill-text {
            max-width: 0;
            opacity: 0;
            display: inline-block;
            transition: max-width 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            vertical-align: middle;
            overflow: hidden;
        }
        .hc-pill:hover .pill-text {
            max-width: 120px;
            opacity: 1;
            margin-left: 0.5rem;
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
        .sep span { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.2em; color: var(--color-2); text-transform: uppercase; white-space: nowrap; text-align: center; }

        section { position: relative; z-index: 10; }
        .si { max-width: 1040px; margin: 0 auto; padding: 5.5rem 2rem; }
        .stag { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: var(--color-2); margin-bottom: 0.4rem; }
        .sh { font-family: 'Playfair Display', serif; font-size: clamp(2rem,3vw,2.6rem); font-weight: 700; color: var(--color-1); margin-bottom: 1rem; }
        .sb { font-size: 0.95rem; font-weight: 400; color: #1c3166; line-height: 1.8; max-width: 600px; opacity: 0.9; }

        /* ══════════════ QUIÉNES SOMOS ══════════════ */
        .about-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 2.5rem; align-items: stretch; margin-top: 3rem; }
        .vals { display: flex; flex-direction: column; gap: 0.6rem; margin-top: 1.2rem; }
        .val { display: flex; align-items: center; gap: 0.8rem; background: #ffffff; border: 1px solid #E2E8F0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); border-radius: 8px; padding: 0.6rem 1rem; transition: all 0.2s; }
        .val:hover { border-color: var(--color-1); box-shadow: 0 6px 12px rgba(28, 49, 102, 0.08); transform: translateX(4px); }
        .vi { width: 36px; height: 36px; flex-shrink: 0; background: #f0f4ff; border: 1px solid #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--color-1); font-size: 1rem; }
        .val h4 { font-size: 0.8rem; font-weight: 700; color: var(--color-1); margin-bottom: 0.1rem; }
        .val p { font-size: 0.72rem; color: #333; line-height: 1.4; }

        .about-image-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border: 3px solid var(--color-3);
            height: 100%;
        }
        .about-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .about-image-wrapper:hover .about-img {
            transform: scale(1.05);
        }

        /* ══════════════ SERVICIOS ══════════════ */
        .svc-section { background: rgba(28, 49, 102, 0.03); border-top: 1px solid rgba(0,0,0,0.05); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .svc-grid { display: grid; grid-template-columns: repeat(auto-fit,minmax(240px,1fr)); gap: 1.5rem; margin-top: 3rem; }
        .svc { background: #ffffff; border: 1px solid #E2E8F0; border-radius: 14px; padding: 2rem 1.8rem; transition: all 0.3s; position: relative; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        .svc::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: var(--color-2); transform: scaleX(0); transition: transform 0.3s; transform-origin: left; }
        .svc:hover { border-color: var(--color-1); transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .svc:hover::after { transform: scaleX(1); }
        .svc-ico { width: 56px; height: 56px; background: #f0f4ff; border: 1px solid #e0e7ff; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: var(--color-1); font-size: 1.5rem; margin-bottom: 1.2rem; }
        .svc h3 { font-size: 1.05rem; font-weight: 700; color: var(--color-1); margin-bottom: 0.6rem; }
        .svc p { font-size: 0.85rem; color: #666; line-height: 1.65; }

        /* ══════════════ SERVICIO DESTACADO ══════════════ */
        .featured-svc {
            display: flex; align-items: center; justify-content: space-between; gap: 2.5rem;
            background: var(--color-1);
            border-radius: 16px; padding: 2.5rem; margin: 2rem 0 3rem;
            box-shadow: 0 15px 35px rgba(28, 49, 102, 0.15);
        }
        .featured-svc-img {
            flex-shrink: 0; width: 220px; height: 220px; border-radius: 12px;
            overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .featured-svc-img img { width: 100%; height: 100%; object-fit: cover; }
        .featured-svc-content { flex: 1; min-width: 0; }
        .featured-svc-title { font-size: 2rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem; font-family: 'Poppins', sans-serif; }
        .featured-svc-subtitle { font-size: 0.9rem; color: #FFFFFF; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.2rem; }
        .featured-svc-desc { font-size: 0.95rem; color: rgba(255,255,255,0.9); line-height: 1.7; max-width: 650px; }
        .btn-featured {
            background: #ffffff; color: var(--color-1); padding: 0.9rem 2rem; border-radius: 50px;
            font-weight: 700; text-decoration: none; display: inline-flex; align-items: center;
            gap: 0.5rem; transition: all 0.25s; white-space: nowrap; font-size: 0.95rem;
        }
        .btn-featured:hover { background: #f0f0f0; color: var(--color-1); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        
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
        .ii { width: 44px; height: 44px; flex-shrink: 0; background: rgba(0, 0, 0, 0.05); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--color-1); font-size: 1.2rem; }
        .ir h4 { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-1); margin-bottom: 0.25rem; }
        .ir p { font-size: 0.9rem; color: #1c3166; line-height: 1.5; opacity: 0.85; }
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
        .copy { font-size: 0.8rem; color: rgba(255,255,255,0.5); text-align: center; margin: 0; }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 900px) {
            .hero-card { display: none; }
            .hero-inner { justify-content: flex-start; }
        }
        @media (max-width: 680px) {
            nav { padding: 0.9rem 1.25rem; }
            .nav-links { display: none; position: absolute; top: 100%; left: 0; right: 0; width: 100%; flex-direction: column; align-items: flex-start; background: var(--color-1); padding: 1.25rem; gap: 1.2rem; border-bottom: 3px solid var(--color-2); }
            .nav-links.open { display: flex; }
            .nav-links a, .nav-dropdown, .nav-username { max-width: 100%; }
            .hamburger { display: block; color: #ffffff; }
            .hero-inner { padding: 7rem 1.25rem 4rem; }
            .hero-badge { max-width: 100%; white-space: normal; border-radius: 18px; line-height: 1.5; }
            .hero-title { font-size: 2.25rem; overflow-wrap: anywhere; }
            .hero-sub { font-size: 0.98rem; }
            .si { padding: 4rem 1.25rem; }
            .sep { padding: 0 1.25rem; }
            .sep span { white-space: normal; letter-spacing: 0.14em; line-height: 1.4; }
            .about-grid, .loc-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .stats-vis { order: -1; }
            .featured-svc { padding: 1.5rem; gap: 1.5rem; }
            .featured-svc-title { font-size: 1.65rem; }
            .featured-svc > div:last-child, .btn-featured { width: 100%; justify-content: center; text-align: center; white-space: normal; }
            .svc-grid { grid-template-columns: minmax(0, 1fr); }
            .ir { padding: 1rem; }
            .sched { justify-content: center; }
            .sd-line { display: none; }
            .social-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.8rem; }
            .soc { min-width: 0; padding: 1.25rem 0.75rem; }
            footer { width: 100%; padding: 2.25rem 1.25rem !important; flex-direction: column; align-items: stretch !important; }
            footer .footer-left { width: 100%; gap: 1rem !important; flex-direction: column; align-items: flex-start !important; }
            footer .fl { width: 100%; flex-wrap: wrap; gap: 1rem !important; }
            .copy { text-align: left; border-left: 0 !important; padding-left: 0 !important; }
            .footer-developer { max-width: 100%; }
            .footer-developer-brand { flex-wrap: wrap; }
            .co-panel { width: min(400px, 100vw); right: -100vw; }
        }

        @media (max-width: 420px) {
            nav { padding: 0.8rem 1rem; }
            .hero-inner { padding: 6.5rem 1rem 4rem; }
            .hero-title { font-size: 2rem; }
            .btn-cta { width: 100%; justify-content: center; padding-inline: 1.25rem; }
            .si { padding: 3.5rem 1rem; }
            .featured-svc { padding: 1.1rem; border-radius: 12px; }
            .featured-svc-img { height: 210px; }
            .featured-svc-title { font-size: 1.4rem; }
            .social-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="#" class="nav-brand">
        <img src="assets/Img/logo_munify/logo_negativo.png?v=<?= time() ?>" alt="Munify Logo" style="height: 45px; width: auto;">
    </a>
    <button class="hamburger" id="hamburger-btn" aria-label="Menú">
        <i class="fas fa-bars" id="ham-icon"></i>
    </button>
    <div class="nav-links" id="nav-menu">
        <a href="#nosotros">Inicio</a>
        <a href="#servicios">Servicios</a>
        <a href="#nosotros">Nosotros</a>
        <a href="#ubicacion">Contacto</a>
        
        <?php if (isset($_SESSION['usuario'])): ?>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                <a href="views/dashboard.php" class="btn-ghost" style="padding: 0.48rem 1.4rem; font-size: 0.82rem;"><i class="bi bi-speedometer2" style="margin-right: 5px;"></i> Dashboard</a>
            <?php else: ?>
                <a href="views/SolicitudCitas.php" class="btn-ghost" style="padding: 0.48rem 1.4rem; font-size: 0.82rem;"><i class="bi bi-calendar-plus" style="margin-right: 5px;"></i> Solicitar Cita</a>
            <?php endif; ?>
            
            <div class="nav-dropdown" style="margin-left: 1rem;">
                <a href="javascript:void(0)" class="nav-username" style="text-decoration: none; display: flex; align-items: center; gap: 8px;" onclick="event.stopPropagation(); this.parentElement.classList.toggle('active')">
                    <i class="bi bi-person-circle" style="font-size: 1.1rem; color: #fff;"></i>
                    <strong style="color: #fff; font-weight: 600; font-size: 0.85rem;"><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>
                    <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: rgba(255,255,255,0.7);"></i>
                </a>
                <div class="nav-dropdown-content">
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                        <a href="views/perfil.php"><i class="bi bi-person-badge"></i> Perfil</a>
                    <?php else: ?>
                        <a href="javascript:void(0)" onclick="verPerfilCiudadano()"><i class="bi bi-person-badge"></i> Perfil</a>
                    <?php endif; ?>
                    <a href="controller/logout.php" style="border-top: 1px solid rgba(0,0,0,0.06); color: #dc3545 !important;"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
                </div>
            </div>
        <?php else: ?>
            <a href="javascript:void(0)" onclick="requerirLogin()" class="btn-ghost" style="padding: 0.48rem 1.4rem; font-size: 0.82rem;"><i class="bi bi-calendar-plus" style="margin-right: 5px;"></i> Solicitar Cita</a>
            <a href="views/login.php" class="btn-login">Iniciar Sesión</a>
        <?php endif; ?>
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
            </div>
        </div>

        <!-- Tarjeta flotante -->
        <div class="hero-card">
            <div class="hc-icon"><i class="fas fa-fingerprint"></i></div>
            <h3>Gestión con identidad</h3>
            <p>Documentos oficiales para cada ciudadano, con atención ágil y proceso 100% verificado por la alcaldía.</p>
            <div class="hc-pills">
                <span class="hc-pill"><i class="fas fa-baby"></i><span class="pill-text">Nacimiento</span></span>
                <span class="hc-pill"><i class="fas fa-id-card-clip"></i><span class="pill-text">Minoridad</span></span>
                <span class="hc-pill"><i class="fas fa-file-contract"></i><span class="pill-text">Defunción</span></span>
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
                        <div class="vi"><i class="fas fa-eye"></i></div>
                        <div><h4>Transparencia</h4><p>Cada trámite gestionado con honestidad y rendición de cuentas a los ciudadanos.</p></div>
                    </div>
                    <div class="val">
                        <div class="vi"><i class="fas fa-hand-holding-heart"></i></div>
                        <div><h4>Servicio ciudadano</h4><p>El ciudadano es el centro de todo lo que hacemos. Su tiempo y dignidad importan.</p></div>
                    </div>
                    <div class="val">
                        <div class="vi"><i class="fas fa-laptop-code"></i></div>
                        <div><h4>Eficiencia digital</h4><p>Procesos de trámites municipales presenciales.</p></div>
                    </div>
                </div>
            </div>
            <div class="stats-vis">
                <div class="about-image-wrapper">
                    <img src="assets/Img/compromiso.png" alt="Compromiso Municipal" class="about-img">
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
                        <p>Carretera a Ilobasco, Km. 51 1/2, Cantón Agua Zarca, Cabañas.</p>
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
                        <div class="sd-time">8:00 a.m. — 4:00 p.m.</div>
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

            <!-- Mapa de la Universidad Católica de El Salvador | Ilobasco -->
            <div class="map-box">
                <iframe
                    src="https://maps.google.com/maps?q=Universidad%20Cat%C3%B3lica%20de%20El%20Salvador%20Ilobasco&t=&z=16&ie=UTF8&iwloc=&output=embed"
                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="width: 100%; height: 100%; border: 0;">
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
            <a href="https://facebook.com/" target="_blank" class="soc" style="--c:#1C3166">
                <i class="fab fa-facebook-f"></i><span>Facebook</span>
            </a>
            <a href="https://instagram.com/" target="_blank" class="soc" style="--c:#000000">
                <i class="fab fa-instagram"></i><span>Instagram</span>
            </a>
            <a href="https://twitter.com/" target="_blank" class="soc" style="--c:#1C3166">
                <i class="fab fa-x-twitter"></i><span>Twitter / X</span>
            </a>
            <a href="https://wa.me/50300000000" target="_blank" class="soc" style="--c:#000000">
                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="munify-footer" style="padding: 2rem 4rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 2rem;">
    <div class="footer-left" style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
        <div class="fb">
            <img src="assets/Img/logo_munify/logo_negativo.png" alt="Munify Logo" style="height: 35px; width: auto;">
        </div>
        <p class="copy" style="font-size: 0.8rem; color: rgba(255,255,255,0.5); margin: 0; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 2rem;">&copy; <?= date('Y') ?> Alcaldía Municipal. Todos los derechos reservados.</p>
    </div>

    <div class="fl" style="display: flex; gap: 2rem;">
        <a href="#nosotros">Institución</a>
        <a href="#servicios">Servicios</a>
        <a href="#ubicacion">Contacto</a>
    </div>

    <div class="footer-developer" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onclick="openBlackRose()">
      <span class="footer-developer-text">Desarrollado por</span>
      <div class="footer-developer-brand">
        <img src="assets/Img/BlackRoseSystems.png" alt="Blackrose Logo" class="footer-developer-logo">
        <span class="footer-developer-name">BlackRose Systems</span>
      </div>
    </div>
    
    <!-- PANEL BLACKROSE (CUSTOM OFFCANVAS) -->
    <style>
    .co-backdrop { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 9998; opacity: 0; visibility: hidden; transition: all 0.3s ease; }
    .co-backdrop.show { opacity: 1; visibility: visible; }
    .co-panel { position: fixed; top: 0; right: -450px; width: 400px; max-width: 100%; height: 100vh; background: #fff; z-index: 9999; box-shadow: -5px 0 30px rgba(0,0,0,0.15); transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; font-family: 'Poppins', sans-serif; }
    .co-panel.show { right: 0; }
    .co-header { background: #1C3166; color: white; padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .co-title { font-size: 1.1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 10px; }
    .co-close { background: none; border: none; color: white; font-size: 1.8rem; cursor: pointer; opacity: 0.8; transition: opacity 0.2s; line-height: 1; padding: 0; }
    .co-close:hover { opacity: 1; }
    .co-body { padding: 2rem; overflow-y: auto; text-align: center; }
    </style>

    <div class="co-backdrop" id="coBackdrop" onclick="closeBlackRose()"></div>
    <div class="co-panel" id="coPanelBlackRose">
        <div class="co-header">
            <h5 class="co-title"><i class="bi bi-code-slash"></i> Desarrolladores</h5>
            <button class="co-close" onclick="closeBlackRose()">&times;</button>
        </div>
        <div class="co-body">
            <div style="display: inline-block; margin-bottom: 1.5rem;">
                <img src="assets/Img/BlackRoseSystems.png" alt="BlackRose Systems" style="width: 140px; height: auto;">
            </div>
            
            <h3 style="color: #1C3166; font-weight: 800; font-size: 1.4rem; margin-bottom: 5px;">BlackRose Systems</h3>
            <p style="color: #666; font-weight: 500; font-size: 0.9rem; margin-bottom: 2rem;">Agencia de Ingeniería y Soluciones de Software</p>
            
            <div style="text-align: left; background: #f8f9fa; border: 1px solid #edf1f7; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                <p style="color: #444; font-size: 0.88rem; line-height: 1.6; margin-bottom: 15px;">
                    Somos un equipo de desarrolladores apasionados por crear ecosistemas tecnológicos escalables, innovadores y de alto rendimiento.
                </p>
                <p style="color: #444; font-size: 0.88rem; line-height: 1.6; margin-bottom: 0;">
                    Nos especializamos en la modernización digital, arquitecturas web seguras y soluciones a medida que transforman instituciones y conectan a la comunidad.
                </p>
            </div>
            
            <div style="background: rgba(28, 49, 102, 0.05); border: 1px dashed rgba(28, 49, 102, 0.2); border-radius: 8px; padding: 15px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="bi bi-gear-wide-connected" style="color: #1C3166; font-size: 1.2rem;"></i>
                <span style="color: #1C3166; font-weight: 700; font-size: 0.85rem; text-transform: uppercase;">Transformando ideas en código</span>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/Js/principal.js"></script>
<script>
function requerirLogin() {
    Swal.fire({
        title: 'Acceso Restringido',
        text: 'Debes iniciar sesión para poder solicitar una cita con la Alcaldía.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1C3166',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ir a Iniciar Sesión',
        cancelButtonText: 'Cerrar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'views/login.php';
        }
    });
}

function verPerfilCiudadano() {
    const nombre = <?php echo isset($_SESSION['usuario']) ? json_encode($_SESSION['usuario']) : '""'; ?>;
    const correo = <?php echo isset($_SESSION['correo']) ? json_encode($_SESSION['correo']) : '"usuario@munify.gob.sv"'; ?>;
    
    Swal.fire({
        html: `
            <div style="text-align: center; font-family: 'Poppins', sans-serif; padding-top: 15px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #1C3166 0%, #2A488E 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 15px; box-shadow: 0 4px 10px rgba(28, 49, 102, 0.2);">
                    <i class="bi bi-person"></i>
                </div>
                <h3 style="margin-bottom: 5px; color: #1C3166; font-weight: 700;">${nombre}</h3>
                <p style="color: #666; margin-bottom: 20px; font-size: 0.9rem;"><i class="bi bi-envelope"></i> ${correo}</p>
                <div style="background: rgba(28, 49, 102, 0.05); border: 1px solid rgba(28, 49, 102, 0.1); border-radius: 8px; padding: 8px 15px; display: inline-block;">
                    <span style="color: #1C3166; font-weight: 600; font-size: 0.9rem;"><i class="bi bi-shield-check" style="margin-right:5px;"></i> Ciudadano Registrado</span>
                </div>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonColor: '#1C3166',
        confirmButtonText: 'Cerrar',
        width: '400px',
        padding: '2em'
    });
}

function openBlackRose() {
    document.getElementById('coBackdrop').classList.add('show');
    document.getElementById('coPanelBlackRose').classList.add('show');
    document.body.style.overflow = 'hidden'; // Evita scroll
}

function closeBlackRose() {
    document.getElementById('coBackdrop').classList.remove('show');
    document.getElementById('coPanelBlackRose').classList.remove('show');
    document.body.style.overflow = 'auto';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.nav-dropdown')) {
        document.querySelectorAll('.nav-dropdown').forEach(d => d.classList.remove('active'));
    }
});
</script>

</body>
</html>


