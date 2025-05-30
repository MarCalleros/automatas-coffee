import { createNotification } from './notification.js';

document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    let selectedRow = null;
    const tablaRegistros = document.getElementById('tablaRegistrosNFC');
    const btnDelete = document.querySelector('.btn-delete');
    const btnAplicarFechas = document.getElementById('aplicar-fechas');
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');
    
    // Estilo para filas seleccionadas
    const style = document.createElement('style');
    style.textContent = `
        .selected {
            background-color:rgb(255, 230, 202) !important;
            outline: 2px solid #ff5100;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        .btn-delete:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }
    `;
    document.head.appendChild(style);

    // Selección de fila
    if (tablaRegistros) {
        tablaRegistros.addEventListener('click', function(e) {
            const row = e.target.closest('tr[data-id]');
            if (!row) return;
            
            // Deseleccionar fila anterior
            if (selectedRow) {
                selectedRow.classList.remove('selected');
            }
            
            // Seleccionar nueva fila
            row.classList.add('selected');
            selectedRow = row;
            
            // Habilitar botón de borrar
            btnDelete.disabled = false;
        });
    }

    // Botón borrar registro
    if (btnDelete) {
        btnDelete.addEventListener('click', function() {
            if (!selectedRow) {
                createNotification('error', 'Por favor, seleccione un registro para borrar.');
                return;
            }
            
            const registroId = selectedRow.dataset.id;
            if (confirm('¿Está seguro de que desea eliminar este registro?')) {
                deleteRegistro(registroId);
            }
        });
    }

    // Botón aplicar fechas
    if (btnAplicarFechas) {
        btnAplicarFechas.addEventListener('click', function() {
            const desde = fechaInicio.value;
            const hasta = fechaFin.value;
            
            if (!desde || !hasta) {
                createNotification('error', 'Por favor, seleccione ambas fechas.');
                return;
            }
            
            // Recargar la página con los parámetros de fecha
            window.location.href = window.location.pathname + '?desde=' + desde + '&hasta=' + hasta;
        });
    }

    // Función para eliminar registro
   function deleteRegistro(id) {
        fetch('/api/history/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                selectedRow.remove();
                selectedRow = null;
                createNotification('success', 'Registro eliminado correctamente');
            } else {
                createNotification('error', data.message || 'Error al eliminar el registro');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            createNotification('error', 'Ocurrió un error al intentar eliminar el registro: ' + error.message);
        })
        .finally(() => {
            btnDelete.disabled = true;
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('desde') || urlParams.has('hasta')) {
        const fechaPersonalizada = document.getElementById('fecha-personalizada');
        if (fechaPersonalizada) {
            fechaPersonalizada.style.display = 'flex';
        }
    }
});