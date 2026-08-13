<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['CI']) || ($_SESSION['rol'] ?? '') !== 'cliente') {
    http_response_code(401);
    echo json_encode(['ok' => false, 'mensaje' => 'Sesión no válida.']);
    exit();
}

$pedidoId = (int) ($_SESSION['pedido_id'] ?? 0);
$productoId = (int) ($_POST['productos_id'] ?? 0);

if ($pedidoId <= 0 || $productoId <= 0) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'mensaje' => 'Datos no válidos.']);
    exit();
}

if (!empty($_SESSION['pedido_confirmado'])) {
    http_response_code(409);
    echo json_encode(['ok' => false, 'mensaje' => 'El pedido ya fue finalizado.']);
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'organiczoneBD');

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'Error de conexión.']);
    exit();
}

$stmt = $conexion->prepare('DELETE FROM carrito WHERE pedidos_id = ? AND productos_id = ?');
$stmt->bind_param('ii', $pedidoId, $productoId);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'No se pudo eliminar el producto.']);
    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();
$conexion->close();

echo json_encode(['ok' => true, 'mensaje' => 'Producto eliminado del carrito.']);
