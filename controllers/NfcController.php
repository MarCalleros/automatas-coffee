<?php
namespace Controller;
use App\Router;
use Model\Usuario;
use Model\HistoryRegister;

class NfcController {
    public static function registerLogin(Router $router) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nfcId = $_POST['nfcId'] ?? null;

        if (!$nfcId) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'NFC ID no proporcionado']);
            exit;
        }

        $usuario = Usuario::findByNfcId($nfcId);

        if ($usuario && $usuario->id_tipo_usuario == 4) {
            $fecha = date('Y-m-d');
            $hora_entrada = date('H:i:s');

            $registro = new HistoryRegister();
            $registro->id_empleado = $usuario->id;
            $registro->fecha = $fecha;
            $registro->hora_entrada = $hora_entrada;
            $registro->tipo_usuario = $usuario->id_tipo_usuario;

            if ($registro->create()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Entrada registrada']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Error al registrar la entrada']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Empleado no encontrado o no autorizado']);
            exit;
        }
    }
}

    public static function registerLogout(Router $router) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nfcId = $_POST['nfcId'] ?? null;

        if (!$nfcId) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'NFC ID no proporcionado']);
            exit;
        }

        $usuario = Usuario::findByNfcId($nfcId);

        if ($usuario && $usuario->id_tipo_usuario == 4) {
            $fecha = date('Y-m-d');
            $hora_salida = date('H:i:s');

            $registro = HistoryRegister::findByEmpleadoAndFecha($usuario->id, $fecha);
            if ($registro) {
                $registro->hora_salida = $hora_salida;

                if ($registro->update()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Salida registrada']);
                    exit;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Error al registrar la salida']);
                    exit;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'No se encontró un registro de entrada para actualizar']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Empleado no encontrado o no autorizado']);
            exit;
        }
    }
}

}