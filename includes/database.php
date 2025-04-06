<?php
$host = "bpcafylogojfnatuctzn-mysql.services.clever-cloud.com";
$port = "3306";
$usuario = "u0zljesyfj7kegrd";
$password = "lBkeOhtdL2VRGzFdtQxZ";
$base_datos = "bpcafylogojfnatuctzn";

$db = mysqli_connect($host, $usuario, $password, $base_datos, $port);

if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>