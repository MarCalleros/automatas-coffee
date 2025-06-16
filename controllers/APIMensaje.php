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
            foreach ($mensajes as $mensaje) {
                if ($mensaje->id_mensaje || $mensaje->estatus == 0) { // Si es una respuesta o el estatus es 0, quitarla de la lista
                    unset($mensajes[array_search($mensaje, $mensajes)]);
                }
            }

            // Checar si quedo vacio el array
            if (empty($mensajes)) {
                echo json_encode(['status' => 'error', 'message' => 'No se encontraron mensajes']);
                return;
            }

            // Reindexar el array
            $mensajes = array_values($mensajes);

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

        if ($mensajes) {
            if ($mensajes[0]->id_usuario !== $_SESSION['id']) { // Comprobar si el mensaje pertenece al usuario
                echo json_encode(['status' => 'error', 'message' => 'No se encontro el mensajes']);
                return;
            }

            if ($mensajes[0]->estatus == 0) { // Comprobar si el mensaje esta eliminado
                echo json_encode(['status' => 'error', 'message' => 'No se encontro el mensajes']);
                return;
            }

            if ($mensajes[0]->id_mensaje) { // Si es una respuesta, redirigir al mensaje original
                $mensajes = Mensaje::where('id', $mensajes[0]->id_mensaje);
            }

            
            if ($mensajes[0]->id_usuario !== $_SESSION['id']) { // Comprobar si el mensaje pertenece al usuario
                echo json_encode(['status' => 'error', 'message' => 'No se encontro el mensajes']);
                return;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontro el mensajes']);
            return;
        }

        $respuestas = Mensaje::where('id_mensaje', $mensajes[0]->id);
        if ($respuestas) {
            foreach ($respuestas as $respuesta) {
                $respuesta->usuario = Usuario::where('id', $respuesta->id_usuario);
                $respuesta->usuario->id_tipo_usuario = null;
                $respuesta->usuario->edad = null;
                $respuesta->usuario->usuario = null;
                $respuesta->usuario->contraseña = null;

                if ($respuesta->estatus == 0) { // Si esta eliminado, quitarla de la lista
                    unset($respuestas[array_search($respuesta, $respuestas)]);
                }

                // Reindexar el array
                $respuestas = array_values($respuestas);
            }
        }

        if ($mensajes) {
            echo json_encode(['status' => 'success', 'user' => $usuario, 'messages' => $mensajes, 'responses' => $respuestas]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontro el mensajes']);
        }
    }

    public static function responseMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para enviar un mensaje']);
            return;
        }
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($data['identifier'], $data['content'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $msjOriginal = new Mensaje();
        $msjOriginal = Mensaje::where('identificador', $data['identifier']);

        if (!$msjOriginal) {
            echo json_encode(['status' => 'error', 'message' => 'Mensaje no encontrado']);
            return;
        }

        $mensaje = new Mensaje();
        $mensaje->id_mensaje = $msjOriginal[0]->id;
        $mensaje->id_usuario = $_SESSION['id'];
        $mensaje->contenido = $data['content'];

        $result = $mensaje->create();

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje']);
        }
    }

    public static function deleteMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (!isLogged()) {
            echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión para enviar un mensaje']);
            return;
        }
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($data['identifier'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $mensaje = Mensaje::where('identificador', $data['identifier']);

        if (!$mensaje) {
            echo json_encode(['status' => 'error', 'message' => 'Mensaje no encontrado']);
            return;
        }

        $mensaje[0]->estatus = 0;
        $result = $mensaje[0]->changeStatus();

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Mensaje eliminado exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el mensaje']);
        }
    }
}
?>