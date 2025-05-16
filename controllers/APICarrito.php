<?php
namespace Controller;

use Model\Carrito;

class APICarrito {

    public static function agregar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para agregar productos al carrito']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id_producto'], $data['id_tamaño'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $carrito = new Carrito();
        $carrito->id_usuario = $_SESSION['id'];
        $carrito->id_producto = $data['id_producto'];
        $carrito->id_tamaño = $data['id_tamaño'];
        $carrito->cantidad = $data['cantidad'] ?? 1;

        $result = $carrito->agregarAlCarrito();

        if ($result === true) {
            $totalItems = Carrito::contarItems($_SESSION['id']);
            
            echo json_encode([
                'status' => 'success', 
                'message' => 'Producto agregado al carrito',
                'total_items' => $totalItems
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result]);
        }
    }

    public static function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para actualizar el carrito']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id'], $data['cantidad'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $carrito = new Carrito();
        $carrito->id = $data['id'];
        $carrito->cantidad = $data['cantidad'];
        $carrito->id_usuario = $_SESSION['id']; 
        $result = $carrito->actualizarCantidad();
        echo json_encode($result);
    }

    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para eliminar productos del carrito']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $carrito = new Carrito();
        $carrito->id = $data['id'];

        $result = $carrito->eliminar();

        if ($result === true) {
            // Calcular el nuevo total del carrito
            $total = Carrito::calcularTotal($_SESSION['id']);
            $totalItems = Carrito::contarItems($_SESSION['id']);
            
            echo json_encode([
                'status' => 'success', 
                'message' => 'Producto eliminado del carrito',
                'total' => $total,
                'total_items' => $totalItems
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result]);
        }
    }

    /**
     * Vacía el carrito de un usuario
     */
    public static function vaciar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para vaciar el carrito']);
            return;
        }

        $result = Carrito::vaciar($_SESSION['id']);

        if ($result === true) {
            echo json_encode(['status' => 'success', 'message' => 'Carrito vaciado']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result]);
        }
    }

    public static function obtener() {
        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para ver el carrito']);
            return;
        }
    
        $items = Carrito::obtenerCarritoCompleto($_SESSION['id']);
        $total = Carrito::calcularTotal($_SESSION['id']);
    
        // Convertir objetos Carrito a arrays
        $itemsArray = array_map(function($item) {
            return [
                'id'               => $item->id,
                'id_producto'      => $item->id_producto,
                'id_tamaño'        => $item->id_tamaño,
                'cantidad'         => $item->cantidad,
                'nombre_producto'  => $item->nombre_producto,
                'nombre_tamaño'    => $item->nombre_tamaño,
                'precio'           => $item->precio,
                'descripcion'      => $item->descripcion,
                'ruta_imagen'      => $item->ruta_imagen,
                'stock_disponible' => $item->stock_disponible,
            ];
        }, $items);
    
        echo json_encode([
            'status' => 'success',
            'items'  => $itemsArray,
            'total'  => $total
        ]);
    }
    

    public static function comprar() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
        return;
    }

    if (!isLogged()) {
        echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para realizar una compra']);
        return;
    }
    $resultado = Carrito::comprar($_SESSION['id']);
    echo json_encode($resultado);
}
}
?>