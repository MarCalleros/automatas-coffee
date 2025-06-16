<?php

namespace Controller;

use App\Router;
use Model\Carrito;

class CarritoController {
    public static function index(Router $router) {
        if (!isLogged()) {
            header('Location: /login');
            exit;
        }
        $id_usuario = $_SESSION['id'];
        //Obtener los items del carrito
        $items = Carrito::obtenerCarritoCompleto($id_usuario);
        //Calcular el total
        $total = Carrito::calcularTotal($id_usuario);

        $router->render('pages/carrito', [
            'items' => $items,
            'total' => $total
        ]);
    }
}
?>