function initMap() {
    const position = { lat: 25.814645319853593, lng: -108.97987255435451 };
  
    const map = new google.maps.Map(document.getElementById("map"), {
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