<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Mapa</title>
    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>
</head>
<body>
    <div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <div class="admin__map-container" id="map"></div>

            <div class="map__deliverymen-container">
                <span class="map__title">Repartidores activos:</span>

                <div class="map__deliverymen">
                    <ul class="map__deliverymen-list">
                        <?php foreach ($repartidores as $repartidor) : ?>
                            <li class="map__deliveryman" data-id="<?= $repartidor->id ?>" <?php if ($repartidor->ubicacion) : echo "data-lat=". $repartidor->ubicacion->latitud; endif ?> <?php if ($repartidor->ubicacion) : echo "data-lng=". $repartidor->ubicacion->longitud; endif ?>>
                                <div class="map__deliveryman-status <?= $repartidor->estatus_repartiendo ? 'map__deliveryman-status--active' : 'map__deliveryman-status--inactive' ?>"></div>
                                <p class="map__deliveryman-name"><?= $repartidor->nombre . ' ' . $repartidor->apellido1 . ' ' . $repartidor->apellido2 . ' #' . $repartidor->id ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script src="/assets/js/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyGHnAIzv3n8PjibgZ7HQTMwzbuMvktDY&callback=initMap"></script>
</body>
</html>