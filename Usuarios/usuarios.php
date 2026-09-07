<?php

header('Content-Type: application/json; charset=utf-8');

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli(
    $nombreServidor,
    $nombreUsuario,
    $contraseñaBaseDeDatos,
    $nombreBaseDeDatos
);

if ($conexion->connect_error) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error de conexión con la base de datos."
    ]);
    exit;
}

$conexion->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Solicitud no válida."
    ]);
    exit;
}

$CI = trim($_POST['CI'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$celular = trim($_POST['celular'] ?? '');
$rol = trim($_POST['rol'] ?? '');

$estado = "activo";

if (
    $CI === '' ||
    $nombre === '' ||
    $direccion === '' ||
    $celular === '' ||
    $rol === ''
) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Todos los campos son obligatorios."
    ]);
    exit;
}

$sql = "INSERT INTO usuarios 
        (CI, nombre, direccion, celular, rol, estado)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error al preparar el registro: " . $conexion->error
    ]);
    exit;
}

$stmt->bind_param(
    "ssssss",
    $CI,
    $nombre,
    $direccion,
    $celular,
    $rol,
    $estado
);

if ($stmt->execute()) {

    echo json_encode([
        "estado" => "exito",
        "mensaje" => "El usuario ha sido registrado correctamente."
    ]);

} else {

    if ($stmt->errno == 1062) {

        echo json_encode([
            "estado" => "error",
            "mensaje" => "El Carnet de Identidad ya está registrado."
        ]);

    } else {

        echo json_encode([
            "estado" => "error",
            "mensaje" => "No se pudo registrar el usuario: " . $stmt->error
        ]);
    }
}

$stmt->close();
$conexion->close();

?>

