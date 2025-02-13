window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");

    if (window.scrollY > 180) {
        navbar.style.backgroundColor = 'rgba(44, 44, 44, 1)';
    } else {
        navbar.style.backgroundColor = 'rgba(44, 44, 44, 0.4)';
    }
});

window.addEventListener("resize", function() {
    const navbar = document.querySelector(".navbar");
    const links = document.querySelectorAll('.navbar__link--active');

    navbar.classList.remove('increase-height');
    navbar.classList.remove('decrease-height');
    
    links.forEach(link => {
        link.classList.remove('navbar__link--active')
    });
});