(function () {
    const card = document.getElementById('loginCard');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const replayBtn = document.getElementById('replayBtn');
    const welcomeSpan = document.getElementById('welcomeUser');

    // Credenciales válidas
    const VALID_USER = 'admin';
    const VALID_PASS = '1234';

    function handleLogin() {
        const user = username.value.trim();
        const pass = password.value.trim();

        if (user === VALID_USER && pass === VALID_PASS) {
            // 1. Activar animación de carga en el botón
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;

            // 2. Simular tiempo de espera (1.5 segundos)
            setTimeout(() => {
                welcomeSpan.innerText = user;

                // 3. Disparar la animación de giro (Flip)
                card.classList.add('flipped');

                // Limpiar el estado del botón por si se reinicia
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;
            }, 1500);

        } else {
            // Animación simple de error (opcional)
            loginBtn.style.backgroundColor = '#ff4040';
            alert('Credenciales incorrectas. Intenta con admin / 1234');
            setTimeout(() => { loginBtn.style.backgroundColor = ''; }, 1000);
        }
    }

    // Evento al hacer click
    if (loginBtn) {
        loginBtn.addEventListener('click', handleLogin);
    }

    // Evento para reiniciar
    if (replayBtn) {
        replayBtn.addEventListener('click', () => {
            card.classList.remove('flipped');
            username.value = '';
            password.value = '';
        });
    }

    // Permitir entrar con la tecla Enter
    [username, password].forEach(input => {
        if (input) {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') handleLogin();
            });
        }
    });
})();