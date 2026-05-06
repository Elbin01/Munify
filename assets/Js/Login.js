(function () {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const welcomeModal = document.getElementById('welcomeModal');
    const welcomeUser = document.getElementById('welcomeUser');

    // Elementos para cambio de vista
    const loginSection = document.getElementById('loginSection');
    const forgotSection = document.getElementById('forgotSection');
    const showForgotBtn = document.getElementById('showForgotBtn');
    const backToLoginBtn = document.getElementById('backToLoginBtn');
    const recoverBtn = document.getElementById('recoverBtn');
    const recoveryEmail = document.getElementById('recoveryEmail');

    // Credenciales válidas para demo
    const VALID_USER = 'admin';
    const VALID_PASS = '1234';

    function handleLogin() {
        const user = username.value.trim();
        const pass = password.value.trim();

        if (user === VALID_USER && pass === VALID_PASS) {
            // 1. Activar botón de carga
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;

            // 2. Simular validación en servidor
            setTimeout(() => {
                welcomeUser.innerText = user;
                welcomeModal.classList.add('show');

                // 3. Simular redirección
                setTimeout(() => {
                    // Aquí iría el window.location.href real hacia el dashboard
                    // window.location.href = 'dashboard.php';
                    welcomeModal.classList.remove('show');
                    loginBtn.classList.remove('loading');
                    loginBtn.disabled = false;
                    username.value = '';
                    password.value = '';
                }, 2500);

            }, 1200);

        } else {
            // Error de autenticación
            const originalBg = loginBtn.style.backgroundColor;
            const originalText = loginBtn.querySelector('.btn-text').innerText;
            
            loginBtn.style.backgroundColor = '#E63946';
            loginBtn.querySelector('.btn-text').innerText = 'Credenciales Inválidas';
            loginBtn.classList.add('error-shake');
            
            setTimeout(() => { 
                loginBtn.style.backgroundColor = originalBg; 
                loginBtn.querySelector('.btn-text').innerText = originalText;
                loginBtn.classList.remove('error-shake');
            }, 2000);
        }
    }

    if (loginBtn) {
        loginBtn.addEventListener('click', handleLogin);
    }

    [username, password].forEach(input => {
        if (input) {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') handleLogin();
            });
        }
    });

    // Lógica para alternar vistas
    if (showForgotBtn) {
        showForgotBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loginSection.style.display = 'none';
            forgotSection.style.display = 'block';
        });
    }

    if (backToLoginBtn) {
        backToLoginBtn.addEventListener('click', (e) => {
            e.preventDefault();
            forgotSection.style.display = 'none';
            loginSection.style.display = 'block';
        });
    }

    // Lógica botón recuperar contraseña
    if (recoverBtn) {
        recoverBtn.addEventListener('click', () => {
            const email = recoveryEmail.value.trim();
            if (email !== '') {
                recoverBtn.classList.add('loading');
                recoverBtn.disabled = true;
                
                setTimeout(() => {
                    recoverBtn.classList.remove('loading');
                    recoverBtn.disabled = false;
                    recoveryEmail.value = '';
                    alert('Se han enviado las instrucciones a su correo electrónico.');
                    
                    // Volver al login
                    forgotSection.style.display = 'none';
                    loginSection.style.display = 'block';
                }, 1500);
            } else {
                alert('Por favor ingrese un correo válido.');
            }
        });
    }
})();