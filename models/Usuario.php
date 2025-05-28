<?php

namespace Model;
use Class\Email;
use Ramsey\Uuid\Uuid;

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
    public $confirmado;
    public $token; // UUID de 12 caracteres alfanuméricos
    public $nfc_id;

    public $tipo_usuario;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_tipo_usuario = $args['id_tipo_usuario'] ?? 2;
        $this->nombre = $args['nombre'] ?? null;
        $this->edad = $args['edad'] ?? null;
        $this->correo = $args['correo'] ?? null;
        $this->usuario = $args['usuario'] ?? null;
        $this->contraseña = $args['contraseña'] ?? null;
        $this->estatus = $args['estatus'] ?? 1;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? null;
        $this->nfc_id = $args['nfc_id'] ?? null;
    }
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
                $usuarios = [];
    
                while ($row = mysqli_fetch_assoc($result)) {
                    $usuario = new Usuario($row);

                    $query = "SELECT * FROM tipo_usuario WHERE id = ?";
                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, 'i', $usuario->id_tipo_usuario);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);

                    if ($res->num_rows > 0) {
                        $tipo_usuario = mysqli_fetch_assoc($res);
                        $usuario->tipo_usuario = $tipo_usuario['nombre'];
                    } else {
                        $usuario->tipo_usuario = null;
                    }

                    $usuarios[] = $usuario;
                }
                
                return $usuarios;
            } else {
                return [];
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    // Funcion para obtener a todos los usuarios activos 
    public static function allActiveAsc() {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);

            $query = "SELECT * FROM " . static::$tabla . " WHERE estatus = 1 ";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            //mysqli_close($db);

            if ($result->num_rows > 0) {
                $usuarios = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $usuarios[] = new Usuario($row);
                }

                return $usuarios;
            } else {
                return [];
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }     
    }

    // Funcion para agregar un nuevo usuario
    public function save() {
        require __DIR__ . '/../includes/database.php';
    
        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);
    
            // Comprobar que no existe un usuario con el mismo correo
            if (self::find('correo', $this->correo)) {
                return "El correo ya se encuentra registrado"; // Ya existe un usuario con el mismo correo
            }
            // Comprobar que no existe un usuario con el mismo nombre de usuario
            if (self::find('usuario', $this->usuario)) {
                return "El nombre de usuario ya se encuentra registrado"; // Ya existe un usuario con el mismo nombre de usuario
            }
            
            $this->estatus = 1; // Establecer estatus por defecto a 1 (activo)
            // Hashear la contraseña antes de guardar
            $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);
    
            $query = "INSERT INTO " . static::$tabla . " (id_tipo_usuario, nombre, edad, correo, usuario, contraseña, estatus, confirmado,nfc_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isssssiis', $this->id_tipo_usuario, $this->nombre, $this->edad, $this->correo, $this->usuario, $this->contraseña, $this->estatus, $this->confirmado , $this->nfc_id);
            $executed = mysqli_stmt_execute($stmt);
    
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;
        } finally {
            // Reactivar reporte de errores
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    // Funcion para actualizar un usuario
    public function update() {
        require __DIR__ . '/../includes/database.php';
    
        try {
            mysqli_report(MYSQLI_REPORT_OFF);
    
            $query = "UPDATE " . static::$tabla . " SET id_tipo_usuario = ?, nombre = ?, edad = ?, correo = ?, usuario = ?, contraseña = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
    
            // Solo hashear la contraseña si no está vacía
            if (!empty($this->contraseña)) {
                $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);

                $query = "UPDATE " . static::$tabla . " SET id_tipo_usuario = ?, nombre = ?, edad = ?, correo = ?, usuario = ?, contraseña = ? WHERE id = ?";
                $stmt = mysqli_prepare($db, $query);

                mysqli_stmt_bind_param($stmt, 'isssssi', $this->id_tipo_usuario, $this->nombre, $this->edad, $this->correo, $this->usuario, $this->contraseña, $this->id);
            } else {
                $query = "UPDATE " . static::$tabla . " SET id_tipo_usuario = ?, nombre = ?, edad = ?, correo = ?, usuario = ? WHERE id = ?";
                $stmt = mysqli_prepare($db, $query);

                mysqli_stmt_bind_param($stmt, 'issssi', $this->id_tipo_usuario, $this->nombre, $this->edad, $this->correo, $this->usuario, $this->id);
            }
    
            $executed = mysqli_stmt_execute($stmt);
    
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

    public function updatePassword() {
        require __DIR__ . '/../includes/database.php';

        try {
            mysqli_report(MYSQLI_REPORT_OFF);

            $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);
            $query = "UPDATE " . static::$tabla . " SET contraseña = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'si', $this->contraseña, $this->id);
            $executed = mysqli_stmt_execute($stmt);

            return $executed && mysqli_stmt_affected_rows($stmt) > 0;
        } finally {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }

      // Funcion para cambiar el estatus de un usuario
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

    // Funcion para cambiar la confirmacion de un usuario
    public function changeConfirmation() {
        require __DIR__ . '/../includes/database.php';

        try {
            // Desactivar reporte de errores temporalmente
            mysqli_report(MYSQLI_REPORT_OFF);
            
            $query = "UPDATE " . static::$tabla . " SET confirmado = ? WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $this->confirmado, $this->id);
            $executed = mysqli_stmt_execute($stmt);
            
            return $executed && mysqli_stmt_affected_rows($stmt) > 0;
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }
    
    // Funcion para buscar un usuario por ID
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
                return new Usuario(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
        }
    }

    // Funcion para buscar un usuario por algun atributo
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
                return new Usuario(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } finally {
            // Reactivar reporte de errores y cerrar la conexión
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            //mysqli_close($db);
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
            } while (self::where('token', $uuid)); // Verificar que no exista otro mensaje con el mismo UUID

            // Hashear la contraseña
            $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);

            $query = "INSERT INTO " . self::$tabla . " (id_tipo_usuario, nombre, edad, correo, usuario, contraseña, estatus, confirmado, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'isssssiis', $this->id_tipo_usuario, $this->nombre, $this->edad, $this->correo, $this->usuario, $this->contraseña, $this->estatus, $this->confirmado, $uuid);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $email = new Email();
                $email->correo = $this->correo;
                $email->nombre = $this->nombre;
                $email->token = $uuid;
                return $email->sendConfirmationEmail();
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

                if ($user->confirmado == 0) {
                    return false; // Usuario inactivo
                }
                
                if (password_verify($this->contraseña, $user->contraseña)) {
                    // Crear la variable de sesión
                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    // Guardar los datos del usuario en la sesión
                    $_SESSION['id'] = $user->id;
                    $_SESSION['nombre'] = $user->nombre;
                    $_SESSION['edad'] = $user->edad;
                    $_SESSION['correo'] = $user->correo;
                    $_SESSION['usuario'] = $user->usuario;
                    $_SESSION['id_tipo_usuario'] = $user->id_tipo_usuario;
                    $_SESSION['estatus'] = $user->estatus;
                    $_SESSION['confirmado'] = $user->confirmado;
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
    public function loginnfc() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE usuario = ? LIMIT 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $this->usuario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $user = new Usuario(mysqli_fetch_assoc($result));

                if ($user->confirmado == 0) {
                    return false; // Usuario inactivo
                }
                
                    if (password_verify($this->contraseña, $user->contraseña)) {
                        // Crear la variable de sesión
                        if (!isset($_SESSION)) {
                            session_start();
                        }

                        // Guardar los datos del usuario en la sesión
                        $_SESSION['id'] = $user->id;
                        $_SESSION['nombre'] = $user->nombre;
                        $_SESSION['edad'] = $user->edad;
                        $_SESSION['correo'] = $user->correo;
                        $_SESSION['usuario'] = $user->usuario;
                        $_SESSION['id_tipo_usuario'] = $user->id_tipo_usuario;
                        $_SESSION['estatus'] = $user->estatus;
                        $_SESSION['confirmado'] = $user->confirmado;
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
                return new Usuario(mysqli_fetch_assoc($result));
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
    
    public static function getDeliverymanUsersAvaiable($id = null) {
        require __DIR__ . '/../includes/database.php';

        try {
            // Primero obtener todos los usuarios que son repartidores
            $query = "SELECT * FROM " . self::$tabla . " WHERE id_tipo_usuario = 3";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $deliverymen = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $deliverymen[] = new Usuario($row);
                }

                // Ahora obtener los repartidores, los cuales tienen un usuario asociado
                if ($id != null) {
                    $query = "SELECT id_usuario FROM repartidor WHERE id != ? AND id_usuario IS NOT NULL";
                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, 'i', $id);
                } else {
                    $query = "SELECT id_usuario FROM repartidor WHERE id_usuario IS NOT NULL";
                    $stmt = mysqli_prepare($db, $query);
                }
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $usedUserIds = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $usedUserIds[] = $row['id_usuario'];
                }

                // Filtrar los usuarios que no están en la lista de repartidores
                $deliverymen = array_filter($deliverymen, function($user) use ($usedUserIds) {
                    return !in_array($user->id, $usedUserIds);
                });

                // Devolver los usuarios que no están en la lista de repartidores
                if (count($deliverymen) > 0) {
                    return $deliverymen;
                } else {
                    return []; // No hay usuarios disponibles
                }
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function confirm($token) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "UPDATE " . self::$tabla . " SET confirmado = 1, token = null WHERE token = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $token);
            $result = mysqli_stmt_execute($stmt);

            return $result && mysqli_stmt_affected_rows($stmt) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function count() {
        require __DIR__ . '/../includes/database.php';

        try {
            $query = "SELECT COUNT(*) as total FROM " . self::$tabla;
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                return mysqli_fetch_assoc($result)['total'];
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function countConfirmed() {
        require __DIR__ . '/../includes/database.php';

        try {
            $query = "SELECT COUNT(*) as total FROM " . self::$tabla . " WHERE confirmado = 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                return mysqli_fetch_assoc($result)['total'];
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function verifyDeliverymanCredentials(String $user, String $pass) {
        require __DIR__ . '/../includes/database.php';

    
        try {
            $query = "SELECT * FROM " .self::$tabla . " WHERE usuario = ? AND id_tipo_usuario = 3";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 's', $user);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($pass, $row['contraseña'])) {
                    return true;
                } else {
                    return false; // Contraseña incorrecta
                }
            } else {
                return false; //Usuario no encontrado
            }
        } catch (\Exception $e) {
            return 0; // Error en la consulta
        }
    }
}