<?php

namespace Controller;

use App\Router;
use Model\Producto;

class AdminProductController {

    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $products = Producto::list();

        $router->render('administrator/adminproduct', [
            'products' => $products
        ]);
    }
}
?>