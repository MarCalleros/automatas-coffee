<?php

namespace Controller;

use App\Router;
use Model\Producto;

class ProductoController {
    public static function index(Router $router) {
        $page = $_GET['page'] ?? 1;
        $limit = 3;
        $offset = ($page - 1) * $limit;

        $products = Producto::listPagination($offset, $limit);

        if (!$products) { // Por si se pide una página que no existe
            if ($_GET['page'] != 1) {
                header("Location: /productos?page=1");
            }
        }

        $total = Producto::count();
        $totalPages = ceil($total / $limit);

        $router->render('pages/products', [
            'products' => $products,
            'totalPages' => $totalPages
        ]);
    }

    public static function home(Router $router) {
        $page = $_GET['page'] ?? 1;
        $limit = 3;
        $offset = ($page - 1) * $limit;

        $products = Producto::listPagination($offset, $limit);

        if (!$products) { // Por si se pide una página que no existe
            if ($_GET['page'] != 1) {
                header("Location: /productos?page=1");
            }
        }

        $total = Producto::count();
        $totalPages = ceil($total / $limit);

        $router->render('pages/home', [
            'products' => $products,
            'totalPages' => $totalPages
        ]);
    }
}
?>