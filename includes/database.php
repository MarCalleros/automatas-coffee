<?php
$host = "localhost";
$port = "3306";
$usuario = "root";
$password = "kaze1234";
$base_datos = "db_automatas_coffee";

$db = mysqli_connect($host, $usuario, $password, $base_datos, $port);

if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer el charset a UTF-8
if (!mysqli_set_charset($db, "utf8")) {
    die("Error al establecer el conjunto de caracteres UTF-8: " . mysqli_error($db));
}
?>