<?php

namespace Controller;

use App\Router;
use Model\HistoryRegister;

class HistoryController {
    
    public static function index(Router $router) {
        // Obtener parámetros de filtrado
        $filtros = [
            'desde' => $_GET['desde'] ?? null,
            'hasta' => $_GET['hasta'] ?? null
        ];
        
        // Configuración de paginación
        $registros_por_pagina = 10;
        $pagina_actual = $_GET['pagina'] ?? 1;
        
        // Obtener registros
        $registros = HistoryRegister::obtenerRegistros(
            $filtros['desde'],
            $filtros['hasta'],
            $pagina_actual,
            $registros_por_pagina
        );
        
        // Contar total de registros
        $total_registros = HistoryRegister::contarRegistros(
            $filtros['desde'],
            $filtros['hasta']
        );
        
        // Calcular paginación
        $paginacion = [
            'total_registros' => $total_registros,
            'registros_por_pagina' => $registros_por_pagina,
            'pagina_actual' => $pagina_actual,
            'total_paginas' => ceil($total_registros / $registros_por_pagina)
        ];
        
        // Renderizar vista
        $router->render('historyregister/index', [
            'registros' => $registros,
            'filtros' => $filtros,
            'paginacion' => $paginacion
        ]);
    }
    
    public static function deleteRegistro() {
    header('Content-Type: application/json');
    
    $requestUri = $_SERVER['REQUEST_URI'];
    $basePath = '/api/history/delete/';
    
    if (strpos($requestUri, $basePath) === 0) {
        $id = substr($requestUri, strlen($basePath));
    } else {
        $id = null;
    }
    
    if (!$id || !ctype_digit($id)) {
        echo json_encode(['success' => false, 'message' => 'ID no válido']);
        exit;
    }

    if (HistoryRegister::delete($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el registro']);
    }
}
}