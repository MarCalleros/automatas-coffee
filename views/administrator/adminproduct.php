<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/adminproduct.css">
    <title>Productos</title>
</head>
<body>
    <div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <h2 class="admin__title">PRODUCTOS</h2>

            <div class="admin__subtitles">
                <h3>Menu</h3>
                <a href="/admin/addproduct">
                    Agregar producto
                </a>
            </div>
            <input type="text" id="buscador-productos" placeholder="Buscar producto..." style="margin: 5px 0px 0px 40px; padding:5px; border-radius:5px;">


            <script src="/assets/js/adminproducts.js"></script>
            <div class="admin__products">
                <?php foreach ($products as $product) : ?>
                    <div class="admin__product" id="product-<?= $product->id ?>">
                        <div class="admin__product__info">
                            <img src="/assets/img/product/<?= $product->ruta ?>.jpg" alt="<?= $product->nombre ?>">
                            <h4><?= $product->nombre ?></h4>
                            <p><?= $product->descripcion ?></p>
                        </div>
                        <div class="admin__product__actions">
                            <a href="/admin/editproduct?id=<?= $product->id ?>" class="edit-product">Editar</a>
                            <a href="#" class="status-btn <?= $product->estatus == 1 ? 'activo' : 'inactivo' ?>">
                                <?= $product->estatus == 1 ? 'Activo' : 'Inactivo' ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            

        </main>

    </div>

    <script src="/assets/js/navbar.js"></script>
    <script src="/assets/js/notification.js"></script>
    <script type="module" src="/assets/js/adminproduct.js"></script></body>
</html>