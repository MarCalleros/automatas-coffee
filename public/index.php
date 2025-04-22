<?php

require_once __DIR__ . '/../includes/app.php';

use App\Router;
use Controller\PagesController;
use Controller\ProductoController;
use Controller\APIProducto;

$router = new Router();

// Usuario
$router->get('/', [PagesController::class, 'home']);
$router->get('/contactanos', [PagesController::class, 'contact']);
$router->get('/configuracion', [PagesController::class, 'configuration']);
$router->get('/carrito', [PagesController::class, 'carrito']);

$router->get('/productos', [ProductoController::class, 'index']);

// API
$router->get('/api/productos', [APIProducto::class, 'listPagination']);

$router->testRoutes();
?>