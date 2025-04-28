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
                    <img class="add__product__icon" src="../assets/img/3.png" alt="">
                    Agregar producto
                </a>
            </div>

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
                            <a href="/admin/deleteproduct?id=<?= $product->id ?>" class="delete-product">Eliminar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            

        </main>

    </div>

    <script src="/assets/js/navbar.js"></script>
</body>
</html>