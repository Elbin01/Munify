(function () {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const welcomeModal = document.getElementById('welcomeModal');
    const welcomeUser = document.getElementById('welcomeUser');

    // Elementos para cambio de vista
    const loginSection = document.getElementById('loginSection');
    const forgotSection = document.getElementById('forgotSection');
    const registerSection = document.getElementById('registerSection');
    const showForgotBtn = document.getElementById('showForgotBtn');
    const showRegisterBtn = document.getElementById('showRegisterBtn');
    const backToLoginBtns = document.querySelectorAll('.backToLoginBtn');
    
    // Elementos Recovery
    const recoverBtn = document.getElementById('recoverBtn');
    const recoveryEmail = document.getElementById('recoveryEmail');

    // Elementos Register
    const registerBtn = document.getElementById('registerBtn');
    const regNombre = document.getElementById('regNombre');
    const regEmail = document.getElementById('regEmail');
    const regPassword = document.getElementById('regPassword');
    const regPasswordConfirm = document.getElementById('regPasswordConfirm');

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
            registerSection.style.display = 'none';
            forgotSection.style.display = 'block';
        });
    }

    if (showRegisterBtn) {
        showRegisterBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loginSection.style.display = 'none';
            forgotSection.style.display = 'none';
            registerSection.style.display = 'block';
        });
    }

    backToLoginBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            forgotSection.style.display = 'none';
            registerSection.style.display = 'none';
            loginSection.style.display = 'block';
        });
    });

    if (recoverBtn) {
        recoverBtn.addEventListener('click', async () => {
            const email = recoveryEmail.value.trim();
            if (email !== '') {
                recoverBtn.classList.add('loading');
                recoverBtn.disabled = true;

                try {
                    const response = await fetch('../controller/RecoveryController.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ correo: email })
                    });
                    
                    const data = await response.json();
                    
                    recoverBtn.classList.remove('loading');
                    recoverBtn.disabled = false;
                    
                    if(data.success) {
                        recoveryEmail.value = '';
                        window.showToast(data.mensaje, 'success');
                        forgotSection.style.display = 'none';
                        loginSection.style.display = 'block';
                    } else {
                        window.showToast(data.mensaje, 'error');
                    }
                } catch (error) {
                    console.error("Error en recuperación:", error);
                    recoverBtn.classList.remove('loading');
                    recoverBtn.disabled = false;
                    window.showToast('Error al procesar la solicitud', 'error');
                }
            } else {
                window.showToast('Por favor ingrese un correo válido.', 'warning');
            }
        });
    }

    if (registerBtn) {
        registerBtn.addEventListener('click', async () => {
            const nombre = regNombre.value.trim();
            const email = regEmail.value.trim();
            const pass = regPassword.value.trim();
            const passConfirm = regPasswordConfirm.value.trim();

            if (nombre === '' || email === '' || pass === '' || passConfirm === '') {
                window.showToast('Por favor complete todos los campos.', 'warning');
                return;
            }

            if (pass !== passConfirm) {
                window.showToast('Las contraseñas no coinciden.', 'warning');
                return;
            }

            registerBtn.classList.add('loading');
            registerBtn.disabled = true;

            try {
                const response = await fetch('../controller/RegisterController.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nombre: nombre, correo: email, password: pass })
                });

                const data = await response.json();
                
                registerBtn.classList.remove('loading');
                registerBtn.disabled = false;

                if (data.success) {
                    window.showToast(data.mensaje, 'success');
                    regNombre.value = '';
                    regEmail.value = '';
                    regPassword.value = '';
                    regPasswordConfirm.value = '';
                    registerSection.style.display = 'none';
                    loginSection.style.display = 'block';
                } else {
                    window.showToast(data.mensaje, 'error');
                }
            } catch (error) {
                console.error("Error en registro:", error);
                registerBtn.classList.remove('loading');
                registerBtn.disabled = false;
                window.showToast('Error al procesar la solicitud', 'error');
            }
        });
    }
})();