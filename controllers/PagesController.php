<?php

namespace Controller;

use App\Router;

class PagesController {
    public static function home(Router $router) {
        $router->render('pages/home', []);
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