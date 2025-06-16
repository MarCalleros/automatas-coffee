<?php
$categoria1 = $product['categorias'][0] ?? '';
$categoria2 = $product['categorias'][1] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/addproduct.css">
    <title>Editar producto</title>
</head>
<body>
<div class="admin-panel">
    <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>

    <div class="main">
        <h2 class="admin__title">EDITAR PRODUCTO</h2>

        <div class="taker">
            <div class="seccion1">

                <div class="seccion11">
                    <div class="item">
                        <label for="nombre">Nombre del producto</label>
                        <input type="text" id="nombre" value="<?= htmlspecialchars($product['nombre']) ?>" placeholder="Ingresar nombre" required>
                    </div>
                    <div class="item">
                        <label for="descripcion">Descripción del producto</label>
                        <textarea id="descripcion" placeholder="Describe el producto"><?= htmlspecialchars($product['descripcion']) ?></textarea>
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
                            <option value="1" <?= $categoria1 == 1 ? 'selected' : '' ?>>Café caliente</option>
                            <option value="2" <?= $categoria1 == 2 ? 'selected' : '' ?>>Café frío</option>
                            <option value="3" <?= $categoria1 == 3 ? 'selected' : '' ?>>Frapuccino</option>
                            <option value="4" <?= $categoria1 == 4 ? 'selected' : '' ?>>Postre</option>
                        </select>
                    </div>
                    <div class="item">
                        <label for="categoria2">Categoría 2</label>
                        <select id="categoria2">
                            <option value="">-- Sin categoría --</option>
                            <option value="1" <?= $categoria2 == 1 ? 'selected' : '' ?>>Café caliente</option>
                            <option value="2" <?= $categoria2 == 2 ? 'selected' : '' ?>>Café frío</option>
                            <option value="3" <?= $categoria2 == 3 ? 'selected' : '' ?>>Frapuccino</option>
                            <option value="4" <?= $categoria2 == 4 ? 'selected' : '' ?>>Postre</option>
                        </select>
                    </div>
                    <div class="item">
                        <label for="tamano" class="labeltamanio">Tamaño del producto</label>
                        <div class="opciones">
                            <div class="opcion">
                                <input type="checkbox" id="tamano-ch" name="tamano" value="1" <?= in_array(1, $product['tamanos']) ? 'checked' : '' ?>>
                                <span>Chico (300ml)</span>
                                <input type="number" id="precio-1" class="precio-tamano" placeholder="Precio" min="0" step="0.01"
                                    value="<?= isset($product['precios'][1]) ? $product['precios'][1] : '' ?>"
                                    style="<?= in_array(1, $product['tamanos']) ? 'visibility:visible;' : 'visibility:hidden;' ?>">
                                <input type="number" id="stock-1" class="stock-tamano" placeholder="Stock" min="0"
                                    value="<?= isset($product['stocks'][1]) ? $product['stocks'][1] : '' ?>"
                                    style="<?= in_array(1, $product['tamanos']) ? 'visibility:visible;' : 'visibility:hidden;' ?>">
                            </div>
                            <div class="opcion">
                                <input type="checkbox" id="tamano-md" name="tamano" value="2" <?= in_array(2, $product['tamanos']) ? 'checked' : '' ?>>
                                <span>Mediano (600ml)</span>
                                <input type="number" id="precio-2" class="precio-tamano" placeholder="Precio" min="0" step="0.01"
                                    value="<?= isset($product['precios'][2]) ? $product['precios'][2] : '' ?>"
                                    style="<?= in_array(2, $product['tamanos']) ? 'visibility:visible;' : 'visibiliutty:hidden;' ?>">
                                <input type="number" id="stock-2" class="stock-tamano" placeholder="Stock" min="0"
                                    value="<?= isset($product['stocks'][2]) ? $product['stocks'][2] : '' ?>"
                                    style="<?= in_array(2, $product['tamanos']) ? 'visibility:visible;' : 'visibility:hidden;' ?>">
                            </div>
                            <div class="opcion">
                                <input type="checkbox" id="tamano-gr" name="tamano" value="3" <?= in_array(3, $product['tamanos']) ? 'checked' : '' ?>>
                                <span>Grande (850ml)</span>
                                <input type="number" id="precio-3" class="precio-tamano" placeholder="Precio" min="0" step="0.01"
                                    value="<?= isset($product['precios'][3]) ? $product['precios'][3] : '' ?>"
                                    style="<?= in_array(3, $product['tamanos']) ? 'visibility:visible;' : 'visibility:hidden;' ?>">
                                <input type="number" id="stock-3" class="stock-tamano" placeholder="Stock" min="0"
                                    value="<?= isset($product['stocks'][3]) ? $product['stocks'][3] : '' ?>"
                                    style="<?= in_array(3, $product['tamanos']) ? 'visibility:visible;' : 'visibility:hidden;' ?>">
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="seccion2">
                <label for="preview">Previsualización de la imagen del producto</label>
                <img id="preview-imagen" src="/assets/img/product/<?= $product['ruta'] ?>.jpg" alt="Imagen actual" style="color: #ff0000">
            </div>

            
            <div class="seccion3">
                <div id="cancelar">
                    <label for="">Cancelar</label>
                </div>
                <div id="agregar">
                    <label for="">Agregar producto</label>
                </div>
            </div>
        </div>
    </div>



    <div class="panelderecho"> 
        <img id="logo2" src="../assets/img/logo_white.png" alt="">
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