import { createNotification } from './notification.js';

(function() {
    
    const loginButton = document.querySelector('.navbar__button');
    const loginButtonMobile = document.querySelector('.user-icon');

    const loginModal = document.querySelector('.login-modal');
    const registerModal = document.querySelector('.register-modal');
    const profileModal = document.querySelector('.profile-modal');

    const closeLoginButton = document.querySelector('#login-close');
    const closeRegisterButton = document.querySelector('#register-close');
    const closeProfileButton = document.querySelector('#profile-close');

    const backgroundShadow = document.querySelector('#background-login');

    const registerLink = document.querySelector('#modal-login-register');
    const loginLink = document.querySelector('#register-login');

    const eyeContainerPasswordLogin = document.querySelector('#login-eye-container-password');
    const eyeIconPasswordLogin = document.querySelector('#login-eye-password');
    const slashIconPasswordLogin = document.querySelector('#login-slash-password');

    const eyeContainerPassword = document.querySelector('#register-eye-container-password');
    const eyeIconPassword = document.querySelector('#register-eye-password');
    const slashIconPassword = document.querySelector('#register-slash-password');

    const eyeContainerConfirm = document.querySelector('#register-eye-container-confirm');
    const eyeIconConfirm = document.querySelector('#register-eye-confirm');
    const slashIconConfirm = document.querySelector('#register-slash-confirm');

    const loginForm = document.querySelector("#login-form");
    const registerForm = document.querySelector("#register-form");
    const profileButton = document.querySelector('#profile-button');

    const nfcButton = document.querySelector('#modal-login-NFC');
    const nfcModal = document.querySelector('#login-modal-nfc');
    const backgroundLogin = document.querySelector('#background-login');
    const closeNfcBtn = document.querySelector('#nfc-login-close');
    const registrarentradabutton = document.querySelector('#nfc-modal-login-button');

    if (nfcButton && nfcModal && backgroundLogin) {
        nfcButton.addEventListener('click', () => {
            loginModal.classList.remove('login-modal--active');
            nfcModal.style.display = 'block';
            backgroundLogin.style.display = 'block';
        });
    }
    if (closeNfcBtn && nfcModal && backgroundLogin) {
        closeNfcBtn.addEventListener('click', () => {
            nfcModal.style.display = 'none';
            backgroundLogin.style.display = 'none';
        });
    }
    if (registrarentradabutton && nfcModal && backgroundLogin) {
        registrarentradabutton.addEventListener('click', () => {
            registrarentradabutton.textContent = 'Esperando lectura...';
            const socket = io('https://scritp-nfc.onrender.com', { transports: ['websocket'] });

            socket.on('connect', () => {
                console.log('Socket.IO conectado');
            });

            socket.emit('solicitar_lectura');

            socket.on('lectura_terminada', (nfcId) => {
                fetch('/api/nfc/getNFClogin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nfcId: nfcId })
                })
                .then(response => response.json())
                .then((data) => {
                    if (data.status == "success") {
                        fetch('/api/nfc/registerLogin', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ nfcId: nfcId })
                            })
                            .then(response => response.json())
                            .then((data) => {
                                if (data.status == "success") {
                                    console.log("✅ Salida registrada correctamente");
                                } else {
                                    console.log("error", data.message);
                                }
                            });
                        createNotification('success', 'Inicio de sesión exitoso');
                        //window.location.href = '/';
                    } else {
                        console.log("error", data.message);
                    }
                });
            });
            socket.on('lectura_error', (error) => {
                console.error('❌ Error al leer tarjeta:', error);
            });
        });
    } 



    let scrollY = 0;

    if (loginButton) {
        loginButton.addEventListener('click', function() {
            scrollY = window.scrollY;
            loginModal.classList.add('login-modal--active');
            backgroundShadow.classList.add('background__shadow--active');
            backgroundShadow.classList.add('background__blur--active');

            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
            document.body.style.width = '100%';
        });
    }

    if (loginButtonMobile) {
        loginButtonMobile.addEventListener('click', function() {
            scrollY = window.scrollY;
            loginModal.classList.add('login-modal--active');
            backgroundShadow.classList.add('background__shadow--active');
            backgroundShadow.classList.add('background__blur--active');

            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
            document.body.style.width = '100%';
        });
    }

    registerLink.addEventListener('click', function() {
        loginModal.classList.remove('login-modal--active');
        registerModal.classList.add('register-modal--active');
    });

    loginLink.addEventListener('click', function() {
        registerModal.classList.remove('register-modal--active');
        loginModal.classList.add('login-modal--active');
    });

    closeRegisterButton.addEventListener('click', function() {
        loginForm.reset();
        registerForm.reset();

        const errorMessages = document.querySelectorAll(".register-modal__error");
        errorMessages.forEach((errorMessage) => {
            errorMessage.classList.remove("register-modal__error--active");
        });

        registerModal.classList.remove('register-modal--active');
        loginModal.classList.remove('login-modal--active');
        backgroundShadow.classList.remove('background__shadow--active');
        backgroundShadow.classList.remove('background__blur--active');

        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    });

    closeLoginButton.addEventListener('click', function() {
        loginForm.reset();
        registerForm.reset();

        const errorMessages = document.querySelectorAll(".register-modal__error");
        errorMessages.forEach((errorMessage) => {
            errorMessage.classList.remove("register-modal__error--active");
        });
        
        loginModal.classList.remove('login-modal--active');
        backgroundShadow.classList.remove('background__shadow--active');
        backgroundShadow.classList.remove('background__blur--active');

        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    });

    closeProfileButton.addEventListener('click', function() {
        profileModal.classList.remove('profile-modal--active');
        backgroundShadow.classList.remove('background__shadow--active');
        backgroundShadow.classList.remove('background__blur--active');

        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    });

    eyeContainerPasswordLogin.addEventListener('click', function() {
        const passwordInput = document.querySelector('#login-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIconPasswordLogin.style.display = 'none';
            slashIconPasswordLogin.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            eyeIconPasswordLogin.style.display = 'block';
            slashIconPasswordLogin.style.display = 'none';
        }
    });

    eyeContainerPassword.addEventListener('click', function() {
        const passwordInput = document.querySelector('#register-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIconPassword.style.display = 'none';
            slashIconPassword.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            eyeIconPassword.style.display = 'block';
            slashIconPassword.style.display = 'none';
        }
    });

    eyeContainerConfirm.addEventListener('click', function() {
        const confirmInput = document.querySelector('#register-confirm');

        if (confirmInput.type === 'password') {
            confirmInput.type = 'text';
            eyeIconConfirm.style.display = 'none';
            slashIconConfirm.style.display = 'block';
        } else {
            confirmInput.type = 'password';
            eyeIconConfirm.style.display = 'block';
            slashIconConfirm.style.display = 'none';
        }
    });

    if (profileButton) {
        profileButton.addEventListener('click', function() {
            scrollY = window.scrollY;
            profileModal.classList.add('profile-modal--active');
            backgroundShadow.classList.add('background__shadow--active');
            backgroundShadow.classList.add('background__blur--active');

            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
            document.body.style.width = '100%';
        });
    }
})();