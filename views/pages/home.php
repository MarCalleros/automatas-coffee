<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <title>Automatas Coffee</title>
</head>
<body>
    <?php include_once __DIR__ . "/../templates/header.php"; ?>
    
    <div>
        <h2>Nuestros Productos más Populares</h2>

        <?php include_once __DIR__ . "/../components/carousel.php"; ?>
    </div>

    <h2>Categorias</h2>

    <div class="categories">
        <div class="category category--cafe-caliente">
            <div class="category__image">
                <img src="/assets/img/category/cafe-caliente.png" alt="Categoria Café Caliente">
            </div>
            
            <div class="category__information">
                <h3 class="information__title">Café Caliente</h3>
                <p class="information__description">Cafés reconfortantes para cualquier momento del día</p>
                <button class="information__button">Ver Categoria</button>
            </div>
        </div>

        <div class="category category--cafe-frio">
            <div class="category__image">
                <img src="/assets/img/category/cafe-frio.png" alt="Categoria Café Frio">
            </div>
            
            <div class="category__information">
                <h3 class="information__title">Café Frio</h3>
                <p class="information__description">Refresca tu día con un delicioso café frío</p>
                <button class="information__button">Ver Categoria</button>
            </div>
        </div>

        <div class="category category--frapuccino">
            <div class="category__image">
                <img src="/assets/img/category/frapuccino.png" alt="Categoria Frapuccinos">
            </div>
            
            <div class="category__information">
                <h3 class="information__title">Frapuccino</h3>
                <p class="information__description">Café, hielo y crema en una mezcla perfecta</p>
                <button class="information__button">Ver Categoria</button>
            </div>
        </div>

        <div class="category category--postre">
            <div class="category__image">
                <img src="/assets/img/category/postre.png" alt="Categoria Postres">
            </div>
            
            <div class="category__information">
                <h3 class="information__title">Postre</h3>
                <p class="information__description">Deliciosos postres para acompañar tu bebida</p>
                <button class="information__button">Ver Categoria</button>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . "/../templates/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="assets/js/carousel.js"></script>
    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/hamburguer.js"></script>
    <script src="/assets/js/configuration.js"></script>
</body>
</html>