<?php

session_start();

$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error de conexión"
    ]);

    exit();

}


/* Verificamos que exista un pedido */

if (!isset($_SESSION['pedido_id'])) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe un pedido abierto"
    ]);

    exit();

}

$idPedido = intval($_SESSION['pedido_id']);


/* Verificamos el producto */

if (!isset($_POST['productos_id'])) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibió el producto"
    ]);

    exit();

}

$idProducto = intval($_POST['productos_id']);


/* Buscamos el producto en la base de datos */

$sqlProducto = "SELECT * FROM productos
                WHERE id='$idProducto'";

$resultadoProducto = $conexion->query($sqlProducto);

if ($resultadoProducto->num_rows == 0) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "El producto no existe"
    ]);

    exit();

}

$producto = $resultadoProducto->fetch_assoc();

$precio = intval($producto['precio']);


/* Revisamos si ya está en el carrito */

$sqlBuscar = "SELECT * FROM carrito
              WHERE pedidos_id='$idPedido'
              AND productos_id='$idProducto'";

$resultadoBuscar = $conexion->query($sqlBuscar);


if ($resultadoBuscar->num_rows > 0) {

    /* Si ya existe, aumentamos la cantidad */

    $fila = $resultadoBuscar->fetch_assoc();

    $cantidad = intval($fila['cantidad']) + 1;

    $total = $precio * $cantidad;

    $sql = "UPDATE carrito SET
            cantidad='$cantidad',
            costototal='$total'
            WHERE pedidos_id='$idPedido'
            AND productos_id='$idProducto'";

} else {

    /* Si no existe, creamos una nueva fila */

    $cantidad = 1;

    $total = $precio * $cantidad;

    $sql = "INSERT INTO carrito
            (pedidos_id, productos_id, cantidad, costototal)
            VALUES
            ('$idPedido', '$idProducto', '$cantidad', '$total')";
}


if ($conexion->query($sql)) {

    echo json_encode([
        "ok" => true,
        "mensaje" => "Producto agregado"
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo agregar el producto"
    ]);

}

$conexion->close();

?>