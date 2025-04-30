<?php

namespace Controller;

use App\Router;
use Model\Producto;

class PagesController {
    public static function home(Router $router) {
        $products = Producto::listPopular(6);

        $router->render('pages/home', [
            'products' => $products
        ]);
    }

    public static function contact(Router $router) {
        $router->render('pages/contact', []);
    }

    public static function configuration(Router $router) {
        $router->render('pages/configuration', []);
    }

    public static function carrito(Router $router) {
        $router->render('pages/carrito', []);
    }
}
?>