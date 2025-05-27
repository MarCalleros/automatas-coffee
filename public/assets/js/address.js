const API_KEY = "AIzaSyCyGHnAIzv3n8PjibgZ7HQTMwzbuMvktDY";
//buscarCoordenadas();

async function buscarCoordenadas() {
    //const direccion = "Calle Viñedo de Sicilia 1242, Ampliación Viñedos, Los Mochis, Sinaloa, México";
    //const direccion = "C. 1 623, El Estero, 81386 El Estero, Sin"; // Lat: 25.7668738, Lng: -108.8288072
    //const direccion = "Av. Belisario Domínguez 1796, Anahuac, 81280 Los Mochis, Sin"; // Lat: 25.7701691, Lng: -108.995128
    const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(direccion)}&key=${API_KEY}`;

    const respuesta = await fetch(url);
    const datos = await respuesta.json();

    if (datos.status === "OK") {
    const location = datos.results[0].geometry.location;
    console.log(`Lat: ${location.lat}, Lng: ${location.lng}`);
    } else {
    console.log("No se encontraron coordenadas.");
    }
}