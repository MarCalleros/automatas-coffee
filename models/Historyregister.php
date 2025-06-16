<?php

namespace Model;

class HistoryRegister {
    private static $tabla = 'historial_registro'; 

    public $id; 
    public $id_empleado;
    public $nombre_empleado;
    public $fecha;
    public $hora_entrada;
    public $hora_salida;
    public $tipo_usuario;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_empleado = $args['id_empleado'] ?? null;
        $this->nombre_empleado = $args['nombre_empleado'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->hora_entrada = $args['hora_entrada'] ?? null;
        $this->hora_salida = $args['hora_salida'] ?? null;
        $this->tipo_usuario = $args['tipo_usuario'] ?? null;
    }

    // Método para crear un nuevo registro de entrada
    public function create() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "INSERT INTO historial_registro (id_empleado, nombre_empleado, fecha, hora_entrada) VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isss', $this->id_empleado, $this->nombre_empleado, $this->fecha, $this->hora_entrada);

            $result = mysqli_stmt_execute($stmt);

            return $result; 
        } catch (\Exception $e) {
            error_log("Error al crear registro: " . $e->getMessage());
            return false; 
        }
    }

    // Método para actualizar la hora de salida
    public function update() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "UPDATE " . self::$tabla . " SET hora_salida = ? WHERE id_empleado = ? AND fecha = ? AND hora_salida IS NULL";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'sis', $this->hora_salida, $this->id_empleado, $this->fecha);
            $result = mysqli_stmt_execute($stmt);

            return $result; 
        } catch (\Exception $e) {
            return false; 
        }
    }

    // Método para obtener un registro por empleado y fecha
    public static function findByEmpleadoAndFecha($id_empleado, $fecha) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE id_empleado = ? AND fecha = ? AND hora_salida IS NULL";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'is', $id_empleado, $fecha);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                return new HistoryRegister(mysqli_fetch_assoc($result)); 
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null; 
        }
    }

    

        // Método para contar registros
    public static function contarRegistros($desde = null, $hasta = null) {
        try {
            require __DIR__ . '/../includes/database.php';
            // Construir la consulta SQL
            $query = "SELECT COUNT(*) FROM " . self::$tabla;
            // Agregar condiciones de filtrado si se proporcionan
            $conditions = [];
            $params = [];
            if ($desde) {
                $conditions[] = "fecha >= ?";
                $params[] = $desde;
            }
            if ($hasta) {
                $conditions[] = "fecha <= ?";
                $params[] = $hasta;
            }
            if (count($conditions) > 0) {
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
            $stmt = mysqli_prepare($db, $query);
            if (count($params) > 0) {
                mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
            }
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            return $row[0]; // Retorna el conteo de registros
        } catch (\Exception $e) {
            return 0; // Retorna 0 en caso de error
        }
    }

    public static function obtenerRegistros($desde = null, $hasta = null, $pagina = 1, $registros_por_pagina = 10) {
        try {
            require __DIR__ . '/../includes/database.php';
            $offset = ($pagina - 1) * $registros_por_pagina;
            $query = "SELECT hr.*, u.nombre AS nombre_empleado 
                    FROM " . self::$tabla . " hr
                    JOIN usuario u ON hr.id_empleado = u.id";
            $conditions = [];
            $params = [];
            if ($desde) {
                $conditions[] = "fecha >= ?";
                $params[] = $desde;
            }
            if ($hasta) {
                $conditions[] = "fecha <= ?";
                $params[] = $hasta;
            }
            if (count($conditions) > 0) {
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
            $query .= " LIMIT ?, ?";
            $params[] = $offset;
            $params[] = $registros_por_pagina;
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, str_repeat('s', count($params) - 2) . 'ii', ...$params);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $registros = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $registros[] = new HistoryRegister($row);
            }
            return $registros; 
        } catch (\Exception $e) {
            return []; 
        }
    }

    public static function delete($id) {
    try {
        require __DIR__ . '/../includes/database.php';
        
        $query = "DELETE FROM " . self::$tabla . " WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        return mysqli_stmt_execute($stmt);
    } catch (\Exception $e) {
        return false;
    }
}
}
?>
