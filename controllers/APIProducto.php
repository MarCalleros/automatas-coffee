<?php

namespace Controller;

use Model\Producto;

class APIProducto {
    public static function list() {
        $products = Producto::list();
        echo json_encode($products);
    }

    public static function listPagination() {
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;
        $offset = ($page - 1) * $limit;
        $products = Producto::listPagination($offset, $limit);
        echo json_encode($products);
    }

    public static function filter() {
        $columns = [];
        $values = [];

        foreach ($_GET as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $columns[] = $key;
                    $values[] = $v;
                }
            } else {
                $columns[] = $key;
                $values[] = $value;
            }
        }

        $products = Producto::filter($columns, $values);
        echo json_encode($products);
    }
}
?>