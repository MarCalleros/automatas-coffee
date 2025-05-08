<?php

namespace Model;

class Mensaje {
    private static $tabla = 'mensaje';
    
    public $id;
    public $id_usuario;
    public $contenido;
    public $leido;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->contenido = $args['contenido'] ?? null;
        $this->leido = $args['leido'] ?? 0; // 0 = no leído, 1 = leído
    }

    public function create() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "INSERT INTO " . self::$tabla . " (id_usuario, contenido, leido) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isi', $this->id_usuario, $this->contenido, $this->leido);
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
}
?>