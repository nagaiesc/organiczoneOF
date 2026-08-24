<?php
session_start();
header('Content-Type: application/json; charset=utf-8');



$pedidoId = (int) ($_SESSION['pedido_id'] ?? 0);

if ($pedidoId <= 0) {
    echo json_encode(['ok' => true, 'items' => [], 'total' => 0]);
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'organiczoneBD');

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'Error de conexión.']);
    exit();
}

$conexion->set_charset('utf8mb4');

$stmt = $conexion->prepare('SELECT c.productos_id, c.cantidad, c.costototal, p.nombre, p.precio, p.stock FROM carrito c INNER JOIN productos p ON p.id = c.productos_id WHERE c.pedidos_id = ? ORDER BY p.nombre');
$stmt->bind_param('i', $pedidoId);
$stmt->execute();
$resultado = $stmt->get_result();

$items = [];
$total = 0;

while ($fila = $resultado->fetch_assoc()) {
    $fila['productos_id'] = (int) $fila['productos_id'];
    $fila['cantidad'] = (int) $fila['cantidad'];
    $fila['costototal'] = (int) $fila['costototal'];
    $fila['precio'] = (int) $fila['precio'];
    $fila['stock'] = (int) ($fila['stock'] ?? 0);
    $total += $fila['costototal'];
    $items[] = $fila;
}

$stmt->close();
$conexion->close();

echo json_encode([
    'ok' => true,
    'items' => $items,
    'total' => $total
]);
