<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

if ($conexion->connect_error) {
    die("Hubo un error en la conexion");
}

$id = $_GET['id'];

// Primero eliminamos los productos del carrito que pertenecen a este pedido
$sqlCarrito = "DELETE FROM carrito WHERE pedidos_id = $id";

if ($conexion->query($sqlCarrito) === TRUE) {
    // Ahora que el carrito ya no tiene productos relacionados con el pedido, podemos eliminar el pedido.
    $sqlPedido = "DELETE FROM pedidos WHERE id = $id";

    if ($conexion->query($sqlPedido) === TRUE) {
        header("Location: leerpedidos.php");
        exit();
    } else {
        echo "Error al eliminar el pedido: " . $conexion->error;
    }
} else {
    echo "Error al eliminar los productos del pedido: " . $conexion->error;
}

$conexion->close();
?>