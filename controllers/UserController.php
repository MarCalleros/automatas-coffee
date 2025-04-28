<?php

namespace Controller;

use App\Router;
use Model\Usuario;

class UserController {
    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $Usuario = Usuario::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Usuario = new Usuario();
            
            $Usuario->id = $_POST['id'];
            $Usuario->estatus = $_POST['estatus'];
        
            if ($Usuario->changeStatus()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
                exit;
            }
        }

        $router->render('administrator/user', [
            'Usuario' => $Usuario
        ]);
    }

    public static function create(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Usuario = new Usuario();
            
            $Usuario->nombre = $_POST['nombre'] ;
            $Usuario->edad = $_POST['edad'] ;
            $Usuario->correo = $_POST['correo'] ;
            $Usuario->usuario = $_POST['usuario'] ;
            $Usuario->contraseña = $_POST['contraseña'] ;
            $Usuario->id_tipo_usuario = $_POST['id_tipo_usuario'] ?? 2 ;
            $Usuario->estatus = $_POST['estatus'] ?? 1;

            $result = $Usuario->save();
        
            if ($result === true) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => "$result"]);
                exit;
            }
        }

        $router->render('administrator/user-create', []);
    }

    public static function edit(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/usuario');
            exit;
        }

        $usuarioBD = Usuario::findById($id);
        if (!$usuarioBD) {
            header('Location: /admin/usuario');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioBD->nombre = $_POST['nombre'] ?? $usuarioBD->nombre;
            $usuarioBD->edad = $_POST['edad'] ?? $usuarioBD->edad;
            $usuarioBD->correo = $_POST['correo'] ?? $usuarioBD->correo;
            $usuarioBD->usuario = $_POST['usuario'] ?? $usuarioBD->usuario;

            // Solo actualizar la contraseña si se proporciona una nueva
            if (!empty($_POST['contraseña'])) {
                $usuarioBD->contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
            }

            $resultado = $usuarioBD->update();

            if ($resultado) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'No se realizo ningun cambio']);
            }
        }

        $router->render('administrator/user-edit', [
            'usuarioBD' => $usuarioBD,
            'error' => $error ?? null
        ]);
    }
}
?>