<?php

namespace Model;

class Usuario {
    private static $tabla = 'usuario';
    
    public $id;
    public $id_tipo_usuario;
    public $nombre;
    public $edad;
    public $correo;
    public $usuario;
    public $contraseña;
    public $estatus;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_tipo_usuario = $args['id_tipo_usuario'] ?? 2;
        $this->nombre = $args['nombre'] ?? null;
        $this->edad = $args['edad'] ?? null;
        $this->correo = $args['correo'] ?? null;
        $this->usuario = $args['usuario'] ?? null;
        $this->contraseña = $args['contraseña'] ?? null;
        $this->estatus = $args['estatus'] ?? 1;
    }

    public function create() {
        try {
            require __DIR__ . '/../includes/database.php';

            // Hashear la contraseña
            $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);

            $query = "INSERT INTO " . self::$tabla . " (id_tipo_usuario, nombre, edad, correo, usuario, contraseña, estatus) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isssssi', $this->id_tipo_usuario, $this->nombre, $this->edad, $this->correo, $this->usuario, $this->contraseña, $this->estatus);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function login() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE usuario = ? LIMIT 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $this->usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $user = new Usuario(mysqli_fetch_assoc($result));
                if (password_verify($this->contraseña, $user->contraseña)) {
                    // Crear la variable de sesión
                    session_start();
                    $_SESSION['id'] = $user->id;
                    $_SESSION['nombre'] = $user->nombre;
                    $_SESSION['correo'] = $user->correo;
                    $_SESSION['usuario'] = $user->usuario;
                    $_SESSION['id_tipo_usuario'] = $user->id_tipo_usuario;
                    $_SESSION['estatus'] = $user->estatus;
                    $_SESSION['login'] = true;

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function where($column, $value) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE $column = ? LIMIT 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $value);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                return mysqli_fetch_assoc($result);
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    } 
}