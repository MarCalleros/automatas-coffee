<?php

namespace Model;

class ProductoCategoria {
    private static $tabla = 'producto_categoria';
    
    public $id_producto;
    public $id_categoria;

    public function __construct($args = []) {
        $this->id_producto = $args['id_producto'] ?? null;
        $this->id_categoria = $args['id_categoria'] ?? null;
    }

    public static function getByIdCategoria($id_categoria) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE id_categoria = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_categoria);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $categories = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $categories[] = new ProductoCategoria($row);
                }
                
                return $categories;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>