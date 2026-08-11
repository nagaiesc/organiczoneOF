<?php
session_start(); 

 if ($_SESSION['rol'] != "admin") { 
    die("No tienes permiso para eliminar ventas.");
 }
 
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
    die("Hubo un error en la conexion");
}


$id = $_GET['id'];




$sql = "SELECT * FROM ventas WHERE id = $id";
$resultado = $conexion->query($sql);


if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();
    $pedidos_id = $fila['pedidos_id'];

    // BUSCAMOS LOS PRODUCTOS DEL PEDIDO

    $sqlCarrito = "SELECT productos_id, cantidad
                   FROM carrito
                   WHERE pedidos_id = '$pedidos_id'";

    $resultadoCarrito = $conexion->query($sqlCarrito);

    // DEVOLVEMOS EL STOCK

    while ($producto = $resultadoCarrito->fetch_assoc()) {

        $productos_id = $producto['productos_id'];

        $cantidad = $producto['cantidad'];

        $sqlStock = "UPDATE productos
                     SET stock = stock + '$cantidad'
                     WHERE id = '$productos_id'";
         $conexion->query($sqlStock); 
    }

    // ELIMINAMOS LA VENTA

    $sqlEliminar = "DELETE FROM ventas WHERE id = $id";

    if ($conexion->query($sqlEliminar) === TRUE) {
        header("Location: leerventas.php");
        exit();
    } else {
        echo "Error al eliminar la venta: " . $conexion->error;
    }
} else {
    echo "La venta no existe.";
}

$conexion->close();

?>

