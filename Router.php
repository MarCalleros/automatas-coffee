<?php 

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => __DIR__ . '/views/pages/home.php',
    '/products' => __DIR__ . '/views/pages/products.php',
    '/views/pages/carrito' => __DIR__ . '/views/pages/carrito.php',
    '/contact' => __DIR__ . '/views/pages/contact.php',
    '/configuration' => __DIR__ . '/views/pages/configuration.php',
    '/admin' => __DIR__ . '/views/administrator/admin.php',
    '/admin/deliveryman' => __DIR__ . '/views/administrator/deliveryman.php',
    '/admin/deliveryman/create' => __DIR__ . '/views/administrator/deliveryman-create.php',
    '/admin/deliveryman/edit' => __DIR__ . '/views/administrator/deliveryman-edit.php',
    '/admin/deliveries' => __DIR__ . '/views/administrator/deliveries.php',
    '/admin/map' => __DIR__ . '/views/administrator/map.php'
];

routeView($uri, $routes);

function routeView($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        notFound();
    }
}

function notFound() {
    http_response_code(404);
    require __DIR__ . '/views/pages/404.php';
    die();
}