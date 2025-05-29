<?php

namespace Controller;

use App\Router;
use Model\Usuario;
use Model\Repartidor;
use Model\Mensaje;
use Model\Ubicacion;
use Model\Compra;

class AdminPagesController {
    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $newMessages = Mensaje::where('leido', 0);

        if ($newMessages) {
            foreach ($newMessages as $message) {
                $message->usuario = Usuario::where('id', $message->id_usuario);
            }
        }

        $usersCount = Usuario::count();
        $usersConfirmed = Usuario::countConfirmed();

        $router->render('administrator/admin', [
            'newMessages' => $newMessages,
            'usersCount' => $usersCount,
            'usersConfirmed' => $usersConfirmed
        ]);
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

            if ($repartidor->id_compra) {
                $compra = Compra::where('id', $repartidor->id_compra);
                $repartidor->compra = $compra[0] ?? null;
                $repartidor->id_compra = $compra[0]->identificador;
            }
        }

        $router->render('administrator/map', [
            'repartidores' => $repartidores
        ]);
    }

    public static function statistics(Router $router, $section = null) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $router->render('administrator/statistics', [
            'section' => $section
        ]);
    }

    public static function reporte(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $router->render('administrator/reporte', []);
    }
}
?>