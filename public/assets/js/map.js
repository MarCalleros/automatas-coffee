const socket = io("https://automatas-coffee-api.onrender.com");
let map;
let markers = [];
let directionsRenderer = null;
let activeDeliveryman = null;

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
        const name = repartidor.querySelector(".map__deliveryman-name").textContent;

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
          content: `<strong>${name}</strong>`,
        });
      
        marker.addListener("click", () => {
          infoWindow.open(map, marker);
        });

        markers.push({ id: id, marker: marker });
    });
    console.log(markers);

    // Crear una sola instancia global de InfoWindow
    const infoWindow = new google.maps.InfoWindow();
    const deliverymans = document.querySelectorAll(".map__deliveryman");

    deliverymans.forEach((deliveryman) => {
        deliveryman.addEventListener("click", () => {
            const id = parseInt(deliveryman.getAttribute("data-id"));
            const lat = parseFloat(deliveryman.getAttribute("data-lat"));
            const lng = parseFloat(deliveryman.getAttribute("data-lng"));
            const delLat = parseFloat(deliveryman.getAttribute("data-delivery-lat"));
            const delLng = parseFloat(deliveryman.getAttribute("data-delivery-lng"));
            const position = { lat: lat, lng: lng };
            const name = deliveryman.querySelector(".map__deliveryman-name").textContent;
            let delivery = deliveryman.getAttribute("data-delivery");

            if (delivery === "null") {
                delivery = "No hay pedido asignado";
            }

            if (lat && lng) {
                deliveryman.classList.add("map__deliveryman--selected");
                deliverymans.forEach(dm => {
                    if (dm !== deliveryman) {
                        dm.classList.remove("map__deliveryman--selected");
                    }
                });

                activeDeliveryman = {
                    id,
                    deliveryLat: delLat,
                    deliveryLng: delLng
                };

                map.setCenter(position);

                const existingMarker = markers.find(marker => marker.id === id);
                if (existingMarker) {
                    existingMarker.marker.setMap(map); // Asegurar que el marcador sea visible

                    // Actualizar el contenido y abrir la InfoWindow
                    infoWindow.setContent(`<strong>${name}</strong>`);
                    infoWindow.open(map, existingMarker.marker);

                    // Sacar del mapa los demás marcadores
                    markers.forEach(marker => {
                        if (marker.id !== id) {
                            marker.marker.setMap(null);
                        }
                    });

                    const div = document.querySelector(".map__deliverymen-container--fixed");
                    let html = `
                        <span class="map__title map__title--without-margin">Siguiendo al repartidor:</span>
                        <span class="map__title map__title--without-margin">${name}</span>
                        <span class="map__title map__title--without-margin">Pedido actual del repartidor:</span>
                        <span class="map__title map__title--without-margin">${delivery}</span>
                        <button type="button" class="map__button">Dejar de seguir</button>
                    `;
                    div.innerHTML = html;
                    div.classList.add("map__deliverymen-container--active");
                    div.setAttribute("data-id", id);

                    const button = div.querySelector(".map__button");
                    button.addEventListener("click", () => {
                        deliveryman.classList.remove("map__deliveryman--selected");
                        div.classList.remove("map__deliverymen-container--active");
                        markers.forEach(marker => {
                            marker.marker.setMap(map); // Mostrar todos los marcadores
                        });
                        infoWindow.close(); // Cerrar la InfoWindow

                        // En caso de que este la ruta en el mapa, eliminarla
                        if (directionsRenderer) {
                            directionsRenderer.setMap(null);
                        }

                        createNotification('success', 'Dejaste de seguir al repartidor');
                    });

                    if (delivery !== "No hay pedido asignado") {
                        if (directionsRenderer) {
                            directionsRenderer.setMap(null); // Limpiar la ruta anterior
                        }
                        directionsRenderer = new google.maps.DirectionsRenderer();
                        const directionsService = new google.maps.DirectionsService();
                        console.log("Latitud de entrega:", delLat, "Longitud de entrega:", delLng);

                        directionsService.route({
                            origin: position,
                            destination: { lat: delLat, lng: delLng },
                            travelMode: google.maps.TravelMode.DRIVING
                        }, (response, status) => {
                            if (status === "OK") {
                                directionsRenderer.setDirections(response);
                                directionsRenderer.setMap(map);
                            } else {
                                console.error("Error al calcular la ruta:", status);
                                createNotification('error', 'Error al calcular la ruta');
                            }
                        });
                    }

                    createNotification('success', `Repartidor ${name} fijado`);
                }
            } else {
                createNotification('error', 'El repartidor no está activo');
            }
        });
    });
});

socket.on("updateMap", (data) => {
    console.log("Nueva ubicación recibida:", data);
    const position = { lat: data.lat, lng: data.lng };

    // Buscar el repartidor con el ID correspondiente
    const repartidores = document.querySelectorAll(".map__deliveryman");
    const repartidor = Array.from(repartidores).find(r => parseInt(r.getAttribute("data-id")) === data.id);
    if (repartidor) {
        repartidor.setAttribute("data-lat", data.lat);
        repartidor.setAttribute("data-lng", data.lng);

        const status = repartidor.querySelector(".map__deliveryman-status");
        status.classList.remove("map__deliveryman-status--inactive");
        status.classList.add("map__deliveryman-status--active");
    }

    const divFixed = document.querySelector(".map__deliverymen-container--fixed");

    // Verificar si el repartidor ya existe en el array de marcadores
    const existingMarker = markers.find(marker => marker.id === data.id);
    if (existingMarker) {
        existingMarker.marker.setPosition(position);

        if (activeDeliveryman && data.id === activeDeliveryman.id) {
        const directionsService = new google.maps.DirectionsService();

        // Limpiar la ruta anterior si existe
        if (!directionsRenderer) {
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
        }

        directionsService.route({
            origin: position,
            destination: {
                lat: activeDeliveryman.deliveryLat,
                lng: activeDeliveryman.deliveryLng,
            },
            travelMode: google.maps.TravelMode.DRIVING
        }, (response, status) => {
            if (status === "OK") {
                directionsRenderer.setDirections(response);
            } else {
                console.error("Error al actualizar la ruta:", status);
                createNotification('error', 'Error al actualizar la ruta');
            }
        });
    }
    } else {
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

        // En caso de que se este siguiendo a un repartidor, ocultar el nuevo marcador
        if (divFixed.classList.contains("map__deliverymen-container--active")) {
            const activeId = parseInt(divFixed.getAttribute("data-id"));
            if (data.id !== activeId) {
                marker.setMap(null); // Ocultar el nuevo marcador si no es el activo
            }
        }
    }
});

let activeNotification = null;
let timeoutHide = null;
let timeoutRemove = null;

function createNotification(type, message) {
    if (activeNotification) {
        clearTimeout(timeoutHide);
        clearTimeout(timeoutRemove);
        activeNotification.remove();
        activeNotification = null;
    }

    const notification = document.createElement("div");
    notification.classList.add("notification", `notification--${type}`);

    const messageElement = document.createElement("p");
    messageElement.classList.add("notification__message");
    messageElement.textContent = message;
    notification.appendChild(messageElement);
    document.body.appendChild(notification);

    activeNotification = notification;

    timeoutHide = setTimeout(() => {
        notification.classList.add("notification--hidden");
    }, 5000);

    timeoutRemove = setTimeout(() => {
        notification.remove();
        activeNotification = null;
    }, 5600);
}