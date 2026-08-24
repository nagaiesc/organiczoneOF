<?php
session_start();
header('Content-Type: application/json; charset=utf-8');



$pedidoId = (int) ($_SESSION['pedido_id'] ?? 0);
$productoId = (int) ($_POST['productos_id'] ?? 0);
$cantidad = (int) ($_POST['cantidad'] ?? 0);

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

$conexion->set_charset('utf8mb4');

if ($cantidad <= 0) {
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
    echo json_encode(['ok' => true, 'mensaje' => 'Producto eliminado.']);
    exit();
}

$stmtProducto = $conexion->prepare('SELECT precio, stock, nombre FROM productos WHERE id = ? LIMIT 1');
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

if ($cantidad > $stock) {
    http_response_code(409);
    echo json_encode(['ok' => false, 'mensaje' => 'Solo hay ' . $stock . ' unidades disponibles de ' . $producto['nombre'] . '.']);
    $conexion->close();
    exit();
}

$total = $precio * $cantidad;

$stmt = $conexion->prepare('UPDATE carrito SET cantidad = ?, costototal = ? WHERE pedidos_id = ? AND productos_id = ?');
$stmt->bind_param('iiii', $cantidad, $total, $pedidoId, $productoId);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'No se pudo actualizar la cantidad.']);
    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();
$conexion->close();

echo json_encode(['ok' => true, 'mensaje' => 'Cantidad actualizada.']);
