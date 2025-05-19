<?php

namespace Controller;

use App\Router;
use Model\Compra;
use Model\Usuario;
use Model\Producto;
use Model\Tamaño;
use Model\DetalleCompra;

class AdminPedidoController {
    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $compras = Compra::all();

        if ($compras) {
            foreach ($compras as $compra) {
                $compra->usuario = Usuario::where('id', $compra->id_usuario);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compra = new Compra();
            
            $compra->id = $_POST['id'];
            $compra->estatus = $_POST['estatus'];
        
            if ($compra->changeStatus()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
                exit;
            }
        }

        $router->render('administrator/deliveries', [
            'deliveries' => $compras
        ]);
    }

    public static function view(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        /*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensaje = new Mensaje();

            $mensaje->id = $_POST['id_mensaje'];
            $mensaje->respondido = 1;
            $mensaje->leido = 1;

            if (!$mensaje->changeView()) {
                echo json_encode(['success' => false, 'error' => "$result"]);
                exit;
            }
            
            if (!$mensaje->changeResponse()) {
                echo json_encode(['success' => false, 'error' => "$result"]);
                exit;
            }

            $tmp = Mensaje::where('id', $_POST['id_mensaje'])[0];

            if ($tmp->id_mensaje) { // Esto significa que es una respuesta
                $mensaje->id_mensaje = $tmp->id_mensaje;
            } else {
                $mensaje->id_mensaje = $_POST['id_mensaje'];
            }

            $mensaje->respondido = 0;
            $mensaje->leido = 0;

            $mensaje->id_usuario = $_SESSION['id'];
            $mensaje->contenido = $_POST['respuesta'];
        
            $result = $mensaje->create();
            if ($result) {
                echo json_encode(['success' => true, 'updatedData' => ['respuesta' => $mensaje->contenido]]);
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => "$result"]);
                exit;
            }
        }*/

        $compra = Compra::where('id', $_GET['id']);

        if (!$compra) {
            header('Location: /admin/delivery');
            exit;
        }
        
        $compra[0]->usuario = Usuario::where('id', $compra[0]->id_usuario); // Obtener el usuario relacionado
        $compra[0]->detalle = DetalleCompra::where('id_compra', $compra[0]->id);

        foreach ($compra[0]->detalle as $detail) {
            $detail->producto = Producto::findById($detail->id_producto);
            $detail->tamaño = Tamaño::where('id', $detail->id_tamaño);
        }

        $router->render('administrator/delivery-view', [
            'delivery' => $compra
        ]);
    }
}
?>