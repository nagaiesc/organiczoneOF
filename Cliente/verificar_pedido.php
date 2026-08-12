<?php

session_start();

if (isset($_SESSION['pedido_id'])) {

    $idPedido = intval($_SESSION['pedido_id']);

    $conexion = new mysqli("localhost", "root", "", "organiczoneBD");

    if ($conexion->connect_error) {

        echo json_encode([
            "ok" => false
        ]);

        exit();

    }

    $sql = "SELECT * FROM pedidos
            WHERE id='$idPedido'
            AND estado='Abierto'";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {

        echo json_encode([
            "ok" => true,
            "idPedido" => $idPedido
        ]);

    } else {

        unset($_SESSION['pedido_id']);

        echo json_encode([
            "ok" => false
        ]);

    }

    $conexion->close();

} else {

    echo json_encode([
        "ok" => false
    ]);

}

?>