<?php

namespace Model;

class Historyregister {
    private static $tabla = 'registros';
    
    public $id;
    public $empleado_id;
    public $fecha;
    public $hora_entrada;
    public $hora_salida;
    public $nombre_empleado; 

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->empleado_id = $args['empleado_id'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->hora_entrada = $args['hora_entrada'] ?? null;
        $this->hora_salida = $args['hora_salida'] ?? null;
        $this->nombre_empleado = $args['nombre_empleado'] ?? null;
    }

    /**
     * Obtiene los registros con filtros y paginación
     */
    public static function obtenerRegistros($desde = null, $hasta = null, $pagina = 1, $registros_por_pagina = 10) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            // Calcular el offset para la paginación
            $offset = ($pagina - 1) * $registros_por_pagina;
            
            // Consulta base
            $query = "SELECT r.id, r.empleado_id, r.fecha, r.hora_entrada, r.hora_salida, e.nombre as nombre_empleado 
                        FROM " . self::$tabla . " r
                        JOIN empleados e ON r.empleado_id = e.id
                        WHERE 1=1";
            
            // Añadir filtros si existen
            if (!empty($desde)) {
                $query .= " AND r.fecha >= ?";
            }
            
            if (!empty($hasta)) {
                $query .= " AND r.fecha <= ?";
            }
            
