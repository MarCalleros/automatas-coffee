<?php

namespace Controller;

use App\Router;
use Model\Repartidor;

class AdminPagesController {
    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $router->render('administrator/admin', []);
    }

    public static function map(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $repartidores = Repartidor::allActiveAsc();

        $router->render('administrator/map', [
            'repartidores' => $repartidores
        ]);
    }

    public static function estadisticas(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $router->render('administrator/estadisticas', []);
    }
}
?>