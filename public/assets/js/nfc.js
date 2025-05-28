const socket = io("https://scritp-nfc.onrender.com");

socket.on("nfc_to_client", (nfc_id) => {
    console.log("nfc recibido :", nfc_id); 
});

socket.on("automatas_nfc_to_server", (nfc_id_automatas) => {
    console.log("data:", nfc_id_automatas);
});