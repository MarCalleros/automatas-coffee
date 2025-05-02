<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="/assets/css/carrito.css">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
</head>
<body>
<?php include_once __DIR__ . "/../templates/navbar.php"; ?>
    <h2 class="title--page">Carrito Compras</h2>
    
    <main>
        <div class="container">            
            <div class="cart-container">
                <div class="cart-items">
                    
                </div>
                
                <div class="order-summary">
                    <h2>Total de la compra</h2>
                    <div class="total-price">$0.00</div>
                    <button class="buy-btn">Comprar</button>
                </div>
            </div>
        </div>
    </main>
    
    <?php include_once __DIR__ . "/../templates/footer.php"; ?>   
    <script type="module" src="/assets/js/carrito.js"></script>    
    <script type="module" src="/assets/js/configuration.js"></script>
</body>
</html>