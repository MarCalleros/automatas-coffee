(function() {
    const hamburguerMenuIcon = document.querySelector('.hamburguer-menu-icon');
    const navbar = document.querySelector('.navbar');
    const links = document.querySelectorAll('.navbar__link');

    const loginButton = document.querySelector('.navbar__button');
    const cartIcon = document.querySelector('.cart-icon');
    const profileIcon = document.querySelector('.profile-icon');

    hamburguerMenuIcon.addEventListener('click', function() {
        if (navbar.classList.contains('increase-height')) {
            navbar.classList.add('decrease-height');
            navbar.classList.remove('increase-height');
        } else {
            navbar.classList.add('increase-height');
            navbar.classList.remove('decrease-height');
        }
        
        links.forEach(link => {
            link.classList.toggle('navbar__link--active')
        });

        loginButton.classList.toggle('navbar__button--active')
        cartIcon.classList.toggle('cart-icon--active')
        profileIcon.classList.toggle('profile-icon--active')
    });
})();