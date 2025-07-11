<?php

namespace Controller;

use App\Router;
use Model\Mensaje;
use Model\Usuario;

class AdminMensajeController {

    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $mensajes = Mensaje::all();

        if ($mensajes) {
            foreach ($mensajes as $mensaje) {
                if ($mensaje->id_mensaje) {
                    $msjOriginal = Mensaje::where('id', $mensaje->id_mensaje);
                    $mensaje->identificador_mensaje = $msjOriginal[0]->identificador;
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['estatus'])) {
                $mensaje = new Mensaje();
            
                $mensaje->id = $_POST['id'];
                $mensaje->estatus = $_POST['estatus'];
            
                if ($mensaje->changeStatus()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                    exit;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
                    exit;
                }
            } else if (isset($_POST['leido'])){
                $mensaje = new Mensaje();
            
                $mensaje->id = $_POST['id'];
                $mensaje->leido = $_POST['leido'];
            
                if ($mensaje->changeView()) {
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

        $router->render('administrator/message', [
            'mensajes' => $mensajes
        ]);
    }

    public static function view(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        }

        $mensaje = Mensaje::where('id', $_GET['id']);
        $mensaje[0]->usuario = Usuario::where('id', $mensaje[0]->id_usuario); // Obtener el usuario relacionado
        $mensaje[0]->leido = 1;

        if (!$mensaje) {
            header('Location: /admin/message');
            exit;
        }

        if (!$mensaje[0]->changeView()) {
                echo json_encode(['success' => false, 'error' => "$result"]);
                exit;
            }

        $router->render('administrator/message-view', [
            'mensaje' => $mensaje
        ]);
    }
}
?>