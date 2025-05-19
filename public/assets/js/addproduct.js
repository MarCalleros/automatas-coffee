import { createNotification } from './notification.js';

document.getElementById('agregar').onclick = async function() {
    // Captura los datos básicos
    const nombre = document.getElementById('nombre').value.trim();
    const categoria1 = document.getElementById('categoria1').value;
    const categoria2 = document.getElementById('categoria2').value;
    const descripcion = document.getElementById('descripcion').value.trim();
    const imagenInput = document.getElementById('imagen');
    const imagen = imagenInput.files[0];

    // Captura los tamaños seleccionados con sus precios y su stock
    let error = false;
    const tamanos = [];
    document.querySelectorAll('input[name="tamano"]:checked').forEach(cb => {
        const precio = document.getElementById('precio-' + cb.value).value;
        const stock = document.getElementById('stock-' + cb.value).value;
        if (!precio) {
            createNotification('error', 'Debes ingresar el precio para el tamaño seleccionado: ' + cb.nextElementSibling.textContent);
            error = true;
            return;
        }
        if (!stock) {
            createNotification('error', 'Debes ingresar el stock para el tamaño seleccionado: ' + cb.nextElementSibling.textContent);
            error = true;
            return;
        }
        if (isNaN(precio) || parseFloat(precio) <= 0) {
            createNotification('error', 'El precio debe ser un número mayor a 0 para el tamaño: ' + cb.nextElementSibling.textContent);
            error = true;
            return;
        }
        if (isNaN(stock) || parseInt(stock) < 0) {
            createNotification('error', 'El stock debe ser un número mayor o igual a 0 para el tamaño: ' + cb.nextElementSibling.textContent);
            error = true;
            return;
        }
        tamanos.push({ tamano: cb.value, precio: precio , stock: stock });
    });

    if (error) { return; }

    const productId = getProductIdFromUrl();

    // Validación básica
    if (!nombre) {
        createNotification('error', 'El nombre es obligatorio');
        return;
    }
    if (!categoria1 && !categoria2) {
        createNotification('error', 'Debes seleccionar al menos una categoría');
        return;
    }
    if(categoria1 === categoria2) {
        createNotification('error', 'Las categorías no pueden ser iguales');
        return;
    }
    if (tamanos.length === 0) {
        createNotification('error', 'Debes seleccionar y poner precio y stock a al menos un tamaño');
        return;
    }
    if (!descripcion) {
        createNotification('error', 'La descripción es obligatoria');
        return;
    }
    if (!imagen && !productId) {
        createNotification('error', 'Debes seleccionar una imagen');
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
        formData.append('stocks[]', obj.stock);
    });

    if (productId) {
        formData.append('id', productId);
    }

    // Envía los datos al backend
    if (!productId) {
        try {
            const response = await fetch('/admin/addproduct', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                console.log(response);
                createNotification('success', 'Producto guardado correctamente');
                window.location.href = '/admin/adminproduct';
            } else {
                createNotification('error', 'Error al guardar el producto');
            }
        } catch (e) {
            createNotification('error', 'Error de conexión al servidor');
        }
    } else {
        try {
            const response = await fetch('/admin/editproduct', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                console.log(response);
                createNotification('success', 'Producto actualizado correctamente');
                window.location.href = '/admin/adminproduct';
            } else {
                createNotification('error', 'Error al actualizar el producto');
            }
        } catch (e) {
            createNotification('error', 'Error de conexión al servidor');
        }

    }
};

document.getElementById('cancelar').onclick = function() {
    window.location.href = '/admin/adminproduct';
}

document.getElementById('imagen').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview-imagen');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        // Si se deselecciona la imagen, vuelve a mostrar la imagen original
        preview.src = preview.getAttribute('data-original') || preview.src;
    }
});

function getProductIdFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get('id');
}