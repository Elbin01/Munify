<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pro - Animated</title>
    <link rel="stylesheet" href="assets/Css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="background-animate">
        <span style="--i:11;"></span>
        <span style="--i:12;"></span>
        <span style="--i:24;"></span>
        <span style="--i:10;"></span>
        <span style="--i:14;"></span>
        <span style="--i:23;"></span>
        <span style="--i:18;"></span>
        <span style="--i:16;"></span>
        <span style="--i:19;"></span>
        <span style="--i:20;"></span>
    </div>

    <div class="main-container">
        
        <div class="header-logo">
            <img src="assets/Img/MUNIFY.jpeg" alt="Munify Logo">
            
        </div>

    <div class="login-box" id="loginCard">
        <div class="page page-front">
            <form action="#" method="POST" id="loginForm">
                <h2>Iniciar Sesión</h2>
                
                <div class="input-group">
                    <input type="text" id="username" required>
                    <label>Usuario</label>
                    <i></i>
                </div>
                
                <div class="input-group">
                    <input type="password" id="password" required>
                    <label>Contraseña</label>
                    <i></i>
                </div>

                <div class="links">
                    <a href="#">Olvidé mi clave</a>
                    <a href="#">Registrarse</a>
                </div>

                <button type="button" id="loginBtn" class="btn-submit load-btn">
                    <span class="default">Ingresar</span>
                    <div class="load-state">
                        <div class="ball"></div>
                        <div class="ball"></div>
                        <div class="ball"></div>
                    </div>
                </button>
            </form>
        </div>
        
        <div class="page page-back">
            <img class="avatar" src="assets/Img/MUNIFY.jpeg" alt="Avatar">
            <p class="welcome">Bienvenido, <span id="welcomeUser"></span>!</p>
            <button type="button" id="replayBtn" class="btn-submit inline">Volver</button>
        </div>
    </div>
    </div>

    <script src="assets/Js/Login.js"></script>

</body>
</html>