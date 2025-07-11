<?php

namespace Model;

class Repartidor {
    protected static $tabla = 'repartidor';

    public $id;
    public $id_usuario;
    public $nombre;
    public $apellido1;
    public $apellido2;
    public $telefono;
    public $curp;
    public $rfc;
    public $tipo_sangre;
    public $nss;
    public $vigencia_licencia;
    public $id_compra;
    public $estatus_repartiendo;
    public $estatus;

    public $ubicacion; // Relacion con la tabla ubicacion
    public $usuario;
    public $compra; // Relacion con la tabla compra

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido1 = $args['apellido1'] ?? '';
        $this->apellido2 = $args['apellido2'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->curp = $args['curp'] ?? '';
        $this->rfc = $args['rfc'] ?? '';
        $this->tipo_sangre = $args['tipo_sangre'] ?? '';
        $this->nss = $args['nss'] ?? '';
        $this->vigencia_licencia = $args['vigencia_licencia'] ?? '';
        $this->id_compra = $args['id_compra'] ?? null; // Relacion con la tabla compra
        $this->estatus_repartiendo = $args['estatus_repartiendo'] ?? 0;
        $this->estatus = $args['estatus'] ?? 1;
    }

    // Funcion para obtener a todos los repartidores
    public static function all() {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT * FROM " . static::$tabla;
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            if ($result->num_rows > 0) {
                $repartidores = [];
    
                while ($row = mysqli_fetch_assoc($result)) {
                    $repartidores[] = new Repartidor($row);
                }
                
                return $repartidores;
            } else {
                return [];
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    // Funcion para obtener a todos los repartidores con estatus activo y ordenanos por su estatus de repartiendo
    public static function allActiveAsc() {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT * FROM " . static::$tabla . " WHERE estatus = 1 ORDER BY estatus_repartiendo DESC";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //mysqli_close($db);

            if ($result->num_rows > 0) {
                $repartidores = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $repartidores[] = new Repartidor($row);
                }

                return $repartidores;
            } else {
                return [];
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }

        
    }

    // Funcion para agregar un nuevo repartidor
    public function save() {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            // Comprobar que no existe un repartidor con el mismo CURP
            if (self::find('curp', $this->curp)) {
                return "La CURP ya se encuentra registrada"; // Ya existe un repartidor con el mismo CURP
            }

            // Comprobar que no existe un repartidor con el mismo RFC
            if (self::find('rfc', $this->rfc)) {
                return "El RFC ya se encuentra registrado"; // Ya existe un repartidor con el mismo RFC
            }

            // Comprobar que no existe un repartidor con el mismo NSS
            if (self::find('nss', $this->nss)) {
                return "El NSS ya se encuentra registrado"; // Ya existe un repartidor con el mismo NSS
            }

            $query = "INSERT INTO " . static::$tabla . " (id_usuario, nombre, apellido1, apellido2, telefono, curp, rfc, tipo_sangre, nss, vigencia_licencia, estatus_repartiendo, estatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isssssssssii', $this->id_usuario, $this->nombre, $this->apellido1, $this->apellido2, $this->telefono, $this->curp, $this->rfc, $this->tipo_sangre, $this->nss, $this->vigencia_licencia, $this->estatus_repartiendo, $this->estatus);
            $executed = mysqli_stmt_execute($stmt);
            
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    // Funcion para actualizar un repartidor
    public function update() {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            // Comprobar que no existe un repartidor con el mismo CURP
            if (self::find('curp', $this->curp) && self::find('curp', $this->curp)->id != $this->id) {
                return "La CURP ya se encuentra registrada"; // Ya existe un repartidor con el mismo CURP
            }

            // Comprobar que no existe un repartidor con el mismo RFC
            if (self::find('rfc', $this->rfc) && self::find('rfc', $this->rfc)->id != $this->id) {
                return "El RFC ya se encuentra registrado"; // Ya existe un repartidor con el mismo RFC
            }

            // Comprobar que no existe un repartidor con el mismo NSS
            if (self::find('nss', $this->nss) && self::find('nss', $this->nss)->id != $this->id) {
                return "El NSS ya se encuentra registrado"; // Ya existe un repartidor con el mismo NSS
            }
            
            $query = "UPDATE " . static::$tabla . " SET id_usuario = ?, nombre = ?, apellido1 = ?, apellido2 = ?, telefono = ?, curp = ?, rfc = ?, tipo_sangre = ?, nss = ?, vigencia_licencia = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isssssssssi', $this->id_usuario, $this->nombre, $this->apellido1, $this->apellido2, $this->telefono, $this->curp, $this->rfc, $this->tipo_sangre, $this->nss, $this->vigencia_licencia, $this->id);
            $executed = mysqli_stmt_execute($stmt);
            
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
        
        
    }

    // Funcion para cambiar el estatus de un repartidor
    public function changeStatus() {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);
            
            $query = "UPDATE " . static::$tabla . " SET estatus = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->estatus, $this->id);
            $executed = mysqli_stmt_execute($stmt);
            
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    // Funcion para buscar un repartidor por ID
    public static function findById($id) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT * FROM " . static::$tabla . " WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //mysqli_close($db);

            if ($result->num_rows > 0) {
                return new Repartidor(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    // Funcion para buscar un repartidor por algun atributo
    public static function find($attribute, $value) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT * FROM " . static::$tabla . " WHERE " . $attribute . " = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $value);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //mysqli_close($db);

            if ($result->num_rows > 0) {
                return new Repartidor(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    // Funcion para buscar un repartidor por su id de usuario
    public static function getDeliverymanByUserId($userId) {
        require __DIR__ . '/../includes/database.php';

        try {
            $query = "SELECT * FROM repartidor WHERE id_usuario = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                return new Repartidor(mysqli_fetch_assoc($result));
            } else {
                return null; // No se encontró el repartidor
            }
        } catch (\Exception $e) {
            return null; // Error en la consulta
        }
    }


    public function unasignDelivery($idRepartidor) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);
        
            $query = "UPDATE compra SET id_repartidor = NULL WHERE id_repartidor = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $idRepartidor);
            $executed = mysqli_stmt_execute($stmt);
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;

        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }

    }

    public function completeDelivery($id_compra) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);
        
            $query = "UPDATE compra SET estatus = 1 WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id_compra);
            $executed = mysqli_stmt_execute($stmt);
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;

        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    public static function setStatusDelivering($id, $status) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);
        
            $query = "UPDATE " . static::$tabla . " SET estatus_repartiendo = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $status, $id);
            $executed = mysqli_stmt_execute($stmt);
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;

        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    public static function setDelivery($id, $id_compra) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);
        
            $query = "UPDATE " . static::$tabla . " SET id_compra = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $id_compra, $id);
            $executed = mysqli_stmt_execute($stmt);
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;

        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }
}
?>