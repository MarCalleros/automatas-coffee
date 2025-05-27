<?php

namespace Model;

use Model\Usuario;

class Direccion {
    private static $tabla = 'direccion';
    
    public $id;
    public $id_usuario;
    public $latitud;
    public $longitud;
    public $nombre;
    public $calle;
    public $numero;
    public $id_colonia;
    public $estatus;

    public $cp;
    public $colonia;
    public $ciudad;
    public $municipio;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->latitud = $args['latitud'] ?? null;
        $this->longitud = $args['longitud'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->calle = $args['calle'] ?? null;
        $this->numero = $args['numero'] ?? null;
        $this->id_colonia = $args['id_colonia'] ?? null;
        $this->estatus = $args['estatus'] ?? 1; // 1 = activo, 0 = inactivo
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
                    $direccion = new Direccion($row);

                    $query = "SELECT * FROM colonia WHERE id = ?";
                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, 'i', $direccion->id_colonia);
                    mysqli_stmt_execute($stmt);
                    $resultCol = mysqli_stmt_get_result($stmt);
                    
                    $rowCol = mysqli_fetch_assoc($resultCol);
                    $direccion->colonia = $rowCol['nombre'];
                    $direccion->cp = $rowCol['cp'];

                    $query = "SELECT * FROM ciudad WHERE id = ? AND id_municipio = ?";
                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, 'ii', $rowCol['id_ciudad'], $rowCol['id_municipio']);
                    mysqli_stmt_execute($stmt);
                    $resultCdd = mysqli_stmt_get_result($stmt);
                    
                    $rowCdd = mysqli_fetch_assoc($resultCdd);
                    $direccion->ciudad = $rowCdd['nombre'];

                    $query = "SELECT * FROM municipio WHERE id = ?";
                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, 'i', $rowCol['id_municipio']);
                    mysqli_stmt_execute($stmt);
                    $resultMnp = mysqli_stmt_get_result($stmt);
                    
                    $rowMnp = mysqli_fetch_assoc($resultMnp);
                    $direccion->municipio = $rowMnp['nombre'];

                    $direcciones[] = $direccion;
                }

                return $direcciones ?? null;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
?>