<?php
namespace Controller;

use Model\Historyregister;
use Model\Empleado;

class APIRegistro {

    /**
     * Obtiene los registros con filtros y paginación
     */
    public static function obtener() {
        // Parámetros de filtrado
        $desde = $_GET['desde'] ?? null;
        $hasta = $_GET['hasta'] ?? null;
        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        $registros_por_pagina = 10;
        
        // Obtener registros
        $registros = Historyregister::obtenerRegistros($desde, $hasta, $pagina, $registros_por_pagina);
        $total_registros = Historyregister::contarRegistros($desde, $hasta);
        $total_paginas = ceil($total_registros / $registros_por_pagina);
        
        // Preparar la respuesta
        echo json_encode([
            'status' => 'success',
            'registros' => $registros,
            'paginacion' => [
                'pagina_actual' => $pagina,
                'total_paginas' => $total_paginas,
                'total_registros' => $total_registros
            ]
        ]);
    }

    /**
     * Registra entrada o salida de un empleado
     */
    public static function registrar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['empleado_id'], $data['tipo_registro'])) {
            echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos']);
            return;
        }

        $empleado_id = $data['empleado_id'];
        $tipo_registro = $data['tipo_registro']; // 'entrada' o 'salida'

        // Validar tipo de registro
        if ($tipo_registro !== 'entrada' && $tipo_registro !== 'salida') {
            echo json_encode(['status' => 'error', 'message' => 'Tipo de registro no válido']);
            return;
        }

        $registro = new Historyregister();
        
        if ($tipo_registro === 'entrada') {
            $resultado = $registro->registrarEntrada($empleado_id);
            
            if ($resultado === true) {
                echo json_encode(['status' => 'success', 'message' => 'Entrada registrada correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $resultado]);
            }
        } else {
            $resultado = $registro->registrarSalida($empleado_id);
            
            if ($resultado === true) {
                echo json_encode(['status' => 'success', 'message' => 'Salida registrada correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $resultado]);
            }
        }
    }

    /**
     * Registra entrada o salida mediante NFC
     */
    public static function registrarNFC() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['codigo_nfc'])) {
            echo json_encode(['status' => 'error', 'message' => 'Falta el código NFC']);
            return;
        }

        $codigo_nfc = $data['codigo_nfc'];
        
        // Buscar empleado por código NFC
        $empleado = new Empleado();
        $empleado_encontrado = $empleado->buscarPorNFC($codigo_nfc);
        
        if (!$empleado_encontrado) {
            echo json_encode(['status' => 'error', 'message' => 'Código NFC no válido o empleado inactivo']);
            return;
        }
        
        // Determinar si es entrada o salida
        $registro = new Historyregister();
        $tiene_entrada_sin_salida = $registro->tieneEntradaSinSalida($empleado->id);
        
        if ($tiene_entrada_sin_salida) {
            // Registrar salida
            $resultado = $registro->registrarSalida($empleado->id);
            
            if ($resultado === true) {
                echo json_encode(['status' => 'success', 'message' => 'Salida registrada correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $resultado]);
            }
        } else {
            // Registrar entrada
            $resultado = $registro->registrarEntrada($empleado->id);
            
            if ($resultado === true) {
                echo json_encode(['status' => 'success', 'message' => 'Entrada registrada correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $resultado]);
            }
        }
    }

    /**
     * Elimina un registro
     */
    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Falta el ID del registro']);
            return;
        }

        $registro = new Historyregister();
        $registro->id = $data['id'];
        
        $resultado = $registro->eliminar();
        
        if ($resultado === true) {
            echo json_encode(['status' => 'success', 'message' => 'Registro eliminado correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $resultado]);
        }
    }
}
?>
