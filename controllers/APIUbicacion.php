<?php

namespace Controller;

use Model\Ubicacion;
use Model\Repartidor;

class APIUbicacion {
    public static function send() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para enviar un mensaje']);
            return;
        }
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($data['content'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $mensaje = new Mensaje();
        $mensaje->id_usuario = $_SESSION['id'];
        $mensaje->contenido = $data['content'];
    
        $result = $mensaje->create();
    
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje']);
        }
    }

    //public static function 
}
?>