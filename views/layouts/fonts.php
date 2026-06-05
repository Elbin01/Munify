<!-- Fuentes Premium -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<?php
// Aplicar zoom out del 80% solo al contenedor de la vista para el rol de secretaria/o (rol == 1)
// Excepto en la vista index, dashboard y login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) {
    $current_file = basename($_SERVER['PHP_SELF']);
    if ($current_file !== 'login.php' && $current_file !== 'index.php') {
        echo '<style>
            /* Se aplica solo al contenido principal para no desfasar el sidebar ni dejar bloques en blanco */
            .main-content > .container-fluid {
                zoom: 0.8;
            }
        </style>';
    }
}
?>
