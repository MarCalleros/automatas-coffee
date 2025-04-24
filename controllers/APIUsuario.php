<?php

namespace Controller;

use Model\Usuario;

class APIUsuario {
    public static function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($data['name'], $data['age'], $data['email'], $data['username'], $data['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        // Primero validar que el correo no este repetido con otro usuario
        if (Usuario::where('correo', $data['email'])) {
            echo json_encode(['status' => 'error', 'message' => 'El correo ya esta registrado']);
            return;
        }

        // Luego validar que el nombre de usuario no este repetido con otro usuario
        if (Usuario::where('usuario', $data['username'])) {
            echo json_encode(['status' => 'error', 'message' => 'El nombre de usuario ya esta registrado']);
            return;
        }
    
        $usuario = new Usuario();
        $usuario->nombre = $data['name'];
        $usuario->edad = $data['age'];
        $usuario->correo = $data['email'];
        $usuario->usuario = $data['username'];
        $usuario->contraseña = $data['password'];
    
        $result = $usuario->create();
    
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario creado exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al crear el usuario']);
        }
    }
    
    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (!isset($data['username'], $data['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }
    
        $usuario = new Usuario();
        $usuario->usuario = $data['username'];
        $usuario->contraseña = $data['password'];
    
        $result = $usuario->login();
    
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Inicio de sesion exitoso']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuario o contraseña incorrectos']);
        }
    }

    public static function logout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }

        if (isLogged()) {
            session_destroy();
            echo json_encode(['status' => 'success', 'message' => 'Sesión cerrada exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No hay sesión activa']);
        }
    }
}
?>