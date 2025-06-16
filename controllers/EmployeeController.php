<?php

namespace Controller;

use App\Router;
use Model\Usuario;
use Model\TipoUsuario;

class EmployeeController {
    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $Usuario = Usuario::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['estatus'])) {
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
            } else if (isset($_POST['confirmed'])) {
                $Usuario = new Usuario();
                
                $Usuario->id = $_POST['id'];
                $Usuario->confirmado = $_POST['confirmed'];
            
                if ($Usuario->changeConfirmation()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                    exit;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
                    exit;
                }
            }
        }

        $router->render('administrator/employee', [
            'Usuario' => $Usuario
        ]);
    }
    public static function create(Router $router) {
        require __DIR__ . '/../includes/database.php';
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $tiposUsuario = TipoUsuario::all();

        if (!$tiposUsuario) {
            header('Location: /admin/usuario');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Usuario = new Usuario();
            
            $Usuario->nombre = $_POST['nombre'] ;
            $Usuario->edad = $_POST['edad'] ;
            $Usuario->correo = $_POST['correo'] ;
            $Usuario->usuario = $_POST['usuario'] ;
            $Usuario->contraseña = $_POST['contraseña'] ;
            $Usuario->id_tipo_usuario = 4 ;
            $Usuario->estatus = $_POST['estatus'] ?? 1;
            
            // Generar NFC ID único
            function generateNfcId($length = 8) {
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $nfc = '';
                for ($i = 0; $i < $length; $i++) {
                    $nfc .= $chars[random_int(0, strlen($chars) - 1)];
                }
                return $nfc;
            }

            do {
                $nfc_id = generateNfcId();
                $query = "SELECT COUNT(*) FROM usuario WHERE nfc_id = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, 's',$nfc_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($result);
                $exists = $row[0] > 0;
            } while ($exists);

            $Usuario->nfc_id = $nfc_id;

            $Usuario->id_tipo_usuario =4;

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

        $router->render('administrator/employee-create', [
            'tiposUsuario' => $tiposUsuario
        ]);
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

        $tiposUsuario = TipoUsuario::all();

        if (!$tiposUsuario) {
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
            $usuarioBD->id_tipo_usuario = $_POST['id_tipo_usuario'] ?? $usuarioBD->id_tipo_usuario;
            $usuarioBD->estatus = $_POST['nfc_id'] ?? $usuarioBD->nfc_id;

            // Solo actualizar la contraseña si se proporciona una nueva
            if (!empty($_POST['contraseña'])) {
                $usuarioBD->contraseña = $_POST['contraseña'];
            } else {
                $usuarioBD->contraseña = null;
            }

            // Buscar el correo en la base de datos para verificar si ya existe
            $usuarioExistente = Usuario::find('correo', $usuarioBD->correo);
            if ($usuarioExistente && $usuarioExistente->id !== $usuarioBD->id) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'El correo ya esta registrado']);
                exit;
            }

            // Buscar el usuario en la base de datos para verificar si ya existe
            $usuarioExistente = Usuario::find('usuario', $usuarioBD->usuario);
            if ($usuarioExistente && $usuarioExistente->id !== $usuarioBD->id) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'El usuario ya esta registrado']);
                exit;
            }

            $result = $usuarioBD->update();

            if ($result === true) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'updatedData' => [
                        'nombre' => $usuarioBD->nombre,
                        'edad' => $usuarioBD->edad,
                        'correo' => $usuarioBD->correo,
                        'usuario' => $usuarioBD->usuario,
                        'id_tipo_usuario' => $usuarioBD->id_tipo_usuario
                    ]
                ]);
                exit;
            } else if ($result === false) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'No se realizo ningun cambio']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => "$result"]);
                exit;
            }
        }

        $router->render('administrator/employee-edit', [
            'usuarioBD' => $usuarioBD,
            'tiposUsuario' => $tiposUsuario
        ]);
    }
}
?>