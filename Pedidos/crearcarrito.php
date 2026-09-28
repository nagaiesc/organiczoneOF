<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/* Verificar que exista el pedido */
if (!isset($_POST["pedidos_id"])) {
    die("No existe un pedido seleccionado");
}

/* Verificar que lleguen todos los datos necesarios */
if (
    !isset($_POST["productos_id"]) ||
    !isset($_POST["cantidad"]) ||
    !isset($_POST["precio"])
) {
    die("Faltan datos para agregar el producto al carrito");
}

$idProducto = $_POST["productos_id"];
$idPedido = $_POST["pedidos_id"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];

/* Calcular total */
$total = $precio * $cantidad;

/* 
   Buscar si el producto ya existe
   dentro del carrito del pedido actual
*/
$stmt = $conn->prepare(
    "SELECT * FROM carrito 
     WHERE productos_id = ? 
     AND pedidos_id = ?"
);

$stmt->bind_param("ii", $idProducto, $idPedido);
$stmt->execute();

$resultado = $stmt->get_result();

/* 
   Si el producto ya existe,
   actualizar cantidad y costo total
*/
if ($resultado->num_rows > 0) {

    $stmt = $conn->prepare(
        "UPDATE carrito 
         SET cantidad = ?, costototal = ?
         WHERE productos_id = ?
         AND pedidos_id = ?"
    );

    $stmt->bind_param(
        "idii",
        $cantidad,
        $total,
        $idProducto,
        $idPedido
    );

/* 
   Si no existe,
   insertar un nuevo producto
*/
} else {

    $stmt = $conn->prepare(
        "INSERT INTO carrito
        (productos_id, pedidos_id, cantidad, costototal)
        VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "iiid",
        $idProducto,
        $idPedido,
        $cantidad,
        $total
    );
}

/* Ejecutar actualización o inserción */
if ($stmt->execute()) {

    header("Location: leercarrito.php?pedidos_id=" . $idPedido);
    exit();

} else {

    echo "Error: " . $stmt->error;
}

?>