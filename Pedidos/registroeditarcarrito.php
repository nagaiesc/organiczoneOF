<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$pedidos_id = $_POST['pedidos_id'];
$productos_id = $_POST['productos_id'];
$cantidad = $_POST['cantidad'];

/*Obetener el precio del producto*/
$sqlProducto= "SELECT precio FROM productos WHERE id='$productos_id'";
$resultadoProducto = $conexion->query($sqlProducto);
$filaProducto = $resultadoProducto->fetch_assoc();

/*Calcular nuevo costo total*/
$costototal = $precio * $cantidad;

$sql = "UPDATE carrito SET cantidad='$cantidad', costototal='$costototal' WHERE pedidos_id = '$pedidos_id' AND productos_id = '$productos_id'" ;
if ($conexion->query($sql) === TRUE) {
    echo "Carrito editado correctamente";
    header("Location: leercarrito.php?pedidos_id=".$pedidos_id);
}
?>