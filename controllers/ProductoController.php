<?php

namespace Controller;

use App\Router;
use Model\Producto;

class ProductoController {
    public static function index(Router $router) {
        $products = Producto::list();
        $router->render('pages/products', [
            'products' => $products
        ]);
    }
}
?>