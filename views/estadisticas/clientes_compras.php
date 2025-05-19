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

// Consulta para obtener clientes por compras con paginación
$sql = "SELECT u.id, u.nombre, COUNT(p.id) as total_compras, MAX(p.fecha) as ultima_compra 
        FROM usuario u 
        JOIN pedido p ON u.id = p.id_usuario 
        WHERE p.estatus = 'entregado'
        GROUP BY u.id 
        ORDER BY total_compras DESC 
        LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $inicio, $elementosPorPagina);
$stmt->execute();
$result = $stmt->get_result();

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

// Obtener el total de registros para la paginación
$sqlCount = "SELECT COUNT(DISTINCT u.id) as total 
             FROM usuario u 
             JOIN pedido p ON u.id = p.id_usuario
             WHERE p.estatus = 'entregado'";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalPaginas = ceil($rowCount['total'] / $elementosPorPagina);

// Devolver resultados en formato JSON
header('Content-Type: application/json');
echo json_encode([
    'items' => $clientes,
    'total_paginas' => $totalPaginas,
    'pagina_actual' => $pagina
]);

// Cerrar la conexión
$conn->close();
?>
