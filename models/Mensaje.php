<?php

namespace Model;

use Model\Usuario;
use Ramsey\Uuid\Uuid;

class Mensaje {
    private static $tabla = 'mensaje';
    
    public $id;
    public $id_mensaje;
    public $id_usuario;
    public $contenido;
    public $fecha;
    public $leido;
    public $respondido;
    public $identificador; // UUID de 12 caracteres alfanuméricos
    public $estatus;

    public $usuario;
    public $identificador_mensaje; // UUID de 12 caracteres alfanuméricos

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_mensaje = $args['id_mensaje'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->contenido = $args['contenido'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->leido = $args['leido'] ?? 0; // 0 = no leído, 1 = leído
        $this->respondido = $args['respondido'] ?? 0; // 0 = no respondido, 1 = respondido
        $this->identificador = $args['identificador'] ?? null; // UUID de 12 caracteres alfanuméricos
        $this->estatus = $args['estatus'] ?? 1; // 1 = activo, 0 = inactivo
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

    public function create() {
        try {
            require __DIR__ . '/../includes/database.php';

            do {
                // Generar un UUID para el mensaje
                $uuid = Uuid::uuid4()->toString();
                $uuid = substr(str_replace('-', '', $uuid), 0, 12); // 12 caracteres alfanuméricos
                $uuid = strtoupper($uuid); // Convertir a mayúsculas
            } while (self::where('identificador', $uuid)); // Verificar que no exista otro mensaje con el mismo UUID

            $query = "INSERT INTO " . self::$tabla . " (id_mensaje, id_usuario, contenido, fecha, leido, respondido, identificador, estatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'iissiisi', $this->id_mensaje, $this->id_usuario, $this->contenido, $this->fecha, $this->leido, $this->respondido, $uuid, $this->estatus);
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

    public function changeView() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "UPDATE " . self::$tabla . " SET leido = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->leido, $this->id);
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

    public function changeResponse() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "UPDATE " . self::$tabla . " SET respondido = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->respondido, $this->id);
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
                    $mensaje = new Mensaje($row);
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
}
?>