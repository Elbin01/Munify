<?php
session_start();
// Solo permitir acceso si está logeado como Secretario/a (Rol 1) por seguridad de desarrollo
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Munify – Visor de Alertas</title>
  <!-- Google Fonts: Outfit & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <style>
    :root {
      --primary: #1C3166;
      --primary-light: #2A488E;
      --bg-dark: #0A0F1D;
      --card-bg: rgba(20, 28, 48, 0.65);
      --border-color: rgba(255, 255, 255, 0.08);
      --neon-glow: rgba(42, 72, 142, 0.25);
      --text-white: #FFFFFF;
      --text-gray: #9BA4B5;
      
      --color-success: #198754;
      --color-warning: #ffc107;
      --color-danger: #dc3545;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top right, #111A30 0%, var(--bg-dark) 100%);
      color: var(--text-white);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      overflow-x: hidden;
    }

    /* ── Contenedor Glassmorphism ── */
    .container {
      width: 100%;
      max-width: 820px;
      background: var(--card-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 2.5rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.05);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      gap: 1.8rem;
    }

    .container::before {
      content: '';
      position: absolute;
      top: -150px;
      right: -150px;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, var(--neon-glow) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    header {
      text-align: center;
      z-index: 1;
    }

    header h1 {
      font-family: 'Outfit', sans-serif;
      font-size: 2.2rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      background: linear-gradient(135deg, #FFF 30%, #A5C0FF 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 0.5rem;
    }

    header p {
      font-size: 0.95rem;
      color: var(--text-gray);
      font-weight: 300;
    }

    /* ── Controles de Filtro (Estilo creador de firmas) ── */
    .controls {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      align-items: center;
      justify-content: space-between;
      z-index: 1;
      background: rgba(255, 255, 255, 0.02);
      padding: 1rem 1.5rem;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .control-group {
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }

    .control-label {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--text-gray);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .filter-pills {
      display: flex;
      gap: 0.4rem;
      flex-wrap: wrap;
    }

    .filter-pill-btn {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      color: var(--text-gray);
      padding: 0.4rem 0.9rem;
      border-radius: 50px;
      font-size: 0.72rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .filter-pill-btn:hover {
      background: rgba(255, 255, 255, 0.1);
      color: var(--text-white);
    }

    .filter-pill-btn.active {
      background: var(--primary-light);
      border-color: #5879C7;
      color: var(--text-white);
      box-shadow: 0 0 12px rgba(42, 72, 142, 0.4);
    }

    /* ── Muro de Botones de Alertas ── */
    .alert-buttons-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1rem;
      z-index: 1;
      max-height: 260px;
      overflow-y: auto;
      padding-right: 6px;
    }

    /* Scrollbar personalizada al estilo firmas */
    .alert-buttons-grid::-webkit-scrollbar {
      width: 6px;
    }
    .alert-buttons-grid::-webkit-scrollbar-track {
      background: rgba(255,255,255,0.01);
    }
    .alert-buttons-grid::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.1);
      border-radius: 10px;
    }

    .alert-btn {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: 14px;
      padding: 1rem;
      color: var(--text-white);
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      text-align: left;
      position: relative;
    }

    .alert-btn:hover {
      transform: translateY(-3px);
      background: rgba(255, 255, 255, 0.07);
      border-color: rgba(255, 255, 255, 0.15);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .alert-btn.active {
      background: rgba(42, 72, 142, 0.15);
      border-color: var(--primary-light);
      box-shadow: 0 0 15px var(--neon-glow);
    }

    .btn-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }

    .btn-icon {
      font-size: 1.1rem;
    }

    .btn-badge {
      font-size: 0.6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 0.15rem 0.4rem;
      border-radius: 4px;
    }

    .badge-toast { background: rgba(25, 135, 84, 0.2); color: #2cd182; border: 1px solid rgba(25, 135, 84, 0.3); }
    .badge-modal { background: rgba(13, 110, 253, 0.2); color: #5aa0ff; border: 1px solid rgba(13, 110, 253, 0.3); }

    .btn-label {
      font-size: 0.78rem;
      font-weight: 500;
      color: var(--text-gray);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      width: 100%;
    }

    /* Colores de Iconos por Tipo */
    .icon-success { color: #2cd182; }
    .icon-warning { color: #ffc107; }
    .icon-danger { color: #ff6b6b; }

    /* ── Ficha Técnica / Consola de Visualización ── */
    .viewfinder {
      background: rgba(5, 8, 16, 0.95);
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: 18px;
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
      z-index: 1;
      box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.8);
    }

    .viewfinder-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      padding-bottom: 0.6rem;
    }

    .terminal-title {
      font-family: 'Outfit', sans-serif;
      font-size: 0.85rem;
      font-weight: 600;
      color: #A5C0FF;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .terminal-title i {
      font-size: 0.9rem;
      animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 0.5; }
      50% { opacity: 1; }
    }

    .terminal-dots {
      display: flex;
      gap: 5px;
    }

    .dot {
      width: 8px; height: 8px;
      border-radius: 50%;
    }
    .dot-red { background: #ff6b6b; }
    .dot-yellow { background: #ffc107; }
    .dot-green { background: #2cd182; }

    .terminal-body {
      display: flex;
      flex-direction: column;
      gap: 0.9rem;
    }

    .term-row {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .term-label {
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--text-gray);
    }

    .term-value {
      font-size: 0.84rem;
      font-weight: 400;
      color: var(--text-white);
      line-height: 1.5;
    }

    .term-value code {
      background: rgba(255, 255, 255, 0.06);
      padding: 0.15rem 0.5rem;
      border-radius: 6px;
      color: #A5C0FF;
      font-family: monospace;
      font-size: 0.8rem;
    }

    .term-value.glowing-green { color: #2cd182; text-shadow: 0 0 8px rgba(44, 209, 130, 0.4); }
    .term-value.glowing-warning { color: #ffc107; text-shadow: 0 0 8px rgba(255, 193, 7, 0.4); }
    .term-value.glowing-danger { color: #ff6b6b; text-shadow: 0 0 8px rgba(255, 107, 107, 0.4); }

    /* Botones de Navegación */
    .navigation-links {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      z-index: 1;
    }

    .nav-btn {
      color: var(--text-gray);
      text-decoration: none;
      font-size: 0.85rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
      opacity: 0.8;
    }

    .nav-btn:hover {
      color: var(--text-white);
      opacity: 1;
      transform: translateX(-2px);
    }
  </style>
</head>
<body>

  <div class="container">
    <header>
      <h1>Munify – Visor de Alertas</h1>
      <p>Catálogo de notificaciones, advertencias y SweetAlerts del ecosistema municipal.</p>
    </header>

    <!-- Filtros de Módulo (Estilo Creador de Firmas) -->
    <div class="controls">
      <div class="control-group">
        <span class="control-label">Módulo Activo</span>
        <div class="filter-pills" id="filterContainer">
          <button class="filter-pill-btn active" onclick="filtrarModulo('todos')">Todos</button>
          <button class="filter-pill-btn" onclick="filtrarModulo('citas')">Citas</button>
          <button class="filter-pill-btn" onclick="filtrarModulo('login')">Login</button>
          <button class="filter-pill-btn" onclick="filtrarModulo('partidas')">Partidas</button>
          <button class="filter-pill-btn" onclick="filtrarModulo('minoridad')">Minoridad</button>
          <button class="filter-pill-btn" onclick="filtrarModulo('defuncion')">Defunciones</button>
        </div>
      </div>
    </div>

    <!-- Rejilla de Botones de Alerta -->
    <div class="alert-buttons-grid" id="alertGrid">

      <!-- BOTON 1 -->
      <button class="alert-btn active" data-modulo="citas" data-type="toast" data-icon="bi-telephone-x icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="Por favor, ingrese un número de teléfono válido (0000-0000)." data-file="views/SolicitudCitas.php:384" data-trigger="Al escribir un teléfono sin el formato oficial de 8 dígitos y guion intermedio." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-telephone-x icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Teléfono Inválido</div>
      </button>

      <!-- BOTON 2 -->
      <button class="alert-btn" data-modulo="citas" data-type="toast" data-icon="bi-calendar-x icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="Las citas solo están disponibles de Lunes a Viernes." data-file="views/SolicitudCitas.php:391" data-trigger="Al intentar seleccionar un día Sábado o Domingo para agendar un trámite oficial." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-calendar-x icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Cita Fin de Semana</div>
      </button>

      <!-- BOTON 3 -->
      <button class="alert-btn" data-modulo="citas" data-type="toast" data-icon="bi-clock-history icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="El horario de atención es de 8:00 AM a 4:00 PM." data-file="views/SolicitudCitas.php:398" data-trigger="Al intentar programar la cita fuera del horario institucional oficial (08:00 - 16:00)." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-clock-history icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Horario Inválido</div>
      </button>

      <!-- BOTON 4 -->
      <button class="alert-btn" data-modulo="login" data-type="modal" data-icon="bi-check2-circle icon-success" data-badge="SweetAlert" data-badgestyle="badge-modal" data-message="¡Bienvenido/a al sistema!" data-file="views/login.php:156" data-trigger="Al digitar de forma correcta las credenciales administrativas de acceso." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-check2-circle icon-success btn-icon"></i>
          <span class="btn-badge badge-modal">SweetAlert</span>
        </div>
        <div class="btn-label">Login Exitoso</div>
      </button>

      <!-- BOTON 5 -->
      <button class="alert-btn" data-modulo="login" data-type="modal" data-icon="bi-shield-x icon-danger" data-badge="SweetAlert" data-badgestyle="badge-modal" data-message="Usuario o contraseña incorrectos." data-file="views/login.php:169" data-trigger="Al ingresar credenciales inexistentes o inválidas en la pantalla de inicio de sesión." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-shield-x icon-danger btn-icon"></i>
          <span class="btn-badge badge-modal">SweetAlert</span>
        </div>
        <div class="btn-label">Acceso Denegado</div>
      </button>

      <!-- BOTON 6 -->
      <button class="alert-btn" data-modulo="partidas" data-type="toast" data-icon="bi-exclamation-triangle icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="Los campos Nombres y Apellidos son obligatorios." data-file="assets/js/recepcion_partida.js:133" data-trigger="Al intentar guardar un registro de nacimiento sin rellenar los datos de identidad primarios." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-exclamation-triangle icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Campos Vacíos</div>
      </button>

      <!-- BOTON 7 -->
      <button class="alert-btn" data-modulo="partidas" data-type="toast" data-icon="bi-credit-card-2-front icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="DUI inválido" data-file="assets/js/recepcion_partida.js:186" data-trigger="Al consultar un DUI de padre/madre/tutor con formato incorrecto o menor a 10 dígitos." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-credit-card-2-front icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">DUI Inválido</div>
      </button>

      <!-- BOTON 8 -->
      <button class="alert-btn" data-modulo="partidas" data-type="toast" data-icon="bi-person-x icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="Padre no encontrado" data-file="assets/js/recepcion_partida.js:197" data-trigger="La base de datos municipal no arroja ningún registro coincidente con el DUI consultado." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-person-x icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Padre Inexistente</div>
      </button>

      <!-- BOTON 9 -->
      <button class="alert-btn" data-modulo="partidas" data-type="toast" data-icon="bi-person-slash icon-danger" data-badge="Toast" data-badgestyle="badge-toast" data-message="Error: No se ha seleccionado un ciudadano." data-file="assets/js/recepcion_partida.js:226" data-trigger="Intentar guardar o emitir la partida física sin elegir previamente a un infante de la búsqueda." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-person-slash icon-danger btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Sin Ciudadano</div>
      </button>

      <!-- BOTON 10 -->
      <button class="alert-btn" data-modulo="minoridad" data-type="toast" data-icon="bi-calendar-range icon-danger" data-badge="Toast" data-badgestyle="badge-toast" data-message="Error: El ciudadano registrado debe ser menor de 18 años para emitir un carnet de minoridad." data-file="assets/js/recepcion_minoridad.js:212" data-trigger="La fecha de nacimiento calculada del infante a registrar arroja una edad igual o superior a 18 años." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-calendar-range icon-danger btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Mayor de Edad</div>
      </button>

      <!-- BOTON 11 -->
      <button class="alert-btn" data-modulo="minoridad" data-type="toast" data-icon="bi-check2-all icon-success" data-badge="Toast" data-badgestyle="badge-toast" data-message="Expediente de minoridad guardado correctamente." data-file="assets/js/recepcion_minoridad.js:266" data-trigger="Al guardar con éxito la asociación del menor con su respectivo tutor en la base de datos." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-check2-all icon-success btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Expediente Guardado</div>
      </button>

      <!-- BOTON 12 -->
      <button class="alert-btn" data-modulo="defuncion" data-type="toast" data-icon="bi-exclamation-octagon icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="Por favor ingrese un DUI válido (00000000-0)" data-file="assets/js/recepcion_defuncion.js:56" data-trigger="Al escribir un DUI en formato incorrecto al registrar el deceso del ciudadano." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-exclamation-octagon icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">DUI Fallecido Malo</div>
      </button>

      <!-- BOTON 13 -->
      <button class="alert-btn" data-modulo="defuncion" data-type="toast" data-icon="bi-bookmark-check icon-success" data-badge="Toast" data-badgestyle="badge-toast" data-message="Acta de defunción guardada correctamente." data-file="assets/js/recepcion_defuncion.js:208" data-trigger="Al procesar, asociar la causa de defunción y guardar exitosamente el acta en los servidores." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-bookmark-check icon-success btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Acta Guardada</div>
      </button>

      <!-- BOTON 14 -->
      <button class="alert-btn" data-modulo="citas" data-type="toast" data-icon="bi-card-checklist icon-warning" data-badge="Toast" data-badgestyle="badge-toast" data-message="Por favor, seleccione al menos una cita pendiente." data-file="assets/js/recepcion_citas.js:86" data-trigger="Intentar realizar una acción masiva en citas (aprobar/denegar) sin marcar ninguna casilla de verificación." onclick="seleccionarAlerta(this)">
        <div class="btn-header">
          <i class="bi bi-card-checklist icon-warning btn-icon"></i>
          <span class="btn-badge badge-toast">Toast</span>
        </div>
        <div class="btn-label">Sin Cita Marcada</div>
      </button>

    </div>

    <!-- Ficha Técnica / Consola de Visualización de Alertas (Terminal oscura) -->
    <div class="viewfinder">
      <div class="viewfinder-header">
        <div class="terminal-title">
          <i class="bi bi-cpu"></i> Ficha Técnica e Interacción en Vivo
        </div>
        <div class="terminal-dots">
          <div class="dot dot-red"></div>
          <div class="dot dot-yellow"></div>
          <div class="dot dot-green"></div>
        </div>
      </div>
      <div class="terminal-body" id="termBody">
        <div class="term-row">
          <span class="term-label">📍 Dónde está en el sistema (Ubicación)</span>
          <span class="term-value" id="termFile">views/SolicitudCitas.php:384</span>
        </div>
        <div class="term-row">
          <span class="term-label">❓ Por qué se activa (Desencadenante)</span>
          <span class="term-value" id="termTrigger">Al escribir un teléfono sin el formato oficial de 8 dígitos y guion intermedio.</span>
        </div>
        <div class="term-row">
          <span class="term-label">💬 Mensaje desplegado en pantalla</span>
          <span class="term-value glowing-warning" id="termMessage">"Por favor, ingrese un número de teléfono válido (0000-0000)."</span>
        </div>
      </div>
    </div>

    <!-- Enlaces de navegación inferiores -->
    <div class="navigation-links">
      <a href="dashboard.php" class="nav-btn"><i class="bi bi-arrow-left"></i> Volver al Dashboard</a>
      <a href="../index.php" class="nav-btn"><i class="bi bi-house-door"></i> Inicio de Munify</a>
    </div>

  </div>

  <!-- SweetAlert2 Script -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    // Inicializar los datos del primer botón al cargar
    document.addEventListener('DOMContentLoaded', () => {
      const activeBtn = document.querySelector('.alert-btn.active');
      if (activeBtn) updateTermData(activeBtn);
    });

    // Función para manejar la selección de botones
    function seleccionarAlerta(element) {
      // 1. Quitar estado activo de otros botones y asignar a este
      document.querySelectorAll('.alert-btn').forEach(btn => btn.classList.remove('active'));
      element.classList.add('active');

      // 2. Actualizar Ficha Técnica en la consola oscura
      updateTermData(element);

      // 3. Ejecutar la Alerta Real en Vivo
      const type = element.getAttribute('data-type');
      const icon = element.getAttribute('data-icon').includes('success') ? 'success' : 
                   (element.getAttribute('data-icon').includes('danger') ? 'error' : 'warning');
      const msg = element.getAttribute('data-message');

      if (type === 'toast') {
        lanzarToast(icon, msg);
      } else {
        lanzarModal(icon, 'Diálogo Munify', msg);
      }
    }

    // Actualizar datos de consola oscura
    function updateTermData(el) {
      const file = el.getAttribute('data-file');
      const trigger = el.getAttribute('data-trigger');
      const message = el.getAttribute('data-message');
      const iconClass = el.getAttribute('data-icon');

      document.getElementById('termFile').innerHTML = `<code>${file}</code>`;
      document.getElementById('termTrigger').textContent = trigger;
      
      const msgEl = document.getElementById('termMessage');
      msgEl.textContent = `"${message}"`;

      // Definir color de neón en terminal basado en la alerta
      msgEl.className = 'term-value'; // limpiar
      if (iconClass.includes('success')) {
        msgEl.classList.add('glowing-green');
      } else if (iconClass.includes('danger')) {
        msgEl.classList.add('glowing-danger');
      } else {
        msgEl.classList.add('glowing-warning');
      }
    }

    // Lanzador de Toasts en Vivo
    function lanzarToast(icon, message) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      Toast.fire({
        icon: icon,
        title: message
      });
    }

    // Lanzador de Modales en Vivo
    function lanzarModal(icon, title, message) {
      Swal.fire({
        icon: icon,
        title: title,
        text: message,
        confirmButtonColor: '#1C3166',
        confirmButtonText: 'Aceptar'
      });
    }

    // Filtrado por Módulos
    function filtrarModulo(modulo) {
      // Actualizar clase activa del botón del filtro
      document.querySelectorAll('#filterContainer .filter-pill-btn').forEach(btn => btn.classList.remove('active'));
      event.target.classList.add('active');

      const items = document.querySelectorAll('#alertGrid .alert-btn');
      items.forEach(item => {
        if (modulo === 'todos' || item.getAttribute('data-modulo') === modulo) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      });
    }
  </script>

</body>
</html>
