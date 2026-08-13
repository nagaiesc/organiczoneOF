<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "organiczoneBD"
);

if ($conexion->connect_error) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error de conexión con la base de datos: " . $conexion->connect_error
    ]);
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$metodo = trim($_POST['metodo'] ?? '');

if ($nombre === '' || $telefono === '' || $direccion === '' || $metodo === '') {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Todos los campos son obligatorios."
    ]);

    exit();
}

$fecha = date('Y-m-d');
$estado = "Pendiente";
$nombrevendedor = null;

$sql = "INSERT INTO pedidos
        (nombre, fecha, estado, nombrevendedor, direccion, telefono, metodo)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al preparar la consulta: " . $conexion->error
    ]);

    exit();
}

$stmt->bind_param(
    "sssssss",
    $nombre,
    $fecha,
    $estado,
    $nombrevendedor,
    $direccion,
    $telefono,
    $metodo
);

if (!$stmt->execute()) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al crear el pedido: " . $stmt->error
    ]);

    $stmt->close();
    $conexion->close();
    exit();
}

$pedidoId = $stmt->insert_id;

$_SESSION['pedido_id'] = $pedidoId;
$_SESSION['pedido_confirmado'] = false;

echo json_encode([
    "ok" => true,
    "mensaje" => "Pedido creado correctamente.",
    "pedido_id" => $pedidoId
]);

$stmt->close();
$conexion->close();

?>