document.addEventListener("DOMContentLoaded", function () {
    bodyDOM = document.querySelector('body');
    const navbar = document.querySelector(".navbar");

    if (navbar) {
        if (window.location.pathname === "/") {
            window.addEventListener("scroll", function() {
            
                if (window.scrollY > 180) {
                    navbar.style.backgroundColor = 'rgba(44, 44, 44, 1)';
                } else {
                    navbar.style.backgroundColor = 'rgba(44, 44, 44, 0.4)';
                }
            });
        }
    }

    // Ajuste de padding para páginas específicas
    if (window.location.pathname === "/" || window.location.pathname.startsWith("/admin")) {
        bodyDOM.style.paddingTop = '0px';
    }
});

window.addEventListener("resize", function() {
    const navbar = document.querySelector(".navbar");
    const links = document.querySelectorAll('.navbar__link--active');

    if (navbar) {
        navbar.classList.remove('increase-height');
        navbar.classList.remove('decrease-height');
        
        links.forEach(link => {
            link.classList.remove('navbar__link--active')
        });
    }    
});

// Configurar los modales
function setupModals() {
    // Elementos del modal
    const backgroundLogin = document.getElementById('background-login');
    const loginModal = document.querySelector('.login-modal');
    const registerModal = document.querySelector('.register-modal');
    const loginClose = document.getElementById('login-close');
    const registerClose = document.getElementById('register-close');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const loginReset = document.getElementById('login-reset');
    const registerReset = document.getElementById('register-reset');
    const loginRegister = document.getElementById('login-register');
    const registerLogin = document.getElementById('register-login');
    
    // Configurar botones de mostrar/ocultar contraseña
    const loginEyeContainer = document.getElementById('login-eye-container');
    const loginEye = document.getElementById('login-eye');
    const loginSlash = document.getElementById('login-slash');
    
    const registerEyeContainerPassword = document.getElementById('register-eye-container-password');
    const registerEyePassword = document.getElementById('register-eye-password');
    const registerSlashPassword = document.getElementById('register-slash-password');
    
    const registerEyeContainerConfirm = document.getElementById('register-eye-container-confirm');
    const registerEyeConfirm = document.getElementById('register-eye-confirm');
    const registerSlashConfirm = document.getElementById('register-slash-confirm');
    
    // Configurar evento para mostrar/ocultar contraseña en login
    if (loginEyeContainer) {
        loginEyeContainer.addEventListener('click', function() {
            const passwordInput = document.getElementById('login-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                loginEye.style.display = 'none';
                loginSlash.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                loginEye.style.display = 'block';
                loginSlash.style.display = 'none';
            }
        });
    }
    
    // Configurar evento para mostrar/ocultar contraseña en registro
    if (registerEyeContainerPassword) {
        registerEyeContainerPassword.addEventListener('click', function() {
            const passwordInput = document.getElementById('register-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                registerEyePassword.style.display = 'none';
                registerSlashPassword.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                registerEyePassword.style.display = 'block';
                registerSlashPassword.style.display = 'none';
            }
        });
    }
    
    // Configurar evento para mostrar/ocultar contraseña de confirmación en registro
    if (registerEyeContainerConfirm) {
        registerEyeContainerConfirm.addEventListener('click', function() {
            const confirmInput = document.getElementById('register-confirm');
            
            if (confirmInput.type === 'password') {
                confirmInput.type = 'text';
                registerEyeConfirm.style.display = 'none';
                registerSlashConfirm.style.display = 'block';
            } else {
                confirmInput.type = 'password';
                registerEyeConfirm.style.display = 'block';
                registerSlashConfirm.style.display = 'none';
            }
        });
    }
    
    // Cerrar modal de login
    if (loginClose && backgroundLogin && loginModal) {
        loginClose.addEventListener('click', function() {
            backgroundLogin.classList.remove('background__shadow--active');
            backgroundLogin.classList.remove('background__blur--active');
            loginModal.classList.remove('login-modal--active');
            document.body.style.overflow = ''; // Restaurar scroll
            
            // Resetear formulario
            if (loginForm) loginForm.reset();
        });
    }
    
    // Cerrar modal de registro
    if (registerClose && backgroundLogin && registerModal) {
        registerClose.addEventListener('click', function() {
            backgroundLogin.classList.remove('background__shadow--active');
            backgroundLogin.classList.remove('background__blur--active');
            registerModal.classList.remove('register-modal--active');
            document.body.style.overflow = ''; // Restaurar scroll
            
            // Resetear formulario
            if (registerForm) registerForm.reset();
        });
    }
    
    // También cerrar al hacer clic en el fondo
    if (backgroundLogin) {
        backgroundLogin.addEventListener('click', function(e) {
            if (e.target === backgroundLogin) {
                backgroundLogin.classList.remove('background__shadow--active');
                backgroundLogin.classList.remove('background__blur--active');
                
                if (loginModal) loginModal.classList.remove('login-modal--active');
                if (registerModal) registerModal.classList.remove('register-modal--active');
                
                document.body.style.overflow = '';
                
                // Resetear formularios
                if (loginForm) loginForm.reset();
                if (registerForm) registerForm.reset();
            }
        });
    }
    
    // Procesar el formulario de login
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('login-username').value;
            const password = document.getElementById('login-password').value;
            
            // Validación básica - solo verificamos que no estén vacíos
            if (username && password) {
                // Establecer estado de login en ambos storages
                localStorage.setItem('isLoggedIn', 'true');
                sessionStorage.setItem('userLoggedIn', 'true');
                
                // Cerrar el modal
                if (backgroundLogin && loginModal) {
                    backgroundLogin.classList.remove('background__shadow--active');
                    backgroundLogin.classList.remove('background__blur--active');
                    loginModal.classList.remove('login-modal--active');
                    document.body.style.overflow = '';
                }
                
                // Actualizar la UI
                const loginButton = document.getElementById('login-button');
                const userLoggedIcons = document.getElementById('user-logged-icons');
                
                if (loginButton) loginButton.style.display = 'none';
                if (userLoggedIcons) userLoggedIcons.style.display = 'flex';
                
                // Mostrar notificación de éxito
                if (typeof createNotification === 'function') {
                    createNotification('success', 'Inicio de sesión exitoso');
                }
            } else {
                // Mostrar error - SOLO si los campos están vacíos
                if (typeof createNotification === 'function') {
                    createNotification('error', 'Por favor ingresa usuario y contraseña');
                }
            }
        });
    }
    
    // Procesar el formulario de registro
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Aquí iría la lógica de registro
            // Por ahora, simplemente mostraremos una notificación de éxito
            
            // Establecer estado de login en ambos storages
            localStorage.setItem('isLoggedIn', 'true');
            sessionStorage.setItem('userLoggedIn', 'true');
            
            // Cerrar el modal
            if (backgroundLogin && registerModal) {
                backgroundLogin.classList.remove('background__shadow--active');
                backgroundLogin.classList.remove('background__blur--active');
                registerModal.classList.remove('register-modal--active');
                document.body.style.overflow = '';
            }
            
            // Actualizar la UI
            const loginButton = document.getElementById('login-button');
            const userLoggedIcons = document.getElementById('user-logged-icons');
            
            if (loginButton) loginButton.style.display = 'none';
            if (userLoggedIcons) userLoggedIcons.style.display = 'flex';
            
            // Mostrar notificación de éxito
            if (typeof createNotification === 'function') {
                createNotification('success', 'Registro exitoso');
            }
        });
    }
    
    // Resetear campos de login
    if (loginReset && loginForm) {
        loginReset.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.reset();
        });
    }
    
    // Resetear campos de registro
    if (registerReset && registerForm) {
        registerReset.addEventListener('click', function(e) {
            e.preventDefault();
            registerForm.reset();
        });
    }
    
    // Ir a registro desde login
    if (loginRegister && registerModal) {
        loginRegister.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ocultar modal de login
            if (loginModal) {
                loginModal.classList.remove('login-modal--active');
            }
            
            // Mostrar modal de registro
            registerModal.classList.add('register-modal--active');
            
            // Asegurarse de que el fondo siga visible
            if (backgroundLogin) {
                backgroundLogin.classList.add('background__shadow--active');
                backgroundLogin.classList.add('background__blur--active');
            }
        });
    }
    
    // Ir a login desde registro
    if (registerLogin && loginModal) {
        registerLogin.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ocultar modal de registro
            if (registerModal) {
                registerModal.classList.remove('register-modal--active');
            }
            
            // Mostrar modal de login
            loginModal.classList.add('login-modal--active');
            
            // Asegurarse de que el fondo siga visible
            if (backgroundLogin) {
                backgroundLogin.classList.add('background__shadow--active');
                backgroundLogin.classList.add('background__blur--active');
            }
        });
    }
}

// Función para mostrar notificaciones
function createNotification(type, message) {
    // Verificar si ya existe una notificación activa
    let activeNotification = document.querySelector('.notification:not(.notification--hidden)');
    
    if (activeNotification) {
        // Ocultar la notificación existente
        activeNotification.classList.add('notification--hidden');
        
        // Eliminar después de la animación
        setTimeout(() => {
            activeNotification.remove();
            // Crear la nueva notificación después de eliminar la anterior
            showNewNotification(type, message);
        }, 600);
    } else {
        // No hay notificaciones activas, mostrar directamente
        showNewNotification(type, message);
    }
}

// Función auxiliar para crear y mostrar una nueva notificación
function showNewNotification(type, message) {
    const notification = document.createElement('div');
    notification.classList.add('notification', `notification--${type}`);
    
    const messageElement = document.createElement('p');
    messageElement.classList.add('notification__message');
    messageElement.textContent = message;
    
    notification.appendChild(messageElement);
    document.body.appendChild(notification);
    
    // Ocultar automáticamente después de 5 segundos
    setTimeout(() => {
        notification.classList.add('notification--hidden');
        
        // Eliminar del DOM después de la animación
        setTimeout(() => {
            notification.remove();
        }, 600);
    }, 5000);
}