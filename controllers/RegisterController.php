<?php
namespace Controller;

use App\Router;
use Model\Historyregister;

class RegisterController {
    public static function historial(Router $router) {
        // Parámetros de filtrado (por defecto)
        $desde = $_GET['desde'] ?? null;
        $hasta = $_GET['hasta'] ?? null;
        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        $registros_por_pagina = 10;
        
        // Obtener registros
        $registros = Historyregister::obtenerRegistros($desde, $hasta, $pagina, $registros_por_pagina);
        $total_registros = Historyregister::contarRegistros($desde, $hasta);
        $total_paginas = ceil($total_registros / $registros_por_pagina);
        
        $router->render('administrator/historyregister', [
            'registros' => $registros,
            'paginacion' => [
                'pagina_actual' => $pagina,
                'total_paginas' => $total_paginas,
                'total_registros' => $total_registros
            ],
            'filtros' => [
                'desde' => $desde,
                'hasta' => $hasta
            ]
        ]);
    }
}
?>