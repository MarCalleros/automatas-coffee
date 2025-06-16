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
    public $entregado;
    public $id_sucursal;
    public $id_direccion;
    public $latitud;
    public $longitud;
    public $id_tarjeta;
    public $total;
    public $identificador; // UUID de 12 caracteres alfanuméricos
    public $estatus;

    public $usuario;
    public $repartidor;
    public $pago;
    public $detalle = []; // Array de objetos DetalleCompra

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->id_repartidor = $args['id_repartidor'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->entregado = $args['entregado'] ?? null; 
        $this->id_sucursal = $args['id_sucursal'] ?? null;
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

    public static function getPurchases($max) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE estatus = 0 AND id_sucursal IS NULL AND id_repartidor IS NULL ORDER BY fecha ASC LIMIT ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $max);
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

    public static function asignDelivery($id_compra, $id_repartidor) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "UPDATE " . self::$tabla . " SET id_repartidor = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $id_repartidor, $id_compra);
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

    public static function betweenDates($startDate, $endDate) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE fecha BETWEEN ? AND ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ss', $startDate, $endDate);
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