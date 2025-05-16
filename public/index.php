<?php

require_once __DIR__ . '/../includes/app.php';

use App\Router;
use Controller\AdminPagesController;
use Controller\AdminProductController;
use Controller\AdminMensajeController;
use Controller\PagesController;
use Controller\ProductoController;
use Controller\RepartidorController;
use Controller\UserController;
use Controller\CarritoController;
use Controller\APIProducto;
use Controller\APIUsuario;
use Controller\APICarrito;
use Controller\APIMensaje;
use Controller\APIEstadisticas;

$router = new Router();

// Login
$router->get('/api/user/logged', [APIUsuario::class, 'logged']);
$router->post('/api/user/create', [APIUsuario::class, 'create']);
$router->post('/api/user/update', [APIUsuario::class, 'update']);
$router->post('/api/user/login', [APIUsuario::class, 'login']);
$router->post('/api/user/logout', [APIUsuario::class, 'logout']);
$router->post('/api/user/check-password', [APIUsuario::class, 'checkPassword']);
$router->post('/api/user/update-password', [APIUsuario::class, 'updatePassword']);
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
$router->get('/admin/mapa', [AdminPagesController::class, 'map']);
$router->get('/admin/message', [AdminMensajeController::class, 'index']);
$router->post('/admin/message', [AdminMensajeController::class, 'index']);
$router->get('/admin/message/view', [AdminMensajeController::class, 'view']);
$router->post('/admin/message/view', [AdminMensajeController::class, 'view']);
$router->get('/admin/estadisticas', [AdminPagesController::class, 'statistics']);
$router->get('/admin/estadisticas/:section', [AdminPagesController::class, 'statistics']);
//$router->get('/admin/estadisticas/:section/:identifier', [AdminPagesController::class, 'statistics']);

// API Estadísticas
$router->get('/api/estadisticas/productos_cantidad', [APIEstadisticas::class, 'productosVendidos']);
$router->get('/api/estadisticas/productos_ingresos', [APIEstadisticas::class, 'productosIngresos']);
$router->get('/api/estadisticas/clientes_compras', [APIEstadisticas::class, 'clientesCompras']);
$router->get('/api/estadisticas/clientes_ingresos', [APIEstadisticas::class, 'clientesIngresos']);
$router->get('/api/estadisticas/ventas_periodo', [APIEstadisticas::class, 'ventasPeriodo']);
$router->get('/api/estadisticas/graficas', [APIEstadisticas::class, 'graficas']);

// Usuario
$router->get('/', [PagesController::class, 'home']);
$router->get('/confirmacion', [PagesController::class, 'confirmation']);
$router->get('/contactanos', [PagesController::class, 'contact']);
$router->get('/encuentranos', [PagesController::class, 'find']);
$router->get('/configuracion', [PagesController::class, 'configuration']);
$router->get('/informacion', [PagesController::class, 'information']);
$router->get('/informacion/:section', [PagesController::class, 'information']);
$router->get('/informacion/:section/:identifier', [PagesController::class, 'information']);
$router->get('/carrito', [PagesController::class, 'carrito']);

$router->get('/productos', [ProductoController::class, 'index']);

// API
$router->get('/api/productos', [APIProducto::class, 'listPagination']);
$router->get('/api/list', [APIProducto::class, 'list']);
$router->get('/api/filter', [APIProducto::class, 'filter']);
$router->post('/api/product/favorite', [APIProducto::class, 'favorite']);
$router->post('/api/product/unfavorite', [APIProducto::class, 'unfavorite']);
$router->post('/api/message/send', [APIMensaje::class, 'send']);
$router->get('/api/message/sended', [APIMensaje::class, 'getUserMessages']);
$router->get('/api/message/detail', [APIMensaje::class, 'getDetailMessage']);
$router->post('/api/message/response', [APIMensaje::class, 'responseMessage']);
$router->post('/api/message/delete', [APIMensaje::class, 'deleteMessage']);

// API Carrito
$router->get('/api/carrito/obtener', [APICarrito::class, 'obtener']);
$router->post('/api/carrito/agregar', [APICarrito::class, 'agregar']);
$router->post('/api/carrito/actualizar', [APICarrito::class, 'actualizar']);
$router->post('/api/carrito/eliminar', [APICarrito::class, 'eliminar']);
$router->post('/api/carrito/vaciar', [APICarrito::class, 'vaciar']);
$router->post('/api/carrito/comprar', [APICarrito::class, 'comprar']);


$router->testRoutes();
?>
