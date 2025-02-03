window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");

    if (window.scrollY > 180) {
        navbar.style.backgroundColor = 'rgba(44, 44, 44, 1)';
    } else {
        navbar.style.backgroundColor = 'rgba(44, 44, 44, 0.4)';
    }
});