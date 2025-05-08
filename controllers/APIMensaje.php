<?php

namespace Controller;

use Model\Mensaje;
use Model\Usuario;

class APIMensaje {
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

    public static function getUserMessages() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para ver los mensajes']);
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

        $mensajes = Mensaje::where('id_usuario', $_SESSION['id']);

        if ($mensajes) {
            echo json_encode(['status' => 'success', 'user' => $usuario, 'messages' => $mensajes]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron mensajes']);
        }
    }

    public static function getDetailMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para ver los mensajes']);
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

        $mensajes = Mensaje::where('identificador', $_GET['identifier']);

        // Comprobar si el mensaje pertenece al usuario
        if ($mensajes) {
            foreach ($mensajes as $mensaje) {
                if ($mensaje->id_usuario !== $_SESSION['id']) {
                    echo json_encode(['status' => 'error', 'message' => 'No se encontro el mensajes']);
                    return;
                }
            }
        }

        if ($mensajes) {
            echo json_encode(['status' => 'success', 'user' => $usuario, 'messages' => $mensajes]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontro el mensajes']);
        }
    }
}
?>