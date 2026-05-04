(function () {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const welcomeModal = document.getElementById('welcomeModal');
    const welcomeUser = document.getElementById('welcomeUser');

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
})();