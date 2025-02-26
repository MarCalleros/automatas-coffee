<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <title>Nuestros Productos</title>
</head>
<body>
    <?php include_once __DIR__ . "/../templates/header.php"; ?>
    
    <h2>PRODUCTOS TEST</h2>

    <div class="card">
        <img class="card__image" src="/assets/img/product/espresso.jpg" alt="Cafe Helado">
                        
        <div class="card__information">
            <h3 class="card__title">Espresso</h3>
            <p class="card__price">$65.00</p>
            <p class="card__description">Café intenso y aromático con una crema dorada en la superficie</p>
        </div>

        <div class="card__footer">
            <button class="card__footer-button">Agregar al carrito</button>
            <div class="card__footer-like">
                <svg class="heart-icon" viewBox="0 0 24 24" width="26" height="26">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . "/../templates/footer.php"; ?>

    <script src="/assets/js/navbar.js"></script>
    <script src="/assets/js/hamburguer.js"></script>
</body>
</html>