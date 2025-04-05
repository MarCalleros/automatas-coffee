import { createNotification } from './notification.js';

(function() {
    const deliverymanStatusForms = document.querySelectorAll('.admin-deliveryman-status-form');

    if (deliverymanStatusForms) {
        deliverymanStatusForms.forEach(form => {
            const button = form.querySelector('button')
    
            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                let estatus = form.dataset.estatus === "1" ? "0" : "1";
    
                const formData = new FormData();
                formData.append("id", id);
                formData.append("estatus", estatus);
    
                const response = await fetch("/admin/deliveryman", {
                    method: "POST",
                    body: formData
                });
    
                if (response.ok) {
                    form.dataset.estatus = estatus;
                    button.textContent = estatus === "1" ? "Dar de Baja" : "Dar de Alta";
                    
                    const row = form.closest("tr");
                    const estatusCell = row.querySelectorAll("td")[9];
                    const div = estatusCell.querySelector("div");
                    
                    div.className = estatus === "1"
                        ? "admin-table__data--active"
                        : "admin-table__data--inactive";
                    
                    div.textContent = estatus === "1" ? "Alta" : "Baja";
                    createNotification("success", "Estado del repartidor cambiado correctamente");
                } else {
                    createNotification("error", "Error al cambiar el estado del repartidor");
                }
            });
        });
    }
})();