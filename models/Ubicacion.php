<?php

namespace Model;

class Ubicacion {
    private static $tabla = 'ubicacion';
    
    public $id;
    public $id_repartidor;
    public $latitud;
    public $longitud;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_repartidor = $args['id_repartidor'] ?? null;
        $this->latitud = $args['latitud'] ?? null;
        $this->longitud = $args['longitud'] ?? null;
    }

    public static function all() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla;
            $result = mysqli_query($db, $query);

            if ($result->num_rows > 0) {
                $ubicaciones = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $ubicaciones[] = new Ubicacion($row);
                }
                
                return $ubicaciones;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function findById($id) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE id_repartidor = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                return new Ubicacion(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>