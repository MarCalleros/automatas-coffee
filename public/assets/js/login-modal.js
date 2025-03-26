(function() {
    const loginButton = document.querySelector('.navbar__button');
    const loginModal = document.querySelector('.login-modal');
    const closeModalButton = document.querySelector('.modal__close');
    const backgroundShadow = document.querySelector('.background__shadow');
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

    closeModalButton.addEventListener('click', function() {
        loginModal.classList.remove('login-modal--active');
        backgroundShadow.classList.remove('background__shadow--active');
        backgroundShadow.classList.remove('background__blur--active');

        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    });
})();
