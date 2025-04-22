<?php

namespace Model;
use Model\ProductoTamaño;

class Producto {
    private static $tabla = 'producto';
    
    public $id;
    public $nombre;
    public $ruta;
    public $descripcion;
    public $estatus;

    public $chico;
    public $mediano;
    public $grande;

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

                // Obtener los tamaños y precios de cada producto
                while ($row = mysqli_fetch_assoc($result)) {
                    $product = new Producto($row);
                    $sizes = ProductoTamaño::getByIdProducto($product->id);

                    if ($sizes) {
                        foreach ($sizes as $size) {
                            switch ($size->id_tamaño) {
                                case 1:
                                    $product->chico = $size->precio;
                                    break;
                                case 2:
                                    $product->mediano = $size->precio;
                                    break;
                                case 3:
                                    $product->grande = $size->precio;
                                    break;
                            }
                        }
                    }

                    $products[] = $product;
                }
                
                return $products;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function listPagination($offset = 0, $limit = 3) {
        try {
            require __DIR__ . '/../includes/database.php';
    
            $query = "SELECT * FROM " . self::$tabla . " WHERE estatus = 1 LIMIT ? OFFSET ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            $products = [];
    
            while ($row = mysqli_fetch_assoc($result)) {
                $product = new Producto($row);
                $sizes = ProductoTamaño::getByIdProducto($product->id);
    
                if ($sizes) {
                    foreach ($sizes as $size) {
                        switch ($size->id_tamaño) {
                            case 1: $product->chico = $size->precio; break;
                            case 2: $product->mediano = $size->precio; break;
                            case 3: $product->grande = $size->precio; break;
                        }
                    }
                }
    
                $products[] = $product;
            }
    
            return $products;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    public static function count() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT COUNT(*) as total FROM " . self::$tabla . " WHERE estatus = 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['total'];
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }
}
?>