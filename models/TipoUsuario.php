<?php

namespace Model;

class TipoUsuario {
    private static $tabla = 'tipo_usuario';
    
    public $id;
    public $nombre;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
    }

    public static function all() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla;
            $result = mysqli_query($db, $query);

            if ($result) {
                $tiposUsuario = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $tiposUsuario[] = new self($row);
                }

                return $tiposUsuario;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
?>