            // Ordenar y limitar resultados
            $query .= " ORDER BY r.fecha DESC, r.hora_entrada DESC LIMIT ?, ?";
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return [];
            }
            
            // Vincular parámetros según los filtros
            if (!empty($desde) && !empty($hasta)) {
                mysqli_stmt_bind_param($stmt, 'ssii', $desde, $hasta, $offset, $registros_por_pagina);
            } elseif (!empty($desde)) {
                mysqli_stmt_bind_param($stmt, 'sii', $desde, $offset, $registros_por_pagina);
            } elseif (!empty($hasta)) {
                mysqli_stmt_bind_param($stmt, 'sii', $hasta, $offset, $registros_por_pagina);
            } else {
                mysqli_stmt_bind_param($stmt, 'ii', $offset, $registros_por_pagina);
            }
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $registros = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $registros[] = new Historyregister($row);
            }
            
            return $registros;
            
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Cuenta el total de registros con los filtros aplicados
     */
    public static function contarRegistros($desde = null, $hasta = null) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            // Consulta base
            $query = "SELECT COUNT(*) as total FROM " . self::$tabla . " r WHERE 1=1";
            
            // Añadir filtros si existen
            if (!empty($desde)) {
                $query .= " AND r.fecha >= ?";
            }
            
            if (!empty($hasta)) {
                $query .= " AND r.fecha <= ?";
            }
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return 0;
            }
            
            // Vincular parámetros según los filtros
            if (!empty($desde) && !empty($hasta)) {
                mysqli_stmt_bind_param($stmt, 'ss', $desde, $hasta);
            } elseif (!empty($desde)) {
                mysqli_stmt_bind_param($stmt, 's', $desde);
            } elseif (!empty($hasta)) {
                mysqli_stmt_bind_param($stmt, 's', $hasta);
            }
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            
            return (int) $row['total'];
            
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Registra la entrada de un empleado
     */
    public function registrarEntrada($empleado_id) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            // Fecha y hora actual
            $fecha_actual = date('Y-m-d');
            $hora_actual = date('H:i:s');
            
            // Verificar si ya existe una entrada sin salida para hoy
            $query = "SELECT id FROM " . self::$tabla . " 
                        WHERE empleado_id = ? 
                        AND fecha = ? 
                        AND hora_entrada IS NOT NULL 
                        AND hora_salida IS NULL";
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return "Error en la preparación de la consulta";
            }
            
            mysqli_stmt_bind_param($stmt, 'is', $empleado_id, $fecha_actual);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                return "Ya existe una entrada sin salida registrada para hoy";
            }
            
            // Insertar nueva entrada
            $query = "INSERT INTO " . self::$tabla . " (empleado_id, fecha, hora_entrada) 
                        VALUES (?, ?, ?)";
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return "Error en la preparación de la consulta";
            }
            
            mysqli_stmt_bind_param($stmt, 'iss', $empleado_id, $fecha_actual, $hora_actual);
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                return true;
            } else {
                return "Error al registrar la entrada";
            }
            
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Registra la salida de un empleado
     */
    public function registrarSalida($empleado_id) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            // Fecha y hora actual
            $fecha_actual = date('Y-m-d');
            $hora_actual = date('H:i:s');
            
            // Buscar registro de entrada sin salida para hoy
            $query = "SELECT id FROM " . self::$tabla . " 
                        WHERE empleado_id = ? 
                        AND fecha = ? 
                        AND hora_entrada IS NOT NULL 
                        AND hora_salida IS NULL
                        LIMIT 1";
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return "Error en la preparación de la consulta";
            }
            
            mysqli_stmt_bind_param($stmt, 'is', $empleado_id, $fecha_actual);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                
                // Actualizar registro con hora de salida
                $query = "UPDATE " . self::$tabla . " 
                            SET hora_salida = ? 
                            WHERE id = ?";
                
                $stmt = mysqli_prepare($db, $query);
                
                if ($stmt === false) {
                    return "Error en la preparación de la consulta";
                }
                
                mysqli_stmt_bind_param($stmt, 'si', $hora_actual, $id);
                $result = mysqli_stmt_execute($stmt);
                
                if ($result) {
                    return true;
                } else {
                    return "Error al registrar la salida";
                }
            } else {
                return "No se encontró un registro de entrada sin salida para hoy";
            }
            
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Verifica si un empleado tiene una entrada sin salida para hoy
     */
    public function tieneEntradaSinSalida($empleado_id) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            // Fecha actual
            $fecha_actual = date('Y-m-d');
            
            // Buscar registro de entrada sin salida para hoy
            $query = "SELECT id FROM " . self::$tabla . " 
                        WHERE empleado_id = ? 
                        AND fecha = ? 
                        AND hora_entrada IS NOT NULL 
                        AND hora_salida IS NULL
                        LIMIT 1";
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return false;
            }
            
            mysqli_stmt_bind_param($stmt, 'is', $empleado_id, $fecha_actual);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            return mysqli_num_rows($result) > 0;
            
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Elimina un registro
     */
    public function eliminar() {
        try {
            require __DIR__ . '/../includes/database.php';
            
            if (!$this->id) {
                return "ID de registro no válido";
            }
            
            $query = "DELETE FROM " . self::$tabla . " WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return "Error en la preparación de la consulta";
            }
            
            mysqli_stmt_bind_param($stmt, 'i', $this->id);
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                return true;
            } else {
                return "Error al eliminar el registro";
            }
            
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Obtiene un registro por su ID
     */
    public static function getById($id) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            $query = "SELECT r.id, r.empleado_id, r.fecha, r.hora_entrada, r.hora_salida, e.nombre as nombre_empleado 
                        FROM " . self::$tabla . " r
                        JOIN empleados e ON r.empleado_id = e.id
                        WHERE r.id = ?";
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return null;
            }
            
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                return new Historyregister(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
            
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Obtiene registros por ID de empleado
     */
    public static function getByEmpleadoId($empleado_id) {
        try {
            require __DIR__ . '/../includes/database.php';
            
            $query = "SELECT r.id, r.empleado_id, r.fecha, r.hora_entrada, r.hora_salida, e.nombre as nombre_empleado 
                        FROM " . self::$tabla . " r
                        JOIN empleados e ON r.empleado_id = e.id
                        WHERE r.empleado_id = ?
                        ORDER BY r.fecha DESC, r.hora_entrada DESC";
            
            $stmt = mysqli_prepare($db, $query);
            
            if ($stmt === false) {
                return [];
            }
            
            mysqli_stmt_bind_param($stmt, 'i', $empleado_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $registros = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $registros[] = new Historyregister($row);
            }
            
            return $registros;
            
        } catch (\Exception $e) {
            return [];
        }
    }
}
?>
