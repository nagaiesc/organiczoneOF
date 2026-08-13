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
$cantidadAgregar = (int) ($_POST['cantidad'] ?? 1);

if ($pedidoId <= 0 || $productoId <= 0 || $cantidadAgregar <= 0) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'mensaje' => 'Datos de producto no válidos.']);
    exit();
}

if (!empty($_SESSION['pedido_confirmado'])) {
    http_response_code(409);
    echo json_encode(['ok' => false, 'mensaje' => 'El pedido ya fue finalizado. Crea una nueva compra.']);
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'organiczoneBD');

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'Error de conexión.']);
    exit();
}

$conexion->set_charset('utf8mb4');

$stmtPedido = $conexion->prepare("SELECT estado FROM pedidos WHERE id = ? LIMIT 1");
$stmtPedido->bind_param('i', $pedidoId);
$stmtPedido->execute();
$pedido = $stmtPedido->get_result()->fetch_assoc();
$stmtPedido->close();

if (!$pedido || $pedido['estado'] !== 'Pendiente') {
    http_response_code(409);
    echo json_encode(['ok' => false, 'mensaje' => 'Este pedido ya no está disponible para modificaciones.']);
    $conexion->close();
    exit();
}

$stmtProducto = $conexion->prepare('SELECT nombre, precio, stock FROM productos WHERE id = ? LIMIT 1');
$stmtProducto->bind_param('i', $productoId);
$stmtProducto->execute();
$producto = $stmtProducto->get_result()->fetch_assoc();
$stmtProducto->close();

if (!$producto) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'mensaje' => 'Producto no encontrado.']);
    $conexion->close();
    exit();
}

$stock = (int) ($producto['stock'] ?? 0);
$precio = (int) ($producto['precio'] ?? 0);

$stmtCarrito = $conexion->prepare('SELECT cantidad FROM carrito WHERE pedidos_id = ? AND productos_id = ? LIMIT 1');
$stmtCarrito->bind_param('ii', $pedidoId, $productoId);
$stmtCarrito->execute();
$carritoActual = $stmtCarrito->get_result()->fetch_assoc();
$stmtCarrito->close();

$cantidadActual = $carritoActual ? (int) $carritoActual['cantidad'] : 0;
$nuevaCantidad = $cantidadActual + $cantidadAgregar;

if ($nuevaCantidad > $stock) {
    http_response_code(409);
    echo json_encode([
        'ok' => false,
        'mensaje' => 'No hay suficiente stock de ' . $producto['nombre'] . '. Disponible: ' . $stock . '.'
    ]);
    $conexion->close();
    exit();
}

$total = $precio * $nuevaCantidad;

if ($carritoActual) {
    $stmt = $conexion->prepare('UPDATE carrito SET cantidad = ?, costototal = ? WHERE pedidos_id = ? AND productos_id = ?');
    $stmt->bind_param('iiii', $nuevaCantidad, $total, $pedidoId, $productoId);
} else {
    $stmt = $conexion->prepare('INSERT INTO carrito (pedidos_id, productos_id, cantidad, costototal) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('iiii', $pedidoId, $productoId, $nuevaCantidad, $total);
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'No se pudo actualizar el carrito.']);
    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();
$conexion->close();

echo json_encode([
    'ok' => true,
    'mensaje' => 'Producto agregado al carrito.'
]);
