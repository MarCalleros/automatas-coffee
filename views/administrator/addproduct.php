<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/addproduct.css">
    <title>Agregar producto</title>
</head>
<body>
<div class="admin-panel">
    <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>

    <div class="main">
        <h2 class="admin__title">AGREGAR PRODUCTO</h2>

        <div class="taker">
            <div class="seccion1">
                <div class="seccion11">
                    <div class="item">
                        <label for="nombre">Nombre del producto</label>
                        <input type="text" id="nombre" placeholder="Ingresar nombre" required>
                    </div>
                    <div class="item">
                        <label for="descripcion">Descripción del producto</label>
                        <textarea id="descripcion" placeholder="Describe el producto"></textarea>
                    </div>
                    <div class="item">
                        <label for="imagen">Imagen del producto</label>
                        <input type="file" id="imagen" accept="image/*">
                    </div>
                </div>
                <div class="seccion12">
                    <div class="item">
                        <label for="categoria1">Categoría 1</label>
                        <select id="categoria1">
                            <option value="">-- Sin categoría --</option>
                            <option value="1">Café caliente</option>
                            <option value="2">Café frío</option>
                            <option value="3">Frapuccino</option>
                            <option value="4">Postre</option>
                        </select>
                    </div>
                    <div class="item">
                        <label for="categoria2">Categoría 2</label>
                        <select id="categoria2">
                            <option value="">-- Sin categoría --</option>
                            <option value="1">Café caliente</option>
                            <option value="2">Café frío</option>
                            <option value="3">Frapuccino</option>
                            <option value="4">Postre</option>
                        </select>
                    </div>
                    <div class="item">
                        <label for="tamano">Tamaño del producto</label>
                        <div class="opciones">
                            <div class="opcion">
                                <input type="checkbox" id="tamano-ch" name="tamano" value="1">
                                <span>Chico</span>
                                <input type="number" id="precio-1" class="precio-tamano" placeholder="Precio chico" min="0" step="0.01" style="visibility:hidden;">
                                <input type="number" id="stock-1" class="stock-tamano" placeholder="Ingresar stock" min="0" style="visibility:hidden;">
                            </div>
                            <div class="opcion">
                                <input type="checkbox" id="tamano-md" name="tamano" value="2">
                                <span>Mediano</span>
                                <input type="number" id="precio-2" class="precio-tamano" placeholder="Precio mediano" min="0" step="0.01" style="visibility:hidden;">
                                <input type="number" id="stock-2" class="stock-tamano" placeholder="Ingresar stock" min="0" style="visibility:hidden;">
                            </div>
                            <div class="opcion">
                                <input type="checkbox" id="tamano-gr" name="tamano" value="3">
                                <span>Grande</span>
                                <input type="number" id="precio-3" class="precio-tamano" placeholder="Precio grande" min="0" step="0.01" style="visibility:hidden;">
                                <input type="number" id="stock-3" class="stock-tamano" placeholder="Ingresar stock" min="0" style="visibility:hidden;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="seccion2">
                <img id="preview-imagen" src="/assets/img/product/<?= $product['ruta'] ?>.jpg" alt="Sin imagen cargada" style="max-width:150px;">
            </div>
            <div class="seccion3">
                <div id="agregar">
                    <label for="">Agregar producto</label>
                </div>
                <div id="cancelar">
                    <label for="">Cancelar</label>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar2">
            
    </div>
</div>

    <script>
        document.querySelectorAll('input[name="tamano"]').forEach(cb => {
            cb.addEventListener('change', function() {
                const precioInput = document.getElementById('precio-' + this.value);
                const stockInput = document.getElementById('stock-' + this.value);
                if (this.checked) {
                    precioInput.style.visibility = 'visible';
                    stockInput.style.visibility = 'visible';
                } else {
                    precioInput.style.visibility = 'hidden';
                    precioInput.value = '';
                    stockInput.style.visibility = 'hidden';
                    stockInput.value = '';
                }
            });
        });
    </script>

    <script src="/assets/js/navbar.js"></script>
    <script src="/assets/js/sidebar.js"></script>
    <script src="/assets/js/notification.js"></script>
    <script type="module" src="/assets/js/addproduct.js"></script>
</body>
</html>