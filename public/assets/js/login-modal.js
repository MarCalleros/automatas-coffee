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

    const eyeContainerPassword = document.querySelector('#register-eye-container-password');
    const eyeIconPassword = document.querySelector('#register-eye-password');
    const slashIconPassword = document.querySelector('#register-slash-password');

    const eyeContainerConfirm = document.querySelector('#register-eye-container-confirm');
    const eyeIconConfirm = document.querySelector('#register-eye-confirm');
    const slashIconConfirm = document.querySelector('#register-slash-confirm');

    const loginForm = document.querySelector("#login-form");
    const registerForm = document.querySelector("#register-form");
    const profileButton = document.querySelector('#profile-button');

    let scrollY = 0;

    loginButton.addEventListener('click', function() {
        scrollY = window.scrollY;
        loginModal.classList.add('login-modal--active');
        backgroundShadow.classList.add('background__shadow--active');
        backgroundShadow.classList.add('background__blur--active');

        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollY}px`;
        document.body.style.width = '100%';
    });

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

    profileButton.addEventListener('click', function() {
        scrollY = window.scrollY;
        profileModal.classList.add('profile-modal--active');
        backgroundShadow.classList.add('background__shadow--active');
        backgroundShadow.classList.add('background__blur--active');

        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollY}px`;
        document.body.style.width = '100%';
    });
})();