<?php
$anio = date('Y');
?>

<!-- Link al CSS del Footer 2 -->
<link rel="stylesheet" href="../assets/css/footer.css">

<!-- Munify Footer -->
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
    <div class="footer-developer">
      <span class="footer-developer-text">Desarrollado por</span>
      <div class="footer-developer-brand">
        <img src="../assets/img/BlackRoseSystems.png" alt="Blackrose Logo" class="footer-developer-logo">
        <span class="footer-developer-name">blackrose</span>
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
