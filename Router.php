<?php 

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => __DIR__ . '/views/pages/home.php',
    '/products' => __DIR__ . '/views/pages/products.php',
    '/views/pages/carrito' => __DIR__ . '/views/pages/carrito.php',
    '/admin' => __DIR__ . '/views/administrator/admin.php',
    '/admin/deliveryman' => __DIR__ . '/views/administrator/deliveryman.php',
    '/admin/deliveries' => __DIR__ . '/views/administrator/deliveries.php'
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