<?php

session_start();
header('Content-Type: application/json; charset=utf-8');
mysqli_report(MYSQLI_REPORT_OFF);


$conexion = new mysqli("localhost","root","","organiczoneBD"
);

if ($conexion->connect_error) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error de conexión con la base de datos."
    ]);
    exit();
}

$conexion->set_charset("utf8mb4");

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$metodo = trim($_POST['metodo'] ?? '');

if ($nombre === '' ||$telefono === '' ||$direccion === '' ||$metodo === ''
) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Todos los campos son obligatorios."
    ]);
    $conexion->close();
    exit();
}

$fecha = date("Y-m-d");

$estado = "Pendiente";

$sql = "INSERT INTO pedidos(nombre, fecha, estado, direccion, telefono, metodo)VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);


if (!$stmt) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al preparar el pedido: " . $conexion->error
    ]);
    $conexion->close();
    exit();
}

$stmt->bind_param("ssssss",$nombre,$fecha,$estado,$direccion,$telefono,$metodo
);
if (!$stmt->execute()) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo crear el pedido: " . $stmt->error
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