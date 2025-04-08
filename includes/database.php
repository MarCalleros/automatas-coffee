<?php
$host = "localhost";
$port = "3306";
$usuario = "automatascoffe";
$password = "admin1234";
$base_datos = "automatascoffedb_automatas_coffee";

$db = mysqli_connect($host, $usuario, $password, $base_datos, $port);

if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>