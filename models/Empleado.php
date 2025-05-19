<?php

namespace Model;

class Empleado {
    private static $tabla = 'empleados';

    public $id;
    public $id_usuario;
    public $nombre;
    public $email;
    public $ID_NFC;
    public $contraseña;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['nombre'] ?? '';
    }
}