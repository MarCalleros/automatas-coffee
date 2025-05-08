<?php

namespace Model;

use Model\Usuario;
use Ramsey\Uuid\Uuid;

class Mensaje {
    private static $tabla = 'mensaje';
    
    public $id;
    public $id_usuario;
    public $contenido;
    public $fecha;
    public $leido;
    public $respondido;
    public $identificador; // UUID de 12 caracteres alfanuméricos

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->contenido = $args['contenido'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->leido = $args['leido'] ?? 0; // 0 = no leído, 1 = leído
        $this->respondido = $args['respondido'] ?? 0; // 0 = no respondido, 1 = respondido
        $this->identificador = $args['identificador'] ?? null; // UUID de 12 caracteres alfanuméricos
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

            $query = "INSERT INTO " . self::$tabla . " (id_usuario, contenido, fecha, leido, respondido, identificador) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'issiis', $this->id_usuario, $this->contenido, $this->fecha, $this->leido, $this->respondido, $uuid);
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