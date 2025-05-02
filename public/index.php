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
use Controller\UserController;
use Controller\APICarrito;
use Controller\CarritoController;

$router = new Router();

// Login
$router->post('/api/user/create', [APIUsuario::class, 'create']);
$router->post('/api/user/update', [APIUsuario::class, 'update']);
$router->post('/api/user/login', [APIUsuario::class, 'login']);
$router->post('/api/user/logout', [APIUsuario::class, 'logout']);
$router->post('/api/user/check-password', [APIUsuario::class, 'checkPassword']);
$router->post('/api/user/get-logged-data', [APIUsuario::class, 'getLoggedUserData']);

// Admin
$router->get('/admin', [AdminPagesController::class, 'index']);
$router->get('/admin/adminproduct', [AdminProductController::class, 'index']);
$router->get('/admin/addproduct', [AdminProductController::class, 'create']);
$router->post('/admin/addproduct', [AdminProductController::class, 'create']);
$router->get('/admin/editproduct', [AdminProductController::class, 'edit']);
$router->post('/admin/editproduct', [AdminProductController::class, 'edit']);
$router->post('/admin/togglestatus', [AdminProductController::class, 'toggleStatus']);
$router->get('/admin/deliveryman', [RepartidorController::class, 'index']);
$router->post('/admin/deliveryman', [RepartidorController::class, 'index']);
$router->get('/admin/deliveryman/create', [RepartidorController::class, 'create']);
$router->post('/admin/deliveryman/create', [RepartidorController::class, 'create']);
$router->get('/admin/deliveryman/edit', [RepartidorController::class, 'edit']);
$router->post('/admin/deliveryman/edit', [RepartidorController::class, 'edit']);
$router->get('/admin/usuario', [UserController::class, 'index']);
$router->post('/admin/usuario', [UserController::class, 'index']);
$router->get('/admin/usuario/create', [UserController::class, 'create']);
$router->post('/admin/usuario/create', [UserController::class, 'create']);
$router->get('/admin/usuario/edit', [UserController::class, 'edit']);
$router->post('/admin/usuario/edit', [UserController::class, 'edit']);
$router->get('/admin/map', [AdminPagesController::class, 'map']);

// Usuario
$router->get('/', [PagesController::class, 'home']);
$router->get('/contactanos', [PagesController::class, 'contact']);
$router->get('/configuracion', [PagesController::class, 'configuration']);
$router->get('/informacion', [PagesController::class, 'information']);
$router->get('/carrito', [PagesController::class, 'carrito']);

$router->get('/productos', [ProductoController::class, 'index']);

// API
$router->get('/api/productos', [APIProducto::class, 'listPagination']);
$router->get('/api/list', [APIProducto::class, 'list']);
$router->get('/api/filter', [APIProducto::class, 'filter']);
$router->post('/api/product/favorite', [APIProducto::class, 'favorite']);
$router->post('/api/product/unfavorite', [APIProducto::class, 'unfavorite']);

// API Carrito
$router->get('/api/carrito/obtener', [APICarrito::class, 'obtener']);
$router->post('/api/carrito/agregar', [APICarrito::class, 'agregar']);
$router->post('/api/carrito/actualizar', [APICarrito::class, 'actualizar']);
$router->post('/api/carrito/eliminar', [APICarrito::class, 'eliminar']);
$router->post('/api/carrito/vaciar', [APICarrito::class, 'vaciar']);
$router->post('/api/carrito/comprar', [APICarrito::class, 'comprar']);

$router->testRoutes();
?>