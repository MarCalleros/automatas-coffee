<?php
namespace Controller;

use Model\Estadisticas;

class APIProductSearch {
    
    public static function buscarProductos() {
        try {
            $query = $_GET['q'] ?? '';
            
            if (empty($query)) {
                self::sendJsonResponse(['productos' => []]);
                return;
            }
            
            $productos = self::searchProductsInDatabase($query);
            
            self::sendJsonResponse(['productos' => $productos]);
            
        } catch (\Exception $e) {
            self::sendJsonError("Error al buscar productos: " . $e->getMessage());
        }
    }
    
    private static function searchProductsInDatabase($query) {
        require __DIR__ . '/../includes/database.php';
        if (mysqli_connect_errno()) {
        throw new \Exception("Error de conexión a la base de datos: " . mysqli_connect_error());
    }
        
        try {
            $searchTerm = '%' . $query . '%';
            $sql = "SELECT 
                        p.id,
                        p.nombre,
                        p.estatus,
                        c.nombre as categoria,
                        COALESCE(SUM(dc.cantidad), 0) * 1 as total_vendido,
                        COALESCE(SUM(dc.subtotal), 0) * 1.0 as total_ingresos
                    FROM producto p
                    LEFT JOIN producto_categoria pc ON p.id = pc.id_producto
                    LEFT JOIN categoria c ON pc.id_categoria = c.id
                    LEFT JOIN detalle_compra dc ON p.id = dc.id_producto
                    LEFT JOIN compra co ON dc.id_compra = co.id AND co.estatus = 1
                    WHERE p.nombre LIKE ?
                    GROUP BY p.id, p.nombre, p.estatus, c.nombre
                    ORDER BY total_vendido DESC, p.nombre ASC
                    LIMIT 20";
            
            $stmt = mysqli_prepare($db, $sql);
            mysqli_stmt_bind_param($stmt, 's', $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $productos = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $productos[] = [
                    'id' => (int)$row['id'],
                    'nombre' => $row['nombre'],
                    'categoria' => $row['categoria'],
                    'estatus' => (bool)$row['estatus'],
                    'total_vendido' => (int)$row['total_vendido'],
                    'total_ingresos' => (float)$row['total_ingresos']
                ];
            }
            
            return $productos;
            
        } catch (\Exception $e) {
            throw new \Exception("Error en la consulta de búsqueda: " . $e->getMessage());
        }
    }
    
    private static function sendJsonResponse($data) {
        // Limpiar cualquier salida previa
        while (ob_get_level()) ob_end_clean();
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        http_response_code(200);
        echo json_encode($data);
        exit;
    }
    
    private static function sendJsonError($message, $code = 500) {
        http_response_code($code);
        self::sendJsonResponse(['error' => $message]);
    }

    public static function getProductStats($router, $productId) {
    try {
        if (ob_get_length()) ob_clean();
        require __DIR__ . '/../includes/database.php';

        $productId = (int)$productId;

        if ($productId <= 0) {
            throw new \Exception("ID de producto inválido");
        }

        if (!($db instanceof \mysqli)) {
            throw new \Exception("Error de conexión a la base de datos");
        }

        $stmt = $db->prepare("
            SELECT 
                p.nombre,
                pt.precio AS precio_unitario, 
                CAST(COALESCE(SUM(pt.existencia), 0) AS UNSIGNED) AS stock_total,
                CAST(COALESCE(SUM(dc.cantidad), 0) AS UNSIGNED) AS total_vendido,
                CAST(COALESCE(SUM(dc.subtotal), 0) AS DECIMAL(10,2)) AS total_ingresos
            FROM producto p
            LEFT JOIN producto_tamaño pt ON p.id = pt.id_producto 
            LEFT JOIN detalle_compra dc ON p.id = dc.id_producto
            LEFT JOIN compra co ON dc.id_compra = co.id AND co.estatus = 1
            WHERE p.id = ?
            GROUP BY p.id, pt.precio;
        ");


        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc() ?? [
            'nombre' => 'Producto no encontrado',
            'stock_total' => 0,
            'precio_unitario' => 0.00,
            'total_vendido' => 0,
            'total_ingresos' => 0.00
        ];

        $data['stock_total'] = (int)$data['stock_total'];
        $data['precio_unitario'] = (float)$data['precio_unitario'];
        $data['total_vendido'] = (int)$data['total_vendido'];
        $data['total_ingresos'] = (float)$data['total_ingresos'];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;

    } catch (\Exception $e) {
        self::sendJsonError($e->getMessage());
    }
}
}
?>
