<?php

namespace Controller;

use Model\Compra;
use Model\DetalleCompra;
use Model\Producto;
use Model\Tamaño;
use Model\Usuario;
use Model\Repartidor;

class APIPedido {
    public static function getUserPurchases() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para ver las compras']);
            return;
        }

        $usuario = Usuario::where('id', $_SESSION['id']);

        if (!$usuario) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
            return;
        }

        $usuario->id_tipo_usuario = null;
        $usuario->edad = null;
        $usuario->usuario = null;
        $usuario->contraseña = null;

        $compras = Compra::where('id_usuario', $_SESSION['id']);

        if ($compras) {
            // Checar si quedo vacio el array
            if (empty($compras)) {
                echo json_encode(['status' => 'error', 'message' => 'No se encontraron compras']);
                return;
            }

            // Reindexar el array
            $compras = array_values($compras);

            echo json_encode(['status' => 'success', 'user' => $usuario, 'purchases' => $compras]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron compras']);
        }
    }

    public static function getDetailPurchase() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para ver las compras']);
            return;
        }

        if (!isset($_GET['identifier'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $usuario = Usuario::where('id', $_SESSION['id']);

        if (!$usuario) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
            return;
        }

        $usuario->id_tipo_usuario = null;
        $usuario->edad = null;
        $usuario->usuario = null;
        $usuario->contraseña = null;

        $compra = Compra::where('identificador', $_GET['identifier']);

        if ($compra) {
            if ($compra[0]->id_usuario !== $_SESSION['id']) { // Comprobar si el mensaje pertenece al usuario
                echo json_encode(['status' => 'error', 'message' => 'No se encontro la compra']);
                return;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontro la compra']);
            return;
        }

        $detalles = DetalleCompra::where('id_compra', $compra[0]->id);

        if ($detalles) {
            foreach ($detalles as $detalle) {
                $detalle->producto = Producto::findById($detalle->id_producto);
                $detalle->tamaño = Tamaño::where('id', $detalle->id_tamaño);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontro la compra']);
            return;
        }

        if ($compra) {
            echo json_encode(['status' => 'success', 'user' => $usuario, 'purchase' => $compra, 'details' => $detalles]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontro la compra']);
        }
    }

    public static function getDeliveryPurchases() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isset($_GET['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        if (!isset($_GET['max'])) {
            $max = 5; // Valor por defecto
        } else {
            $max = (int)$_GET['max'];
            if ($max <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'El valor maximo debe ser mayor a 0']);
                return;
            }
        }

        $compras = Compra::getPurchases($max);

        // Obtener unicamente los id de las compras
        if ($compras) {
            foreach ($compras as $compra) {
                $deliveries[] = $compra->id;
                Compra::asignDelivery($compra->id, $_GET['id']);
            }
        }

        if ($compras) {
            echo json_encode(['status' => 'success', 'deliveries' => $deliveries]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No hay pedidos disponibles']);
        }
    }

    public static function getDeliveriesBetweenDates() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para ver las compras']);
            return;
        }

        if (!isset($_GET['desde']) || !isset($_GET['hasta'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $desde = $_GET['desde'];
        $hasta = $_GET['hasta'];

        $compras = Compra::betweenDates($desde, $hasta);

        foreach ($compras as $compra) {
            $compra->usuario = Usuario::where('id', $compra->id_usuario)->nombre;

            if ($compra->id_repartidor) {
                $repartidor = Repartidor::findById($compra->id_repartidor);
                $compra->repartidor = $repartidor->nombre . " " . $repartidor->apellido1 . " " . $repartidor->apellido2;
            } else {
                $compra->repartidor = "No asignado";
            }

            if (!$compra->entregado) {
                $compra->entregado = "Sin entregar";
            }

            if ($compra->estatus) {
                $compra->estatus = "Entregado";
            } else {
                $compra->estatus = "Pendiente";
            }

            if ($compra->id_tarjeta == 9999) {
                $compra->pago = "Efectivo";
            } else {
                $compra->pago = "Tarjeta";
            }
        }

        if ($compras) {
            echo json_encode(['status' => 'success', 'deliveries' => $compras]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron entregas en el periodo especificado']);
        }
    }
}
?>