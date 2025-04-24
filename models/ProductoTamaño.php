<?php

namespace Model;

class ProductoTamaño {
    private static $tabla = 'producto_tamaño';
    
    public $id_producto;
    public $id_tamaño;
    public $precio;
    public $existencia;

    public function __construct($args = []) {
        $this->id_producto = $args['id_producto'] ?? null;
        $this->id_tamaño = $args['id_tamaño'] ?? null;
        $this->precio = $args['precio'] ?? 0;
        $this->existencia = $args['existencia'] ?? 0;
    }

    public static function getByIdProducto($id_producto) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE id_producto = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_producto);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $sizes = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $sizes[] = new ProductoTamaño($row);
                }
                
                return $sizes;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function where($column, $value) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE $column = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $value);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $sizes = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $sizes[] = new ProductoTamaño($row);
                }
                
                return $sizes;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>