<?php

namespace Controller;

use App\Router;

class AdminPagesController {
    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $router->render('administrator/admin', []);
    }

    public static function deliveryman(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $router->render('administrator/deliveryman', []);
    }

    public static function map(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $router->render('administrator/map', []);
    }
}
?>