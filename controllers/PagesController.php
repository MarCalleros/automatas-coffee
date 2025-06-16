<?php

namespace Controller;

use App\Router;
use Model\Usuario;
use Model\Producto;
use Model\Sucursal;
use Model\Direccion;
use Model\Tarjeta;
use Model\Carrito;

class PagesController {
    public static function home(Router $router) {
        $products = Producto::listPopular(6);

        $router->render('pages/home', [
            'products' => $products
        ]);
    }

    public static function find(Router $router) {
        $subsidiaries = Sucursal::where('estatus', 1);

        $router->render('pages/find', [
            'subsidiaries' => $subsidiaries
        ]);
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

    public static function delivery(Router $router) {
        if (!isLogged()) {
            header('Location: /');
            return;
        }

        if (Carrito::contarItems($_SESSION['id']) == 0) {
            header('Location: /carrito');
            return;
        }

        $subsidiaries = Sucursal::where('estatus', 1);
        $addresses = Direccion::where('id_usuario', $_SESSION['id']);
        $cards = Tarjeta::where('id_usuario', $_SESSION['id']);
        $total = Carrito::calcularTotal($_SESSION['id']);

        $router->render('pages/delivery', [
            'subsidiaries' => $subsidiaries,
            'addresses' => $addresses,
            'cards' => $cards,
            'total' => $total
        ]);
    }

    public static function information(Router $router, $section = null, $identifier = null) {
        if (!isLogged()) {
            header('Location: /');
            return;
        }
        
        $router->render('pages/information', [
            'section' => $section,
            'identifier' => $identifier
        ]);
    }

    public static function confirmation(Router $router) {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
        } else {
            $token = null;
        }

        if (Usuario::where('token', $token)) {
            Usuario::confirm($token);
        } else {
            $token = null;
        }

        $router->render('pages/confirmation', [
            'token' => $token
        ]);
    }
}
?>