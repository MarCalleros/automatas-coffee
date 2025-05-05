var map = L.map('map').setView([25.814541, -108.980365], 15);

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

var marker = L.marker([25.814541, -108.980365], {icon: coffeeIcon}).addTo(map);
marker.bindPopup("<b>Automatas Coffee</b><br>¡Esperamos su visita!");