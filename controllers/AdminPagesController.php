<?php

namespace Controller;

use App\Router;
use Model\Repartidor;
use Model\Ubicacion;

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

        foreach ($repartidores as $repartidor) {
            if ($repartidor->estatus_repartiendo == 1) {
                $ubicacion = Ubicacion::findById($repartidor->id);
                $repartidor->ubicacion = $ubicacion;
            } else {
                $repartidor->ubicacion = null;
            }
        }

        $router->render('administrator/map', [
            'repartidores' => $repartidores
        ]);
    }
}
?>