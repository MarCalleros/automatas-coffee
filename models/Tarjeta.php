<?php

namespace Model;

use Model\Usuario;

class Tarjeta {
    private static $tabla = 'tarjeta';
    
    public $id;
    public $id_usuario;
    public $titular;
    public $numero;
    public $mes;
    public $año;
    public $cvc;
    public $estatus;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->titular = $args['titular'] ?? null;
        $this->numero = $args['numero'] ?? null;
        $this->mes = $args['mes'] ?? null;
        $this->año = $args['año'] ?? null;
        $this->cvc = $args['cvc'] ?? null;
        $this->estatus = $args['estatus'] ?? 1; // 1 = activo, 0 = inactivo
    }

    public function changeStatus() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "UPDATE " . self::$tabla . " SET estatus = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->estatus, $this->id);
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
                    $tarjeta = new Tarjeta($row);
                    $tarjetas[] = $tarjeta;
                }

                return $tarjetas ?? null;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>