import { createNotification } from './notification.js';

document.getElementById('agregar').onclick = async function() {
    // Captura los datos básicos
    const nombre = document.getElementById('nombre').value.trim();
    const categoria1 = document.getElementById('categoria1').value;
    const categoria2 = document.getElementById('categoria2').value;
    const descripcion = document.getElementById('descripcion').value.trim();
    const imagenInput = document.getElementById('imagen');
    const imagen = imagenInput.files[0];

    // Captura los tamaños seleccionados y sus precios
    const tamanos = [];
    document.querySelectorAll('input[name="tamano"]:checked').forEach(cb => {
        const precio = document.getElementById('precio-' + cb.value).value;
        if (!precio) {
            alert('Debes ingresar el precio para el tamaño seleccionado: ' + cb.nextElementSibling.textContent);
            return;
        }
        tamanos.push({ tamano: cb.value, precio: precio });
    });

    // Validación básica
    if (!nombre) {
        alert('El nombre es obligatorio');
        return;
    }
    if (!categoria1 && !categoria2) {
        alert('Selecciona al menos una categoría');
        return;
    }
    if (tamanos.length === 0) {
        alert('Selecciona al menos un tamaño y su precio');
        return;
    }
    if (!descripcion) {
        alert('La descripción es obligatoria');
        return;
    }
    if (!imagen) {
        alert('La imagen es obligatoria');
        return;
    }

    // Prepara FormData
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('categoria1', categoria1);
    formData.append('categoria2', categoria2);
    formData.append('descripcion', descripcion);
    formData.append('imagen', imagen);

    // Agrega los tamaños y precios al FormData
    tamanos.forEach(obj => {
        formData.append('tamanos[]', obj.tamano);
        formData.append('precios[]', obj.precio);
    });

    const productId = getProductIdFromUrl();

        if (productId) {
            formData.append('id', productId);
        }

    // Envía los datos al backend
    try {
        const response = await fetch('/admin/addproduct', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            createNotification('success', 'Producto guardado correctamente');
            window.location.href = '/admin/adminproduct';
        } else {
            createNotification('error', 'Error al guardar el producto');
        }
    } catch (e) {
        createNotification('error', 'Error de conexión al servidor');
    }
};

function getProductIdFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get('id');
}