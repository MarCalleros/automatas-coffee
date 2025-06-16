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

// Consulta para obtener productos por ingresos con paginación
$sql = "SELECT p.id, p.nombre, SUM(dp.subtotal) as ingresos, SUM(dp.cantidad) as cantidad_vendida 
        FROM detalle_pedido dp 
        JOIN producto p ON dp.id_producto = p.id 
        JOIN pedido pe ON dp.id_pedido = pe.id
        WHERE pe.estatus = 'entregado'
        GROUP BY p.id 
        ORDER BY ingresos DESC 
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
             FROM detalle_pedido dp 
             JOIN producto p ON dp.id_producto = p.id
             JOIN pedido pe ON dp.id_pedido = pe.id
             WHERE pe.estatus = 'entregado'";
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
