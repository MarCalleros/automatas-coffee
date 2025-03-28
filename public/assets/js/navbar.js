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

//Funcion para cambiar navbar si esta iniciada sesion o no
document.addEventListener('DOMContentLoaded', function() {
    
    const loginButton = document.getElementById('login-button');
    const userLoggedIcons = document.getElementById('user-logged-icons');
    const hamburgerMenu = document.querySelector('.hamburguer-menu-icon');
    const navbarLinks = document.querySelector('.navbar__links');
    
    function checkUserLoggedIn() {
        if (window.location.pathname.includes('/products')) {
            return true;
        }
        
        return sessionStorage.getItem('userLoggedIn') === 'true';
    }
    
    function updateNavbar() {
        const isLoggedIn = checkUserLoggedIn();
        
        if (isLoggedIn) {
            if (loginButton) loginButton.style.display = 'none';
            if (userLoggedIcons) userLoggedIcons.style.display = 'flex';
        } else {
            if (loginButton) loginButton.style.display = 'block';
            if (userLoggedIcons) userLoggedIcons.style.display = 'none';
        }
    }
    
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            sessionStorage.setItem('userLoggedIn', 'true');
            
            updateNavbar();
        });
    }
    
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function() {
            navbarLinks.classList.toggle('active');
        });
    }
    updateNavbar();    
    if (window.location.pathname.includes('/products')) {
        sessionStorage.setItem('userLoggedIn', 'true');
    }
});