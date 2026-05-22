<?php
$anio = date('Y');
include __DIR__ . '/secretary_notifications.php';
?>

<!-- Link al CSS del Footer 2 -->
<link rel="stylesheet" href="../assets/css/footer.css">

<!-- Estilos para el Blur del Backdrop del Offcanvas -->
<style>
    .offcanvas-backdrop.show {
        opacity: 1 !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
    }
</style>

<footer class="munify-footer">
  <div class="footer-brand">
    <span class="footer-brand-name">MUNIFY</span>
    <span class="footer-copy">&copy; <?= $anio ?> Munify. Todos los derechos reservados.</span>
  </div>

  <div class="footer-status">
    <div class="footer-status-dot"></div>
    Sistemas operando con normalidad
  </div>

  <div class="footer-right">
    <div class="footer-developer" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBlackRoseAdmin">
      <span class="footer-developer-text">Desarrollado por</span>
      <div class="footer-developer-brand">
        <img src="../assets/img/BlackRoseSystems.png" alt="Blackrose Logo" class="footer-developer-logo">
        <span class="footer-developer-name">BlackRose Systems</span>
      </div>
    </div>
    
    <!-- PANEL BLACKROSE (OFFCANVAS) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasBlackRoseAdmin" aria-labelledby="blackRoseLabelAdmin">
        <div class="offcanvas-header shadow-sm" style="background-color: #1C3166; color: white;">
            <h5 class="offcanvas-title" id="blackRoseLabelAdmin" style="font-family: 'Poppins', sans-serif; font-size: 1.1rem; font-weight: 600;">
                <i class="bi bi-code-slash me-2"></i> Desarrolladores
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-4 text-center" style="font-family: 'Poppins', sans-serif;">
            <div style="display: inline-block; margin-bottom: 1.5rem;">
                <img src="../assets/img/BlackRoseSystems.png" alt="BlackRose Systems" style="width: 140px; height: auto;">
            </div>
            
            <h3 class="fw-bold mb-1" style="color: #1C3166; letter-spacing: -0.5px;">BlackRose Systems</h3>
            <p class="text-muted mb-4 fw-medium" style="font-size: 0.9rem;">Agencia de Ingeniería y Soluciones de Software</p>
            
            <div class="text-start bg-light p-4 rounded-4 border mb-4">
                <p class="text-secondary small mb-3 lh-lg">
                    Somos un equipo de desarrolladores apasionados por crear ecosistemas tecnológicos escalables, innovadores y de alto rendimiento.
                </p>
                <p class="text-secondary small mb-0 lh-lg">
                    Nos especializamos en la modernización digital, arquitecturas web seguras y soluciones a medida que transforman instituciones y conectan a la comunidad.
                </p>
            </div>
            
            <div class="d-flex align-items-center justify-content-center gap-2 p-3 rounded-3" style="background: rgba(28, 49, 102, 0.05); border: 1px dashed rgba(28, 49, 102, 0.2);">
                <i class="bi bi-gear-wide-connected" style="color: #1C3166; font-size: 1.2rem;"></i>
                <span class="fw-bold small text-uppercase" style="color: #1C3166; letter-spacing: 0.5px;">Transformando ideas en código</span>
            </div>
        </div>
    </div>

    <span class="footer-version">v1.0.0</span>
    <nav class="footer-links">
      <a href="soporte.php" class="footer-link">Soporte</a>
      <a href="privacidad.php" class="footer-link">Privacidad</a>
      <a href="terminos.php" class="footer-link">Términos</a>
    </nav>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.showToast = function(message, type = 'auto') {
    if (!message) return;
    
    // Auto-detección inteligente de tipo
    if (type === 'auto' || type === 'info') {
        const lower = message.toLowerCase();
        if (lower.includes('error') || lower.includes('incorrecto') || lower.includes('inválido') || lower.includes('invalido') || lower.includes('no encontrado') || lower.includes('no encontrada') || lower.includes('obligatorio') || lower.includes('obligatorios') || lower.includes('falló') || lower.includes('fallo') || lower.includes('no se ha seleccionado') || lower.includes('inválida') || lower.includes('invalidas')) {
            type = 'danger';
        } else if (lower.includes('correcto') || lower.includes('correctamente') || lower.includes('exitosamente') || lower.includes('guardado') || lower.includes('éxito') || lower.includes('exito') || lower.includes('completado') || lower.includes('aceptadas') || lower.includes('actualizado') || lower.includes('completo')) {
            type = 'success';
        } else if (lower.includes('advertencia') || lower.includes('atención') || lower.includes('atencion') || lower.includes('cuidado') || lower.includes('pendiente') || lower.includes('ingrese') || lower.includes('seleccione') || lower.includes('favor')) {
            type = 'warning';
        } else {
            type = 'info';
        }
    }

    let swalIcon = 'info';
    let swalTitle = 'Información';
    
    if (type === 'success') {
        swalIcon = 'success';
        swalTitle = 'Éxito';
    } else if (type === 'danger' || type === 'error') {
        swalIcon = 'error';
        swalTitle = 'Error';
    } else if (type === 'warning') {
        swalIcon = 'warning';
        swalTitle = 'Advertencia';
    }

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: swalIcon,
            title: swalTitle,
            text: message,
            confirmButtonColor: '#1C3166',
            confirmButtonText: 'Aceptar'
        });
    } else {
        console.log(swalTitle + ": " + message);
    }
};

window.alert = function(message) {
    window.showToast(message, 'auto');
};

</script>
