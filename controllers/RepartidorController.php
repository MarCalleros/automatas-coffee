<?php

namespace Controller;

use App\Router;
use Model\Repartidor;

class RepartidorController {
    public static function index(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        $repartidores = Repartidor::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $repartidor = new Repartidor();
            
            $repartidor->id = $_POST['id'];
            $repartidor->estatus = $_POST['estatus'];
        
            if ($repartidor->changeStatus()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
                exit;
            }
        }

        $router->render('administrator/deliveryman', [
            'repartidores' => $repartidores
        ]);
    }

    public static function create(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $repartidor = new Repartidor();
            
            $repartidor->nombre = $_POST['nombre'];
            $repartidor->apellido1 = $_POST['apellido1'];
            $repartidor->apellido2 = $_POST['apellido2'];
            $repartidor->telefono = $_POST['telefono'];
            $repartidor->curp = $_POST['curp'];
            $repartidor->rfc = $_POST['rfc'];
            $repartidor->tipo_sangre = $_POST['tipo_sangre'];
            $repartidor->nss = $_POST['nss'];
            $repartidor->vigencia_licencia = $_POST['vigencia'];
        
            $result = $repartidor->save();
        
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

        $router->render('administrator/deliveryman-create', []);
    }

    public static function edit(Router $router) {
        if (!isAdmin()) {
            header('Location: /');
            exit;
        }
        
        if (!isset($_GET['id'])) {
            header('Location: /admin/deliveryman');
            exit;
        }
        
        $repartidorBD = new Repartidor();
        $repartidorBD = $repartidorBD::findById($_GET['id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $repartidor = new Repartidor();
            
            $repartidor->id = $_POST['id'];
            $repartidor->nombre = $_POST['nombre'];
            $repartidor->apellido1 = $_POST['apellido1'];
            $repartidor->apellido2 = $_POST['apellido2'];
            $repartidor->telefono = $_POST['telefono'];
            $repartidor->curp = $_POST['curp'];
            $repartidor->rfc = $_POST['rfc'];
            $repartidor->tipo_sangre = $_POST['tipo_sangre'];
            $repartidor->nss = $_POST['nss'];
            $repartidor->vigencia_licencia = $_POST['vigencia'];
        
            $result = $repartidor->update();
        
            if ($result === true) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'updatedData' => [
                        'nombre' => $repartidor->nombre,
                        'apellido1' => $repartidor->apellido1,
                        'apellido2' => $repartidor->apellido2,
                        'telefono' => $repartidor->telefono,
                        'curp' => $repartidor->curp,
                        'rfc' => $repartidor->rfc,
                        'tipo_sangre' => $repartidor->tipo_sangre,
                        'nss' => $repartidor->nss,
                        'vigencia_licencia' => $repartidor->vigencia_licencia
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

        $router->render('administrator/deliveryman-edit', [
            'repartidorBD' => $repartidorBD
        ]);
    }
}
?>