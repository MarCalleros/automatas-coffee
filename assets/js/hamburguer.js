(function() {
    const hamburguerMenuIcon = document.querySelector('.hamburguer-menu-icon');
    const navbar = document.querySelector('.navbar');
    const links = document.querySelectorAll('.navbar__link');
    const button = document.querySelector('.navbar__button');

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

        button.classList.toggle('navbar__button--active');
    });
})();