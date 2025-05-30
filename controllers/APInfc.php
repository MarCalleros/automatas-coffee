<?php

namespace Controller;

use Model\Usuario;
use Model\HistoryRegister;

class APInfc {
    public static function getNFClogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['nfcId']) || empty($data['nfcId'])) {
            echo json_encode(['status' => 'error', 'message' => 'NFC ID no proporcionado']);
            return;
        }

        $nfcId = $data['nfcId'];
        $Usuario = new Usuario();
        $Usuario -> loginnfc($nfcId);

        echo json_encode([
            'status' => 'success',
            'message' => $nfcId,
        ]);
    }
    public static function getNFClogout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
        if (!isset($_SESSION)) {
                        session_start();
        }
        $logoutnfc = $_SESSION['nfc'];

        echo json_encode([
            'status' => 'success',
            'message' => $logoutnfc,
        ]);
    }

    public static function registerLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['nfcId']) || empty($data['nfcId'])) {
            echo json_encode(['status' => 'error', 'message' => 'NFC ID no proporcionado']);
            return;
        }
        $nfcId = $data['nfcId'];
        
        $usuario = Usuario::findByNfcId($nfcId);

        if ($usuario && $usuario->id_tipo_usuario == 4) {
            $fecha = date('Y-m-d');
            $hora_entrada = date('H:i:s');

            
            $registro = new HistoryRegister();
            $registro->id_empleado = $usuario->id;
            $registro->nombre_empleado = $usuario->nombre;
            $registro->fecha = $fecha;
            $registro->hora_entrada = $hora_entrada;

            if ($registro->create()) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Entrada registrada']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar la entrada']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Empleado no encontrado o no autorizado']);
            exit;
        }
        echo json_encode([
            'status' => 'success',
            'message' => $nfcId,
        ]);
    }

    public static function registerLogout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['nfcId']) || empty($data['nfcId'])) {
            echo json_encode(['status' => 'error', 'message' => 'NFC ID no proporcionado']);
            return;
        }
        $nfcId = $data['nfcId'];

        $usuario = Usuario::findByNfcId($nfcId);

        if ($usuario && $usuario->id_tipo_usuario == 4) {
            $fecha = date('Y-m-d');
            $hora_salida = date('H:i:s');   

            
            $registro = HistoryRegister::findByEmpleadoAndFecha($usuario->id, $fecha);
            if ($registro) {
                $registro->hora_salida = $hora_salida;

                if ($registro->update()) {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Salida registrada']);
                    exit;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'error', 'message' => 'Error al registrar la salida']);

                    exit;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'No se encontró un registro de entrada para actualizar']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Empleado no encontrado o no autorizado']);
        }
    }

}
?>