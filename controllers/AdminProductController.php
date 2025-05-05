<?php

namespace Controller;

use App\Router;
use Model\Producto;
use Model\ProductoCategoria;
use Model\ProductoTamaño;

class AdminProductController {

    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $products = Producto::getAdminProductos();

        $router->render('administrator/adminproduct', [
            'products' => $products
        ]);
    }

    public static function create(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $categoria1 = $_POST['categoria1'] ?? '';
            $categoria2 = $_POST['categoria2'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $tamanos = $_POST['tamanos'] ?? [];
            $precios = $_POST['precios'] ?? [];
            $stock = $_POST['stocks'] ?? [];
            $imagen = $_FILES['imagen'] ?? null;
    
            $categorias = [];
            if ($categoria1) $categorias[] = $categoria1;
            if ($categoria2 && $categoria2 !== $categoria1) $categorias[] = $categoria2;
    
            $rutaImagen = null;
            if ($imagen && $imagen['tmp_name']) {
                $nombreImagen = md5(uniqid(rand(), true));
                $rutaImagen = $nombreImagen;
                $destino = __DIR__ . '../../public/assets/img/product/' . $nombreImagen . '.jpg';
                move_uploaded_file($imagen['tmp_name'], $destino);
            }
    
            Producto::create($nombre, $descripcion, $tamanos, $precios, $stock, $categorias, $rutaImagen);
    
            http_response_code(200);
            exit;
        }
    
        $router->render('administrator/addproduct', []);
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
            $stock = $_POST['stocks'] ?? [];
            $imagen = $_FILES['imagen'] ?? null;
    
            $categorias = [];
            if ($categoria1) $categorias[] = $categoria1;
            if ($categoria2 && $categoria2 !== $categoria1) $categorias[] = $categoria2;

            $productoAcual = Producto::findById($id);
            $rutaImagen = $productoAcual['ruta'];

            if ($imagen && $imagen['tmp_name']) {
                $nombreImagen = md5(uniqid(rand(), true));
                $rutaImagen = $nombreImagen;
                $destino = __DIR__ . '../../public/assets/img/product/' . $nombreImagen . '.jpg';
                move_uploaded_file($imagen['tmp_name'], $destino);
            }
    
            Producto::update($id, $nombre, $descripcion, $tamanos, $precios, $stock, $categorias, $rutaImagen);
    
            http_response_code(200);
            exit;
        }
    
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

    public static function toggleStatus(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID requerido']);
                exit;
            }
            $nuevoStatus = Producto::toggleStatus($id);
            echo json_encode(['success' => true, 'nuevoStatus' => $nuevoStatus]);
            exit;
        }
    }

}
?>