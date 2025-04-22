<?php

namespace Controller;

use Model\Producto;

class APIProducto {
    public static function listPagination() {
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 3;
        $offset = ($page - 1) * $limit;
        $products = Producto::listPagination($offset, $limit);

        $products = Producto::listPagination($offset, $limit);
        echo json_encode($products);
    }
}
?>