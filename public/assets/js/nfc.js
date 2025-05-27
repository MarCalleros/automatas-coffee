const socket = io("https://scritp-nfc.onrender.com");

socket.on("nfc_to_client", (nfc_id) => {
    console.log("nfc recibido :", nfc_id); 
});