import { createNotification } from './notification.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.formulario');
    const nombre = document.getElementById('nombre');
    const correo = document.getElementById('correo');
    const mensaje = document.getElementById('mensaje');

    form.addEventListener('submit', (e) => {
        e.preventDefault(); 

        
        if (nombre.value.trim() === '' || correo.value.trim() === '' || mensaje.value.trim() === '') {
            createNotification('error', 'Por favor, completa todos los campos.');
            return;
        }

        if (!validarCorreo(correo.value)) {
            createNotification('error', 'Por favor, ingresa un correo válido.');
            return;
        }

        fetch('/api/message/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                content: mensaje.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status == "success") {
                createNotification("success", data.message);
                form.reset();
            } else {
                createNotification("error", data.message);
            }
        });
    });

    function validarCorreo(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
});
