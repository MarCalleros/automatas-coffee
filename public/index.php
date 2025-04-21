<?php

require_once __DIR__ . '/../includes/app.php';

use App\Router;
use Controller\ProductoController;

$router = new Router();

$router->get('/productos', [ProductoController::class, 'index']);

$router->testRoutes();
?>