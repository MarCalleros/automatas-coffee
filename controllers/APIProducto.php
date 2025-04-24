<?php

namespace Controller;

use Model\Producto;
use Model\Favorito;

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
                // Buscar si esta liked como true para asignar el id del usuario
                if ($key === 'liked' && $value === 'true') {
                    if (!isLogged()) {
                        echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para ver los productos favoritos']);
                        return;
                    }

                    $columns[] = $key;
                    $values[] = $_SESSION['id'];
                    continue;

                }
                $columns[] = $key;
                $values[] = $value;
            }
        }

        $products = Producto::filter($columns, $values);
        echo json_encode($products);
    }

    public static function favorite() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para agregar productos a favoritos']);
            return;
        }

        $favorito = new Favorito();
        $favorito->id_usuario = $_SESSION['id'];
        $favorito->id_producto = $data['id'];
        $result = $favorito->create();

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Producto agregado a favoritos']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al agregar el producto a favoritos']);
        }
    }

    public static function unfavorite() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para eliminar productos de favoritos']);
            return;
        }

        $favorito = new Favorito();
        $favorito->id_usuario = $_SESSION['id'];
        $favorito->id_producto = $data['id'];
        $result = $favorito->delete();

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Producto eliminado de favoritos']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto de favoritos']);
        }
    }
}
?>