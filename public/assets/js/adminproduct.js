import { createNotification } from './notification.js';

document.querySelectorAll('.status-btn').forEach(btn => {
    btn.addEventListener('click', async function(e) {
        e.preventDefault();
        const productDiv = btn.closest('.admin__product');
        const productId = productDiv.id.replace('product-', '');

        const response = await fetch('/admin/togglestatus', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new URLSearchParams({ id: productId })
        });
        const data = await response.json();
        if (data.success) {
            if (data.nuevoStatus == 1) {
                btn.textContent = 'Activo';
                btn.classList.add('activo');
                btn.classList.remove('inactivo');
                createNotification('success', 'Producto activado');
            } else {
                btn.textContent = 'Inactivo';
                btn.classList.add('inactivo');
                btn.classList.remove('activo');
                createNotification('error', 'Producto desactivado');
            }
        } else {
            createNotification('error', 'No se pudo cambiar el status');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscador__productos');
    if (!buscador) return;
    buscador.addEventListener('input', function() {
        const filtro = buscador.value.toLowerCase();
        document.querySelectorAll('.admin__product').forEach(card => {
            const nombre = card.querySelector('h4').textContent.toLowerCase();
            card.style.display = nombre.includes(filtro) ? '' : 'none';
        });
    });
});