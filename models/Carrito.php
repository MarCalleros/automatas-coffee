<?php
namespace Model;

class Carrito {
    private static $tabla = 'carrito';
    
    public $id;
    public $id_usuario;
    public $id_producto;
    public $id_tamaño;
    public $cantidad;

    //Propiedades que se mostraran en la interfaz
    public $nombre_producto;
    public $nombre_tamaño;
    public $precio;
    public $descripcion;
    public $ruta_imagen;
    public $stock_disponible;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->id_producto = $args['id_producto'] ?? null;
        $this->id_tamaño = $args['id_tamaño'] ?? null;
        $this->cantidad = $args['cantidad'] ?? 1;
        
        //Propiedades virtuales
        $this->nombre_producto = $args['nombre_producto'] ?? '';
        $this->nombre_tamaño = $args['nombre_tamaño'] ?? '';
        $this->precio = $args['precio'] ?? 0;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->ruta_imagen = $args['ruta_imagen'] ?? '';
        $this->stock_disponible = $args['stock_disponible'] ?? 0;
    }

    public function agregarAlCarrito() {
        try {
            require __DIR__ . '/../includes/database.php';

            // Verificar si hay stock disponible
            $stockDisponible = $this->verificarStock($db);
            if ($stockDisponible === false) {
                return "Error al verificar el stock";
            }
            
            if ($stockDisponible < $this->cantidad) {
                return "No hay unidades por el momento";
            }

            // Verificar si el producto ya está en el carrito
            $itemExistente = self::buscarItem($this->id_usuario, $this->id_producto, $this->id_tamaño, $db);
            
            if ($itemExistente) {
                //Si ya existe, actualizar la cantidad
                $nuevaCantidad = $itemExistente->cantidad + $this->cantidad;
                
                //Verificar que la nueva cantidad no exceda el stock
                if ($nuevaCantidad > $stockDisponible) {
                    return "Stock insuficiente para agregar más unidades";
                }
                
                $query = "UPDATE " . self::$tabla . " SET cantidad = ? WHERE id = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, 'ii', $nuevaCantidad, $itemExistente->id);
            } else {
                $query = "INSERT INTO " . self::$tabla . " (id_usuario, id_producto, id_tamaño, cantidad) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, 'iiii', $this->id_usuario, $this->id_producto, $this->id_tamaño, $this->cantidad);
            }
            
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                return true;
            } else {
                return "Error al agregar al carrito: " . mysqli_error($db);
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function actualizarCantidad() {
        try {
            require __DIR__ . '/../includes/database.php';
            mysqli_begin_transaction($db);
    
            // 1. Leer cantidad anterior en carrito
            $queryOld = "SELECT cantidad, id_producto, id_tamaño FROM carrito WHERE id = ? FOR UPDATE";
            $stmt = mysqli_prepare($db, $queryOld);
            mysqli_stmt_bind_param($stmt, 'i', $this->id);
            mysqli_stmt_execute($stmt);
            $resOld = mysqli_stmt_get_result($stmt);
            if ($resOld->num_rows === 0) {
                mysqli_rollback($db);
                return ["status" => "error", "message" => "Item no encontrado en carrito"];
            }
            $rowOld = mysqli_fetch_assoc($resOld);
            $cantidadAnterior = intval($rowOld['cantidad']);
            $this->id_producto = $rowOld['id_producto'];
            $this->id_tamaño   = $rowOld['id_tamaño'];
    
            // 2. Leer existencia real en inventario (solo para validar)
            $queryStock = "SELECT existencia FROM producto_tamaño WHERE id_producto = ? AND id_tamaño = ? FOR UPDATE";
            $stmt = mysqli_prepare($db, $queryStock);
            mysqli_stmt_bind_param($stmt, 'ii', $this->id_producto, $this->id_tamaño);
            mysqli_stmt_execute($stmt);
            $resStock = mysqli_stmt_get_result($stmt);
            if ($resStock->num_rows === 0) {
                mysqli_rollback($db);
                return ["status" => "error", "message" => "Item no encontrado en inventario"];
            }
            $rowStock        = mysqli_fetch_assoc($resStock);
            $stockDisponible = intval($rowStock['existencia']);
    
            // 3. Validar que no exceda stock
            if ($this->cantidad > $stockDisponible) {
                mysqli_rollback($db);
                return [
                    "status"      => "error",
                    "message"     => "Stock insuficiente. Solo quedan {$stockDisponible} unidades.",
                    "total"       => self::calcularTotal($this->id_usuario),
                    "total_items" => self::contarItems($this->id_usuario)
                ];
            }
    
            // 4. Actualizar solo el carrito (sin tocar inventario)
            $queryUpdCart = "UPDATE carrito SET cantidad = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $queryUpdCart);
            mysqli_stmt_bind_param($stmt, 'ii', $this->cantidad, $this->id);
            if (!mysqli_stmt_execute($stmt)) {
                mysqli_rollback($db);
                return ["status"=>"error","message"=>"Error al actualizar carrito"];
            }
    
            mysqli_commit($db);
    
            return [
                "status"      => "success",
                // Quitamos "nuevo_stock" porque no lo modificamos aquí
                "total"       => self::calcularTotal($this->id_usuario),
                "total_items" => self::contarItems($this->id_usuario)
            ];
    
        } catch (\Exception $e) {
            if (isset($db)) mysqli_rollback($db);
            return ["status"=>"error","message"=>$e->getMessage()];
        }
    }
    
    public function eliminar() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "DELETE FROM " . self::$tabla . " WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $this->id);
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                return true;
            } else {
                return "Error al eliminar del carrito: " . mysqli_error($db);
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function vaciar($id_usuario) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "DELETE FROM " . self::$tabla . " WHERE id_usuario = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                return true;
            } else {
                return "Error al vaciar el carrito: " . mysqli_error($db);
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function obtenerCarritoCompleto($id_usuario) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT c.*, p.nombre as nombre_producto, p.descripcion, p.ruta, 
                    t.nombre as nombre_tamaño, pt.precio, pt.existencia as stock_disponible
                    FROM " . self::$tabla . " c
                    JOIN producto p ON c.id_producto = p.id
                    JOIN tamaño t ON c.id_tamaño = t.id
                    JOIN producto_tamaño pt ON c.id_producto = pt.id_producto AND c.id_tamaño = pt.id_tamaño
                    WHERE c.id_usuario = ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $items = [];
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $item = new Carrito($row);
                    $item->nombre_producto = $row['nombre_producto'];
                    $item->nombre_tamaño = $row['nombre_tamaño'];
                    $item->precio = $row['precio'];
                    $item->descripcion = $row['descripcion'];
                    $item->ruta_imagen = $row['ruta'];
                    $item->stock_disponible = $row['stock_disponible'];
                    $items[] = $item;
                }
                
                return $items;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return null;
        }
    }
    
    public static function calcularTotal($id_usuario) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT SUM(c.cantidad * pt.precio) as total
                    FROM " . self::$tabla . " c
                    JOIN producto_tamaño pt ON c.id_producto = pt.id_producto AND c.id_tamaño = pt.id_tamaño
                    WHERE c.id_usuario = ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['total'] ? floatval($row['total']) : 0;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function contarItems($id_usuario) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT SUM(cantidad) as total_items FROM " . self::$tabla . " WHERE id_usuario = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['total_items'] ? intval($row['total_items']) : 0;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function buscarItem($id_usuario, $id_producto, $id_tamaño, $db) {
        try {
            $query = "SELECT * FROM " . self::$tabla . " 
                      WHERE id_usuario = ? AND id_producto = ? AND id_tamaño = ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'iii', $id_usuario, $id_producto, $id_tamaño);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            if ($result->num_rows > 0) {
                return new Carrito(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
    
    private function verificarStock($db) {
        try {
            $query = "SELECT existencia FROM producto_tamaño 
                      WHERE id_producto = ? AND id_tamaño = ?";
            
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->id_producto, $this->id_tamaño);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                return intval($row['existencia']);
            } else {
                // Producto o tamaño no encontrado
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public static function actualizarStock($items) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            // Iniciar transacción
            mysqli_begin_transaction($db);
            
            $success = true;
            
            foreach ($items as $item) {
                $query = "UPDATE producto_tamaño SET existencia = existencia - ? 
                          WHERE id_producto = ? AND id_tamaño = ? AND existencia >= ?";
                
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, 'iiii', $item->cantidad, $item->id_producto, $item->id_tamaño, $item->cantidad);
                $result = mysqli_stmt_execute($stmt);
                
                if (!$result || mysqli_stmt_affected_rows($stmt) === 0) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                mysqli_commit($db);
                return true;
            } else {
                mysqli_rollback($db);
                return false;
            }
        } catch (\Exception $e) {
            if (isset($db) && mysqli_connect_errno() === 0) {
                mysqli_rollback($db);
            }
            return false;
        }
    }
    //Comprar
    public static function comprar($id_usuario) {
        try {
            require __DIR__ . '/../includes/database.php';            
            mysqli_begin_transaction($db);
            
            $items = self::obtenerCarritoCompleto($id_usuario);
            
            if (empty($items)) {
                return ["status" => "error", "message" => "El carrito está vacío"];
            }
            
            $total = self::calcularTotal($id_usuario);
            
            // 3. Crear la compra
            $query = "INSERT INTO compra (id_usuario, fecha, total, estatus) VALUES (?, NOW(), ?, 'A')";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'id', $id_usuario, $total);
            
            if (!mysqli_stmt_execute($stmt)) {
                mysqli_rollback($db);
                return ["status" => "error", "message" => "Error al crear la compra: " . mysqli_error($db)];
            }
            
            $id_compra = mysqli_insert_id($db);
            
            // 4. Crear los detalles de la compra
            $query = "INSERT INTO detalle_compra (id_compra, id_producto, id_tamaño, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            
            foreach ($items as $item) {
                $subtotal = $item->cantidad * $item->precio;
                
                mysqli_stmt_bind_param(
                    $stmt, 
                    'iiiddd', 
                    $id_compra, 
                    $item->id_producto, 
                    $item->id_tamaño, 
                    $item->cantidad, 
                    $item->precio, 
                    $subtotal
                );
                
                if (!mysqli_stmt_execute($stmt)) {
                    mysqli_rollback($db);
                    return ["status" => "error", "message" => "Error al guardar detalle de la compra: " . mysqli_error($db)];
                }
            }
            
            // 5. Actualizar el stock
            if (!self::actualizarStock($items)) {
                mysqli_rollback($db);
                return ["status" => "error", "message" => "Error al actualizar el stock de productos"];
            }
            
            // 6. Vaciar el carrito
            if (!self::vaciar($id_usuario)) {
                mysqli_rollback($db);
                return ["status" => "error", "message" => "Error al vaciar el carrito"];
            }
            
            // Confirmar la transacción
            mysqli_commit($db);
            
            return [
                "status" => "success", 
                "message" => "¡Compra realizada con éxito! Tu Compra está en proceso.",
                "id_compra" => $id_compra
            ];
            
        } catch (\Exception $e) {
            if (isset($db) && mysqli_connect_errno() === 0) {
                mysqli_rollback($db);
            }
            return ["status" => "error", "message" => "Error: " . $e->getMessage()];
        }
    }
}
?>
