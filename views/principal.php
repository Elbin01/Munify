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
    <div class="login-wrapper">
        <div class="login-sidebar">
            <div class="sidebar-content">
                <div class="logo-container">
                    <img src="../assets/Img/MUNIFY.jpeg" alt="Logo Alcaldía" onerror="this.style.display='none';this.parentElement.innerHTML='🏛️'">
                </div>
                <h2>MUNIFY</h2>
                <p>Sistema Integrado de Registro Civil Municipal</p>
                <div class="gov-badges">
                    <span><i class="fas fa-landmark"></i> Institucional</span>
                    <span><i class="fas fa-lock"></i> Seguro</span>
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