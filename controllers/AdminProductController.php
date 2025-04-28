<?php

namespace Controller;

use App\Router;
use Model\Producto;
use Model\ProductoCategoria;
use Model\ProductoTamaño;

class AdminProductController {

    public static function index(Router $router) {
        if (isAdmin()) {
            header('Location: /');
            exit;
        }

        $products = Producto::getAdminProductos();

        $router->render('administrator/adminproduct', [
            'products' => $products
        ]);
    }

    public static function edit(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $categoria1 = $_POST['categoria1'] ?? '';
            $categoria2 = $_POST['categoria2'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $tamanos = $_POST['tamanos'] ?? [];
            $precios = $_POST['precios'] ?? [];
            // Si vas a permitir editar la imagen, procesa $_FILES['imagen'] aquí
    
            // Prepara las categorías como array
            $categorias = [];
            if ($categoria1) $categorias[] = $categoria1;
            if ($categoria2 && $categoria2 !== $categoria1) $categorias[] = $categoria2;
    
            // Llama al modelo para actualizar
            Producto::update($id, $nombre, $descripcion, $tamanos, $precios, $categorias);
    
            http_response_code(200);
            exit;
        }
    
        // Si es GET, muestra el formulario de edición como ya lo tienes
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/adminproduct');
            exit;
        }
    
        $product = Producto::findById($id);
        if (!$product) {
            header('Location: /admin/adminproduct');
            exit;
        }
    
        $router->render('administrator/editproduct', [
            'product' => $product
        ]);
    }
}
?>