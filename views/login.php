<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - MUNIFY</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-sidebar">
            <div class="sidebar-content">
                <div class="logo-container">
                    <img src="../assets/Img/logo_munify/isotipo_negativo.png" alt="Munify Isotipo" style="width: 120px; height: auto;">
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
                    <img src="../assets/Img/logo_munify/isotipo_negativo.png" alt="Munify Isotipo" style="width: 80px; height: auto;">
                    <h2>MUNIFY</h2>
                </div>
                <div id="loginSection">
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

                    <div class="form-actions" style="justify-content: space-between; align-items: center;">
                        <a href="#" class="forgot-link" id="showForgotBtn">¿Olvidó su contraseña?</a>
                        <a href="#" class="forgot-link" id="showRegisterBtn">Crear una cuenta nueva</a>
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

                <div id="forgotSection" style="display: none;">
                    <div class="form-header">
                        <h1>Recuperar Contraseña</h1>
                        <p>Ingrese su correo institucional o personal para recibir instrucciones</p>
                    </div>
                    
                    <form action="#" method="POST" id="forgotForm" class="flat-form">
                        <div class="form-group">
                            <label for="recoveryEmail">Correo Electrónico</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="recoveryEmail" placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>

                        <button type="button" id="recoverBtn" class="btn-flat">
                            <span class="btn-text">Enviar Enlace</span>
                            <div class="loader" style="display: none;">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                        
                        <div class="back-link-container">
                             <a href="#" class="back-link backToLoginBtn"><i class="fas fa-arrow-left"></i> Volver a Iniciar Sesión</a>
                        </div>
                    </form>
                </div>

                <div id="registerSection" style="display: none;">
                    <div class="form-header">
                        <h1>Registrarse</h1>
                        <p>Cree una cuenta para solicitar trámites</p>
                    </div>
                    
                    <form action="#" method="POST" id="registerForm" class="flat-form">
                        <div class="form-group">
                            <label for="regNombre">Nombre Completo</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="regNombre" placeholder="Ej: Juan Pérez" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="regEmail">Correo Electrónico</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="regEmail" placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="regPassword">Contraseña</label>
                            <div class="input-wrapper">
                                <i class="fas fa-key"></i>
                                <input type="password" id="regPassword" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="regPasswordConfirm">Confirmar Contraseña</label>
                            <div class="input-wrapper">
                                <i class="fas fa-key"></i>
                                <input type="password" id="regPasswordConfirm" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="button" id="registerBtn" class="btn-flat">
                            <span class="btn-text">Crear Cuenta</span>
                            <div class="loader" style="display: none;">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                        
                        <div class="back-link-container">
                             <a href="#" class="back-link backToLoginBtn"><i class="fas fa-arrow-left"></i> Volver a Iniciar Sesión</a>
                        </div>
                    </form>
                </div>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    window.showToast = function(message, type = 'auto') {
        if (!message) return;
        
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

    <script src="../assets/Js/Login.js?v=<?php echo time(); ?>"></script>
</body>
</html>
