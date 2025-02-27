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

    if (window.location.pathname === "/" || window.location.pathname === "/admin") {
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