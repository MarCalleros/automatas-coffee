<?php

require_once __DIR__ . '/../includes/app.php';

use App\Router;
use Controller\AdminPagesController;
use Controller\AdminProductController;
use Controller\PagesController;
use Controller\ProductoController;
use Controller\RepartidorController;
use Controller\APIProducto;
use Controller\APIUsuario;

$router = new Router();

// Login
$router->post('/api/user/create', [APIUsuario::class, 'create']);
$router->post('/api/user/login', [APIUsuario::class, 'login']);
$router->post('/api/user/logout', [APIUsuario::class, 'logout']);

// Admin
$router->get('/admin', [AdminPagesController::class, 'index']);
$router->get('/admin/adminproduct', [AdminProductController::class, 'index']);
$router->get('/admin/deliveryman', [RepartidorController::class, 'index']);
$router->post('/admin/deliveryman', [RepartidorController::class, 'index']);
$router->get('/admin/deliveryman/create', [RepartidorController::class, 'create']);
$router->post('/admin/deliveryman/create', [RepartidorController::class, 'create']);
$router->get('/admin/deliveryman/edit', [RepartidorController::class, 'edit']);
$router->post('/admin/deliveryman/edit', [RepartidorController::class, 'edit']);
$router->get('/admin/map', [AdminPagesController::class, 'map']);

// Usuario
$router->get('/', [PagesController::class, 'home']);
$router->get('/contactanos', [PagesController::class, 'contact']);
$router->get('/configuracion', [PagesController::class, 'configuration']);
$router->get('/carrito', [PagesController::class, 'carrito']);
$router->get('/productos', [ProductoController::class, 'index']);

// API
$router->get('/api/productos', [APIProducto::class, 'listPagination']);
$router->get('/api/list', [APIProducto::class, 'list']);
$router->get('/api/filter', [APIProducto::class, 'filter']);
$router->post('/api/product/favorite', [APIProducto::class, 'favorite']);
$router->post('/api/product/unfavorite', [APIProducto::class, 'unfavorite']);

$router->testRoutes();
?>