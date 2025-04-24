<?php

namespace Controller;

use App\Router;
use Model\Producto;

class ProductoController {
    public static function index(Router $router) {
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $products = Producto::listPagination($offset, $limit);

        if (!$products) { // Por si se pide una página que no existe
            if ($_GET['page'] != 1) {
                header("Location: /productos?page=1");
            }
        }

        $total = Producto::count();
        $totalPages = ceil($total / $limit);

        $filters = [
            'search' => $_GET['search'] ?? null,
            'liked' => $_GET['liked'] ?? null,
            'category' => $_GET['category'] ?? null,
            'size' => $_GET['size'] ?? null,
            'price' => $_GET['price'] ?? null,
        ];

        $router->render('pages/products', [
            'products' => $products,
            'totalPages' => $totalPages,
            'filters' => $filters
        ]);
    }
}
?>