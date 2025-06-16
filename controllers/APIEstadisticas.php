<?php
namespace Controller;

use Model\Estadisticas;

class APIEstadisticas {
    private static function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    private static function sendJsonError($message, $code = 500) {
        http_response_code($code);
        self::sendJsonResponse(['error' => $message]);
    }

    public static function graficas() {
        try {
            $datos = [
                'productosMasVendidos' => Estadisticas::getProductosMasVendidos(),
                'productosMenosVendidos' => Estadisticas::getProductosMenosVendidos(),
                'productosMasIngresos' => Estadisticas::getProductosMasIngresos(),
                'productosMenosIngresos' => Estadisticas::getProductosMenosIngresos(),
                'clientesMasCompras' => Estadisticas::getClientesMasCompras(),
                'clientesMasIngresos' => Estadisticas::getClientesMasIngresos()
            ];
            
            self::sendJsonResponse($datos);
        } catch (\Exception $e) {
            self::sendJsonError("Error al obtener datos para gráficas: " . $e->getMessage());
        }
    }

    public static function productosVendidos() {
        try {
            $pagina = $_GET['pagina'] ?? 1;
            $resultado = Estadisticas::getProductosVendidosPaginados($pagina);
            self::sendJsonResponse($resultado);
        } catch (\Exception $e) {
            self::sendJsonError("Error al obtener productos vendidos: " . $e->getMessage());
        }
    }

    public static function productosIngresos() {
        try {
            $pagina = $_GET['pagina'] ?? 1;
            $resultado = Estadisticas::getProductosIngresosPaginados($pagina);
            self::sendJsonResponse($resultado);
        } catch (\Exception $e) {
            self::sendJsonError("Error al obtener ingresos por productos: " . $e->getMessage());
        }
    }

    public static function clientesCompras() {
        try {
            $pagina = $_GET['pagina'] ?? 1;
            $resultado = Estadisticas::getClientesComprasPaginados($pagina);
            self::sendJsonResponse($resultado);
        } catch (\Exception $e) {
            self::sendJsonError("Error al obtener clientes por compras: " . $e->getMessage());
        }
    }

    public static function clientesIngresos() {
        try {
            $pagina = $_GET['pagina'] ?? 1;
            $resultado = Estadisticas::getClientesIngresosPaginados($pagina);
            self::sendJsonResponse($resultado);
        } catch (\Exception $e) {
            self::sendJsonError("Error al obtener clientes por ingresos: " . $e->getMessage());
        }
    }

    public static function ventasPeriodo() {
        try {
            $pagina = $_GET['pagina'] ?? 1;
            $periodo = $_GET['periodo'] ?? 'dia';
            
            // Parámetros adicionales para período personalizado
            $params = [];
            if ($periodo === 'personalizado') {
                $params['fecha_inicio'] = $_GET['fecha_inicio'] ?? null;
                $params['fecha_fin'] = $_GET['fecha_fin'] ?? null;
                
                // Validar que ambas fechas estén presentes
                if (!$params['fecha_inicio'] || !$params['fecha_fin']) {
                    self::sendJsonError("Se requieren ambas fechas para el período personalizado", 400);
                    return;
                }
            }
            
            $resultado = Estadisticas::getVentasPeriodoPaginados($periodo, $pagina, 10, $params);
            self::sendJsonResponse($resultado);
        } catch (\Exception $e) {
            self::sendJsonError("Error al obtener ventas por período: " . $e->getMessage());
        }
    }
}
?>