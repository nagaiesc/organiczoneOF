<?php
session_start();
header('Content-Type: application/json; charset=utf-8');



$pedidoId = (int) ($_SESSION['pedido_id'] ?? 0);

if ($pedidoId <= 0) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'mensaje' => 'Primero debes crear un pedido.']);
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'organiczoneBD');

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'Error de conexión.']);
    exit();
}

$stmt = $conexion->prepare("SELECT estado FROM pedidos WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $pedidoId);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$pedido || $pedido['estado'] !== 'Pendiente') {
    http_response_code(409);
    echo json_encode(['ok' => false, 'mensaje' => 'El pedido ya no está pendiente.']);
    $conexion->close();
    exit();
}

$stmt = $conexion->prepare('SELECT COUNT(*) AS cantidad FROM carrito WHERE pedidos_id = ?');
$stmt->bind_param('i', $pedidoId);
$stmt->execute();
$carrito = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ((int) $carrito['cantidad'] === 0) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'mensaje' => 'Agrega al menos un producto antes de finalizar.']);
    $conexion->close();
    exit();
}

$_SESSION['pedido_confirmado'] = true;

$conexion->close();

echo json_encode([
    'ok' => true,
    'pedido_id' => $pedidoId,
    'mensaje' => 'Pedido finalizado correctamente.'
]);
