<?php

namespace Model;

use Model\Usuario;
use Ramsey\Uuid\Uuid;

class Compra {
    private static $tabla = 'compra';
    
    public $id;
    public $id_usuario;
    public $id_repartidor;
    public $fecha;
    public $id_direccion;
    public $latitud;
    public $longitud;
    public $id_tarjeta;
    public $total;
    public $identificador; // UUID de 12 caracteres alfanuméricos
    public $estatus;

    public $usuario;
    public $detalle = []; // Array de objetos DetalleCompra

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->id_repartidor = $args['id_repartidor'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->id_direccion = $args['id_direccion'] ?? null;
        $this->latitud = $args['latitud'] ?? null;
        $this->longitud = $args['longitud'] ?? null;
        $this->id_tarjeta = $args['id_tarjeta'] ?? null;
        $this->total = $args['total'] ?? null;
        $this->identificador = $args['identificador'] ?? null; // UUID de 12 caracteres alfanuméricos
        $this->estatus = $args['estatus'] ?? 0; // 1 = entregado, 0 = pendiente
    }

    public static function all() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla;
            $result = mysqli_query($db, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $compra = new Compra($row);
                    $compras[] = $compra;
                }

                return $compras ?? null;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
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
                    $compra = new Compra($row);
                    $compras[] = $compra;
                }

                return $compras ?? null;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>