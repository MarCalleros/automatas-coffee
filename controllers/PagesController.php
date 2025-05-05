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

    public static function find(Router $router) {
        $router->render('pages/find', []);
    }

    public static function contact(Router $router) {
        $router->render('pages/contact', []);
    }

    public static function configuration(Router $router) {
        if (!isLogged()) {
            header('Location: /');
            return;
        }

        $router->render('pages/configuration', []);
    }

    public static function carrito(Router $router) {
        if (!isLogged()) {
            header('Location: /');
            return;
        }

        $router->render('pages/carrito', []);
    }

    public static function information(Router $router) {
        if (!isLogged()) {
            header('Location: /');
            return;
        }
        
        $router->render('pages/information', []);
    }
}
?>