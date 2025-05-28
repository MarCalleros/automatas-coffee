<?php
$host = "localhost";
$port = "3306";
$usuario = "automatascoffee";
$password = "admin1234";
$base_datos = "automatascoffee_db_automatas_coffee";

$db = mysqli_connect($host, $usuario, $password, $base_datos, $port);

if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}

$db = new mysqli($host, $usuario, $password, $base_datos, $port);

if ($db->connect_errno) {
    error_log("Error de conexión: " . $db->connect_error);
    die();
}

$db->set_charset('utf8');
?>