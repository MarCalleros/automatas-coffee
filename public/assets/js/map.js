const socket = io("https://automatas-coffee-api.onrender.com");
let map;
let markers = [];

function initMap() {
    const position = { lat: 25.814645319853593, lng: -108.97987255435451 };
  
    map = new google.maps.Map(document.getElementById("map"), {
      center: position,
      zoom: 15,
    });
  
    const marker = new google.maps.Marker({
      position: position,
      map: map,
      title: "Automatas Coffee",
      icon: {
        url: "/assets/img/logo-coffee.png",
        scaledSize: new google.maps.Size(40, 40),
      },
    });
  
    const infoWindow = new google.maps.InfoWindow({
      content: "<strong>Automatas Coffee</strong>",
    });
  
    marker.addListener("click", () => {
      infoWindow.open(map, marker);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const repartidores = document.querySelectorAll(".map__deliveryman");

    repartidores.forEach((repartidor) => {
        const id = parseInt(repartidor.getAttribute("data-id"));
        const lat = parseFloat(repartidor.getAttribute("data-lat"));
        const lng = parseFloat(repartidor.getAttribute("data-lng"));
        const position = { lat: lat, lng: lng };

        const existingMarker = markers.find(marker => marker.id === id);
        if (existingMarker) {
            existingMarker.marker.setMap(null);
            markers = markers.filter(marker => marker.id !== id);
        }

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: "Repartidor",
        });

        const infoWindow = new google.maps.InfoWindow({
          content: `<strong>Repartidor ${id}</strong>`,
        });
      
        marker.addListener("click", () => {
          infoWindow.open(map, marker);
        });

        markers.push({ id: id, marker: marker });
    });
    console.log(markers);
});

socket.on("updateMap", (data) => {
    console.log("Nueva ubicación recibida:", data);
    const position = { lat: data.lat, lng: data.lng };

    // Verificar si el repartidor ya existe en el array de marcadores
    const existingMarker = markers.find(marker => marker.id === data.id);
    if (existingMarker) {
        existingMarker.marker.setMap(null); // Eliminar el marcador anterior
        markers = markers.filter(marker => marker.id !== data.id); // Eliminar de la lista
    }

    const marker = new google.maps.Marker({
        position: position,
        map: map,
        title: "Repartidor",
    });

    const infoWindow = new google.maps.InfoWindow({
      content: `<strong>Repartidor ${data.id}</strong>`,
    });
      
    marker.addListener("click", () => {
      infoWindow.open(map, marker);
    });

    markers.push({ id: data.id, marker: marker });

    console.log(markers);
});