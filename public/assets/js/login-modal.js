(function() {
    const loginButton = document.querySelector('.navbar__button');

    const loginModal = document.querySelector('.login-modal');
    const registerModal = document.querySelector('.register-modal');

    const closeLoginButton = document.querySelector('#login-close');
    const closeRegisterButton = document.querySelector('#register-close');

    const backgroundShadow = document.querySelector('#background-login');

    const registerLink = document.querySelector('#login-register');
    const loginLink = document.querySelector('#register-login');

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

    registerLink.addEventListener('click', function() {
        loginModal.classList.remove('login-modal--active');
        registerModal.classList.add('register-modal--active');
    });

    loginLink.addEventListener('click', function() {
        registerModal.classList.remove('register-modal--active');
        loginModal.classList.add('login-modal--active');
    });

    closeRegisterButton.addEventListener('click', function() {
        registerModal.classList.remove('register-modal--active');
        loginModal.classList.remove('login-modal--active');
        backgroundShadow.classList.remove('background__shadow--active');
        backgroundShadow.classList.remove('background__blur--active');

        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    });

    closeLoginButton.addEventListener('click', function() {
        loginModal.classList.remove('login-modal--active');
        backgroundShadow.classList.remove('background__shadow--active');
        backgroundShadow.classList.remove('background__blur--active');

        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    });
})();
