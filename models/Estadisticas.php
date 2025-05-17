<?php

namespace Model;

class Estadisticas {
    protected static $conn;

    public static function setConnection($conn) {
        self::$conn = $conn;
    }

    // Productos
    public static function getProductosMasVendidos($limit = 5) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT p.nombre, SUM(dc.cantidad) as cantidad_vendida 
                        FROM detalle_compra dc 
                        JOIN producto p ON dc.id_producto = p.id 
                        JOIN compra c ON dc.id_compra = c.id
                        WHERE c.estatus = 'entregado'
                        GROUP BY p.id 
                        ORDER BY cantidad_vendida DESC 
                        LIMIT ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $limit);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            return $data;
        } catch (\Exception $e) {
            return [];
        } finally {
            // Reactivar reporte de errores
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getProductosMenosVendidos($limit = 5) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT p.nombre, SUM(dc.cantidad) as cantidad_vendida 
                        FROM detalle_compra dc 
                        JOIN producto p ON dc.id_producto = p.id 
                        JOIN compra c ON dc.id_compra = c.id
                        WHERE c.estatus = 'entregado'
                        GROUP BY p.id 
                        ORDER BY cantidad_vendida ASC 
                        LIMIT ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $limit);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            return $data;
        } catch (\Exception $e) {
            return [];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getProductosMasIngresos($limit = 5) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT p.nombre, SUM(dc.subtotal) as ingresos 
                        FROM detalle_compra dc 
                        JOIN producto p ON dc.id_producto = p.id 
                        JOIN compra c ON dc.id_compra = c.id
                        WHERE c.estatus = 'entregado'
                        GROUP BY p.id 
                        ORDER BY ingresos DESC 
                        LIMIT ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $limit);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            return $data;
        } catch (\Exception $e) {
            return [];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getProductosMenosIngresos($limit = 5) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT p.nombre, SUM(dc.subtotal) as ingresos 
                        FROM detalle_compra dc 
                        JOIN producto p ON dc.id_producto = p.id 
                        JOIN compra c ON dc.id_compra = c.id
                        WHERE c.estatus = 'entregado'
                        GROUP BY p.id 
                        ORDER BY ingresos ASC 
                        LIMIT ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $limit);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            return $data;
        } catch (\Exception $e) {
            return [];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getProductosVendidosPaginados($pagina = 1, $porPagina = 10) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);
            
            $offset = ($pagina - 1) * $porPagina;
            
            $query = "SELECT p.id, p.nombre, SUM(dc.cantidad) as cantidad_vendida, 
                        ROUND(AVG(pt.precio), 2) as precio_promedio
                        FROM detalle_compra dc 
                        JOIN producto p ON dc.id_producto = p.id 
                        JOIN producto_tamaño pt ON p.id = pt.id_producto AND dc.id_tamaño = pt.id_tamaño
                        JOIN compra c ON dc.id_compra = c.id
                        WHERE c.estatus = 'entregado'
                        GROUP BY p.id 
                        ORDER BY cantidad_vendida DESC
                        LIMIT ? OFFSET ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $porPagina, $offset);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $items = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
            
            // Obtener el total de productos
            $queryTotal = "SELECT COUNT(DISTINCT p.id) as total 
                            FROM producto p 
                            JOIN detalle_compra dc ON p.id = dc.id_producto 
                            JOIN compra c ON dc.id_compra = c.id 
                            WHERE c.estatus = 'entregado'";
            
            $resultTotal = mysqli_query($db, $queryTotal);
            $total = mysqli_fetch_assoc($resultTotal)['total'] ?? 0;
            
            return [
                'items' => $items,
                'total' => $total,
                'total_paginas' => ceil($total / $porPagina),
                'pagina_actual' => (int)$pagina
            ];
        } catch (\Exception $e) {
            return [
                'items' => [],
                'total' => 0,
                'total_paginas' => 0,
                'pagina_actual' => (int)$pagina
            ];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getProductosIngresosPaginados($pagina = 1, $porPagina = 10) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);
            
            $offset = ($pagina - 1) * $porPagina;
            
            $query = "SELECT p.id, p.nombre, SUM(dc.subtotal) as ingresos, 
                        SUM(dc.cantidad) as cantidad_vendida 
                        FROM detalle_compra dc 
                        JOIN producto p ON dc.id_producto = p.id 
                        JOIN compra c ON dc.id_compra = c.id
                        WHERE c.estatus = 'entregado'
                        GROUP BY p.id 
                        ORDER BY ingresos DESC
                        LIMIT ? OFFSET ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $porPagina, $offset);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $items = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
            
            // Obtener el total de productos
            $queryTotal = "SELECT COUNT(DISTINCT p.id) as total 
                            FROM producto p 
                            JOIN detalle_compra dc ON p.id = dc.id_producto 
                            JOIN compra c ON dc.id_compra = c.id 
                            WHERE c.estatus = 'entregado'";
            
            $resultTotal = mysqli_query($db, $queryTotal);
            $total = mysqli_fetch_assoc($resultTotal)['total'] ?? 0;
            
            return [
                'items' => $items,
                'total' => $total,
                'total_paginas' => ceil($total / $porPagina),
                'pagina_actual' => (int)$pagina
            ];
        } catch (\Exception $e) {
            return [
                'items' => [],
                'total' => 0,
                'total_paginas' => 0,
                'pagina_actual' => (int)$pagina
            ];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    // Clientes
    public static function getClientesMasCompras($limit = 5) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT u.nombre, COUNT(c.id) as total_compras 
                        FROM usuario u 
                        JOIN compra c ON u.id = c.id_usuario 
                        WHERE c.estatus = 'entregado'
                        GROUP BY u.id 
                        ORDER BY total_compras DESC 
                        LIMIT ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $limit);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            return $data;
        } catch (\Exception $e) {
            return [];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getClientesMasIngresos($limit = 5) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT u.nombre, SUM(c.total) as total_ingresos 
                        FROM usuario u 
                        JOIN compra c ON u.id = c.id_usuario 
                        WHERE c.estatus = 'entregado'
                        GROUP BY u.id 
                        ORDER BY total_ingresos DESC 
                        LIMIT ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $limit);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            
            return $data;
        } catch (\Exception $e) {
            return [];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getClientesComprasPaginados($pagina = 1, $porPagina = 10) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);
            
            $offset = ($pagina - 1) * $porPagina;
            
            $query = "SELECT u.id, u.nombre, COUNT(c.id) as total_compras, 
                        MAX(c.fecha) as ultima_compra 
                        FROM usuario u 
                        JOIN compra c ON u.id = c.id_usuario 
                        WHERE c.estatus = 'entregado'
                        GROUP BY u.id 
                        ORDER BY total_compras DESC
                        LIMIT ? OFFSET ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $porPagina, $offset);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $items = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
            
            // Obtener el total de clientes
            $queryTotal = "SELECT COUNT(DISTINCT u.id) as total 
                            FROM usuario u 
                            JOIN compra c ON u.id = c.id_usuario 
                            WHERE c.estatus = 'entregado'";
            
            $resultTotal = mysqli_query($db, $queryTotal);
            $total = mysqli_fetch_assoc($resultTotal)['total'] ?? 0;
            
            return [
                'items' => $items,
                'total' => $total,
                'total_paginas' => ceil($total / $porPagina),
                'pagina_actual' => (int)$pagina
            ];
        } catch (\Exception $e) {
            return [
                'items' => [],
                'total' => 0,
                'total_paginas' => 0,
                'pagina_actual' => (int)$pagina
            ];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public static function getClientesIngresosPaginados($pagina = 1, $porPagina = 10) {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);
            
            $offset = ($pagina - 1) * $porPagina;
            
            $query = "SELECT u.id, u.nombre, SUM(c.total) as total_ingresos, 
                        COUNT(c.id) as compras_realizadas 
                        FROM usuario u 
                        JOIN compra c ON u.id = c.id_usuario 
                        WHERE c.estatus = 'entregado'
                        GROUP BY u.id 
                        ORDER BY total_ingresos DESC
                        LIMIT ? OFFSET ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $porPagina, $offset);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $items = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
            
            // Obtener el total de clientes
            $queryTotal = "SELECT COUNT(DISTINCT u.id) as total 
                            FROM usuario u 
                            JOIN compra c ON u.id = c.id_usuario 
                            WHERE c.estatus = 'entregado'";
            
            $resultTotal = mysqli_query($db, $queryTotal);
            $total = mysqli_fetch_assoc($resultTotal)['total'] ?? 0;
            
            return [
                'items' => $items,
                'total' => $total,
                'total_paginas' => ceil($total / $porPagina),
                'pagina_actual' => (int)$pagina
            ];
        } catch (\Exception $e) {
            return [
                'items' => [],
                'total' => 0,
                'total_paginas' => 0,
                'pagina_actual' => (int)$pagina
            ];
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    // Ventas por período
public static function getVentasPeriodoPaginados($periodo = 'dia', $pagina = 1, $porPagina = 10, $params = []) {
    require __DIR__ . '/../includes/database.php';
    $db->query("SET SESSION sql_mode = ''");

    try {
        mysqli_report(MYSQLI_REPORT_OFF);
        
        $offset = ($pagina - 1) * $porPagina;
        $query = "";
        $queryTotal = "";
        $queryParams = [];
        $queryTotalParams = [];
        
        if ($periodo === 'personalizado') {
            // Validar que existan los parámetros necesarios
            if (empty($params['fecha_inicio']) || empty($params['fecha_fin'])) {
                throw new \Exception("Se requieren fechas de inicio y fin para el período personalizado");
            }
            
            $fechaInicio = $params['fecha_inicio'];
            $fechaFin = $params['fecha_fin'];
            
            $query = "SELECT DATE(fecha) as periodo, COUNT(*) as total_ventas, 
                        SUM(total) as total_ingresos 
                        FROM compra 
                        WHERE estatus = 'entregado'
                        AND DATE(fecha) BETWEEN ? AND ?
                        GROUP BY DATE(fecha) 
                        ORDER BY DATE(fecha) DESC
                        LIMIT ? OFFSET ?";
            
            $queryTotal = "SELECT COUNT(DISTINCT DATE(fecha)) as total 
                            FROM compra 
                            WHERE estatus = 'entregado'
                            AND DATE(fecha) BETWEEN ? AND ?";
            
            $queryParams = [$fechaInicio, $fechaFin, $porPagina, $offset];
            $queryTotalParams = [$fechaInicio, $fechaFin];
        } else if ($periodo === 'dia') {
            $query = "SELECT DATE(fecha) as periodo, COUNT(*) as total_ventas, 
                        SUM(total) as total_ingresos 
                        FROM compra 
                        WHERE estatus = 'entregado'
                        GROUP BY DATE(fecha) 
                        ORDER BY DATE(fecha) DESC
                        LIMIT ? OFFSET ?";
            
            $queryTotal = "SELECT COUNT(DISTINCT DATE(fecha)) as total 
                            FROM compra 
                            WHERE estatus = 'entregado'";
            
            $queryParams = [$porPagina, $offset];
        } else if ($periodo === 'semana') {
            $query = "SELECT YEARWEEK(fecha, 1) as periodo_num, 
                        CONCAT(DATE_FORMAT(MIN(fecha), '%d/%m/%Y'), ' - ', DATE_FORMAT(MAX(fecha), '%d/%m/%Y')) as periodo,
                        COUNT(*) as total_ventas, 
                        SUM(total) as total_ingresos 
                        FROM compra 
                        WHERE estatus = 'entregado'
                        GROUP BY YEARWEEK(fecha, 1) 
                        ORDER BY YEARWEEK(fecha, 1) DESC
                        LIMIT ? OFFSET ?";
            
            $queryTotal = "SELECT COUNT(DISTINCT YEARWEEK(fecha, 1)) as total 
                            FROM compra 
                            WHERE estatus = 'entregado'";
            
            $queryParams = [$porPagina, $offset];
        } else if ($periodo === 'mes') {
            $query = "SELECT DATE_FORMAT(fecha, '%Y-%m') as periodo_num,
                        DATE_FORMAT(fecha, '%M %Y') as periodo, 
                        COUNT(*) as total_ventas, 
                        SUM(total) as total_ingresos 
                        FROM compra 
                        WHERE estatus = 'entregado'
                        GROUP BY DATE_FORMAT(fecha, '%Y-%m') 
                        ORDER BY DATE_FORMAT(fecha, '%Y-%m') DESC
                        LIMIT ? OFFSET ?";
            
            $queryTotal = "SELECT COUNT(DISTINCT DATE_FORMAT(fecha, '%Y-%m')) as total 
                            FROM compra 
                            WHERE estatus = 'entregado'";
            
            $queryParams = [$porPagina, $offset];
        }
        
        // Ejecutar la consulta principal
        $stmt = mysqli_prepare($db, $query);
        if (!$stmt) {
            throw new \Exception("Error en la preparación de la consulta: " . mysqli_error($db));
        }
        
        if (!empty($queryParams)) {
            // Determinar los tipos de parámetros
            $types = '';
            foreach ($queryParams as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
            
            mysqli_stmt_bind_param($stmt, $types, ...$queryParams);
        }
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new \Exception("Error al ejecutar la consulta: " . mysqli_stmt_error($stmt));
        }
        
        $result = mysqli_stmt_get_result($stmt);
        
        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
        
        // Ejecutar la consulta para obtener el total
        $stmtTotal = mysqli_prepare($db, $queryTotal);
        if (!$stmtTotal) {
            throw new \Exception("Error en la preparación de la consulta total: " . mysqli_error($db));
        }
        
        if (!empty($queryTotalParams)) {
            // Determinar los tipos de parámetros
            $typesTotal = '';
            foreach ($queryTotalParams as $param) {
                if (is_int($param)) {
                    $typesTotal .= 'i';
                } elseif (is_float($param)) {
                    $typesTotal .= 'd';
                } else {
                    $typesTotal .= 's';
                }
            }
            
            mysqli_stmt_bind_param($stmtTotal, $typesTotal, ...$queryTotalParams);
        }
        
        if (!mysqli_stmt_execute($stmtTotal)) {
            throw new \Exception("Error al ejecutar la consulta total: " . mysqli_stmt_error($stmtTotal));
        }
        
        $resultTotal = mysqli_stmt_get_result($stmtTotal);
        if (!$resultTotal) {
            throw new \Exception("Error al obtener el resultado total: " . mysqli_error($db));
        }
        
        $totalRow = mysqli_fetch_assoc($resultTotal);
        $total = $totalRow ? $totalRow['total'] : 0;
        
        return [
            'items' => $items,
            'total' => $total,
            'total_paginas' => ceil($total / $porPagina),
            'pagina_actual' => (int)$pagina,
            'periodo' => $periodo
        ];
    } catch (\Exception $e) {
        // Registrar el error para depuración
        error_log("Error en getVentasPeriodoPaginados: " . $e->getMessage());
        
        return [
            'items' => [],
            'total' => 0,
            'total_paginas' => 0,
            'pagina_actual' => (int)$pagina,
            'periodo' => $periodo,
            'error' => $e->getMessage()
        ];
    } finally {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
}
}
?>