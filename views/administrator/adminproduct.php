<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
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
            <?php include_once __DIR__ . "/../components/products-list.php"; ?>
        </main>

    </div>

    <script src="/assets/js/navbar.js"></script>
</body>
</html>