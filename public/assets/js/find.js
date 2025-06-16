var map = L.map('map').setView([25.814541, -108.980365], 15);
const subisdiaries = document.querySelectorAll('.find__card');

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var coffeeIcon = L.icon({
    iconUrl: '/../assets/img/logo-coffee.png',

    iconSize:     [32, 32], // size of the icon
    iconAnchor:   [18, 10], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, 0] // point from which the popup should open relative to the iconAnchor
});

subisdiaries.forEach((subisdiary) => {
    const lat = parseFloat(subisdiary.getAttribute('data-lat'));
    const lng = parseFloat(subisdiary.getAttribute('data-lng'));
    const name = subisdiary.getAttribute('data-name');
    const position = [lat, lng];

    var marker = L.marker(position, {icon: coffeeIcon}).addTo(map);
    marker.bindPopup(`<b>Sucursal ${name}</b><br>¡Esperamos su visita!`);
});

const imgCards = document.querySelectorAll('.find__card');

let intervalId = null;

imgCards.forEach((imgCard) => {
    let intervalId = null;
    let currentIndex = 0;
    const imgs = imgCard.querySelectorAll(".find__card-image");
    const totalImgs = imgs.length;
    
    const nextImage = () => {
        imgs.forEach(img => img.classList.remove('find__card-image--active'));
        currentIndex = (currentIndex + 1) % totalImgs;
        imgs[currentIndex].classList.add('find__card-image--active');
    };
    
    imgCard.addEventListener('mouseenter', () => {
        if (intervalId) return;

        intervalId = setInterval(nextImage, 3000); // Cambia cada 3 segundos

        if (currentIndex !== 0) {
            nextImage();
        }
    });
    
    imgCard.addEventListener('mouseleave', () => {
        clearInterval(intervalId);
        intervalId = null;
        
        imgs.forEach(img => img.classList.remove('find__card-image--active'));
        imgs[0].classList.add('find__card-image--active');
        currentIndex = 0;
    });
});