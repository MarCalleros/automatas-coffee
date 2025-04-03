<?php

namespace App;
use App\Repartidor;
require __DIR__ . '/../vendor/autoload.php';

class Repartidor {
    protected static $tabla = 'repartidor';

    public $id;
    public $nombre;
    public $apellido1;
    public $apellido2;
    public $telefono;
    public $curp;
    public $rfc;
    public $tipo_sangre;
    public $nss;
    public $vigencia_licencia;
    public $estatus;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido1 = $args['apellido1'] ?? '';
        $this->apellido2 = $args['apellido2'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->curp = $args['curp'] ?? '';
        $this->rfc = $args['rfc'] ?? '';
        $this->tipo_sangre = $args['tipo_sangre'] ?? '';
        $this->nss = $args['nss'] ?? '';
        $this->vigencia_licencia = $args['vigencia_licencia'] ?? '';
        $this->estatus = $args['estatus'] ?? 0;
    }

    // Funcion para obtener a todos los repartidores
    public static function all() {
        require __DIR__ . '/../includes/database.php';

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
    }
}

?>