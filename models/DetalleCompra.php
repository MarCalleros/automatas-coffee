<?php

namespace Model;

class DetalleCompra {
    private static $tabla = 'detalle_compra';
    
    public $id_detalle_compra;
    public $id_compra;
    public $id_producto;
    public $id_tamaño;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;

    public $producto;
    public $tamaño;

    public function __construct($args = []) {
        $this->id_detalle_compra = $args['id_detalle_compra'] ?? null;
        $this->id_compra = $args['id_compra'] ?? null;
        $this->id_producto = $args['id_producto'] ?? null;
        $this->id_tamaño = $args['id_tamaño'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->precio_unitario = $args['precio_unitario'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
    }

    public static function all() {
        try {
            require __DIR__ . '/../includes/database.php';

            //$query = "SELECT * FROM " . self::$tabla . " ORDER BY id ASC";
            $query = "SELECT m1.*, CASE WHEN m1.id_mensaje IS NULL THEN 'original' ELSE 'respuesta' END AS tipo FROM " . self::$tabla . " m1 LEFT JOIN " . self::$tabla . " m2 ON m1.id_mensaje = m2.id ORDER BY COALESCE(m1.id_mensaje, m1.id), m1.id_mensaje IS NOT NULL, m1.fecha";
            $result = mysqli_query($db, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $mensaje = new Mensaje($row);

                    $mensaje->usuario = Usuario::where('id', $mensaje->id_usuario); // Obtener el usuario relacionado

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
                    $detalle = new DetalleCompra($row);
                    $detalles[] = $detalle;
                }

                return $detalles ?? null;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>