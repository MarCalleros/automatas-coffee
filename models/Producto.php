<?php

namespace Model;

class Producto {
    private static $tabla = 'producto';
    
    public $id;
    public $nombre;
    public $ruta;
    public $descripcion;
    public $estatus;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->ruta = $args['ruta'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->estatus = $args['estatus'] ?? 1;
    }

    public static function list() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE estatus = 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $products = [];
    
                while ($row = mysqli_fetch_assoc($result)) {
                    $products[] = new Producto($row);
                }
                
                return $products;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>