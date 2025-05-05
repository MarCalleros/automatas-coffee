<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    <title>Encuentranos</title>
</head>
<body>
    <?php include_once __DIR__ . "/../templates/navbar.php"; ?>

    <div class="find__container">
        <section class="find__content-container">
            <h2 class="title--page">Encuentranos</h2>
            <p class="find__description">Encuentra la tienda más cercana a ti o visitanos en nuestra sucursal principal, ubicada en Fuentes de Poseidon, 81210 Los Mochis, Sinaloa</p>
        </section>

        <section class="find__map-container">
            <div id="map" class="map"></div>
        </section>
    </div>

    <?php include_once __DIR__ . "/../templates/footer.php"; ?>
        
    <script type="module" src="/assets/js/configuration.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin="">
    </script>
    <script src="/assets/js/find.js"></script>
</body>
</html>