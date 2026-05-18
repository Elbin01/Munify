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

    // Función para manejar el error de autenticación
    function showError() {
        const originalBg = loginBtn.style.backgroundColor;
        const originalText = loginBtn.querySelector('.btn-text').innerText;

        loginBtn.style.backgroundColor = '#E63946';
        loginBtn.querySelector('.btn-text').innerText = 'Credenciales Inválidas';
        loginBtn.classList.add('error-shake');

        loginBtn.classList.remove('loading');
        loginBtn.disabled = false;

        setTimeout(() => {
            loginBtn.style.backgroundColor = originalBg;
            loginBtn.querySelector('.btn-text').innerText = originalText;
            loginBtn.classList.remove('error-shake');
        }, 2000);
    }

    async function handleLogin() {
        const user = username.value.trim();
        const pass = password.value.trim();

        if (user !== '' && pass !== '') {
            // 1. Activar botón de carga
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;

            try {
                // 2. Realizar petición al servidor
                const response = await fetch('../controller/LoginController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ usuario: user, password: pass })
                });

                const data = await response.json();

                if (data.success) {
                    welcomeUser.innerText = data.usuario || user;
                    welcomeModal.classList.add('show');

                    // 3. Redirección basada en rol
                    setTimeout(() => {
                        if (data.rol == 1) {
                            window.location.href = 'dashboard.php';
                        } else {
                            window.location.href = '../index.php';
                        }
                    }, 2500);
                } else {
                    showError();
                }
            } catch (error) {
                console.error("Error en login:", error);
                showError();
            }
        } else {
            showError();
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
                    window.showToast('Se han enviado las instrucciones a su correo electrónico.');

                    // Volver al login
                    forgotSection.style.display = 'none';
                    loginSection.style.display = 'block';
                }, 1500);
            } else {
                window.showToast('Por favor ingrese un correo válido.');
            }
        });
    }
})();