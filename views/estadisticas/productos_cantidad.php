<?php
// Incluir archivo de conexión a la base de datos
require_once '../../includes/database.php';
require_once '../../includes/functions.php';

// Verificar si el usuario está autenticado como administrador
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

// Obtener parámetros de paginación
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$elementosPorPagina = 10;
$inicio = ($pagina - 1) * $elementosPorPagina;

// Consulta para obtener productos vendidos con paginación
$sql = "SELECT p.id, p.nombre, SUM(dc.cantidad) as cantidad_vendida, 
        ROUND(AVG(pt.precio), 2) as precio_promedio
        FROM detalle_compra dc
        JOIN producto p ON dc.id_producto = p.id
        JOIN producto_tamaño pt ON p.id = pt.id_producto AND dc.id_tamaño = pt.id_tamaño
        JOIN compra co ON dc.id_compra = co.id
        WHERE co.estatus = 'A'
        GROUP BY p.id
        ORDER BY cantidad_vendida DESC
        LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $inicio, $elementosPorPagina);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Obtener el total de registros para la paginación
$sqlCount = "SELECT COUNT(DISTINCT p.id) as total 
                FROM detalle_compra dc
                JOIN producto p ON dc.id_producto = p.id
                JOIN compra co ON dc.id_compra = co.id
                WHERE co.estatus = 'A'";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalPaginas = ceil($rowCount['total'] / $elementosPorPagina);

// Devolver resultados en formato JSON
header('Content-Type: application/json');
echo json_encode([
    'items' => $productos,
    'total_paginas' => $totalPaginas,
    'pagina_actual' => $pagina
]);

// Cerrar la conexión
$conn->close();
?>
