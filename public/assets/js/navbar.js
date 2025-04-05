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
    const loginButton = document.querySelector('.navbar__button--active');
    const cartIcon = document.querySelector('.cart-icon--active');
    const profileIcon = document.querySelector('.profile-icon--active');

    if (navbar) {
        navbar.classList.remove('increase-height');
        navbar.classList.remove('decrease-height');
        
        links.forEach(link => {
            link.classList.remove('navbar__link--active')
        });

        if (loginButton) {
            loginButton.classList.remove('navbar__button--active')
        }

        if (cartIcon) {
            cartIcon.classList.remove('cart-icon--active')
        }

        if (profileIcon) {
            profileIcon.classList.remove('profile-icon--active')
        }
    }    
});

