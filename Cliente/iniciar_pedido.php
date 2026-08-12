<?php

session_start();

$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {
    die(json_encode([
        "ok" => false,
        "mensaje" => "Error en la conexión"
    ]));
}


/* Verificamos que haya iniciado sesión */

if (!isset($_SESSION['CI'])) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Debes iniciar sesión"
    ]);

    exit();

}


/* Si ya existe un pedido abierto, utilizamos ese */

if (isset($_SESSION['pedido_id'])) {

    $idPedido = intval($_SESSION['pedido_id']);

    $sql = "SELECT * FROM pedidos WHERE id='$idPedido' AND estado='Abierto'";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {

        echo json_encode([
            "ok" => true,
            "idPedido" => $idPedido
        ]);

        exit();

    }

}


/* Buscamos los datos del cliente */

$CI = intval($_SESSION['CI']);

$sqlUsuario = "SELECT * FROM usuarios
               WHERE CI='$CI'";

$resultadoUsuario = $conexion->query($sqlUsuario);

if ($resultadoUsuario->num_rows == 0) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se encontró el usuario"
    ]);

    exit();

}

$usuario = $resultadoUsuario->fetch_assoc();

$nombre = $usuario['nombre'];
$direccion = $usuario['direccion'];
$telefono = $usuario['celular'];

$fecha = date("Y-m-d");


/* Creamos el pedido */

$sql = "INSERT INTO pedidos (nombre, fecha, estado, nombrevendedor, direccion, telefono)
        VALUES ('$nombre', '$fecha', 'Abierto', NULL, '$direccion', '$telefono')";


if ($conexion->query($sql)) {

    $idPedido = $conexion->insert_id;

    $_SESSION['pedido_id'] = $idPedido;

    echo json_encode([
        "ok" => true,
        "idPedido" => $idPedido
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo crear el pedido"
    ]);

}

$conexion->close();

?>