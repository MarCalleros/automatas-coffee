<?php

namespace Model;

use Model\Usuario;

class Mensaje {
    private static $tabla = 'mensaje';
    
    public $id;
    public $id_usuario;
    public $contenido;
    public $fecha;
    public $leido;
    public $respondido;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->contenido = $args['contenido'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->leido = $args['leido'] ?? 0; // 0 = no leído, 1 = leído
        $this->respondido = $args['respondido'] ?? 0; // 0 = no respondido, 1 = respondido
    }

    public function create() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "INSERT INTO " . self::$tabla . " (id_usuario, contenido, fecha, leido, respondido) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'issii', $this->id_usuario, $this->contenido, $this->fecha, $this->leido, $this->respondido);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function where($column, $value) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE " . $column . " = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $value);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $mensaje = new Mensaje($row);
                    $mensajes[] = $mensaje;
                }

                return $mensajes ?? null;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>