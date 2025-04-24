<?php

namespace Model;

class Favorito {
    private static $tabla = 'favorito';
    
    public $id_usuario;
    public $id_producto;

    public function __construct($args = []) {
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->id_producto = $args['id_producto'] ?? null;
    }

    public function create() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "INSERT INTO " . self::$tabla . " (id_usuario, id_producto) VALUES (?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->id_usuario, $this->id_producto);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "DELETE FROM " . self::$tabla . " WHERE id_usuario = ? AND id_producto = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->id_usuario, $this->id_producto);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getByIdUsuario($id_usuario) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE id_usuario = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $liked = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $liked[] = new Favorito($row);
                }
                
                return $liked;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getByIdUsuarioAndIdProducto($id_usuario, $id_producto) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE id_usuario = ? AND id_producto = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $id_usuario, $id_producto);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                return new Favorito(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>