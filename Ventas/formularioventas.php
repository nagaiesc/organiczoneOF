<?php
if (isset($_GET['pedido'])) {
    $pedidos_id = $_GET['pedido'];
} else {
    die("No se recibió el pedido.");
}

$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";
 $conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);
  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }

//Buscamos los productos del pedido para luego mostrar el stock
$sqlCarrito = "SELECT productos_id, cantidad FROM carrito WHERE pedidos_id = '$pedidos_id'";
$resultadoCarrito = $conn->query($sqlCarrito);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
</head>
<body>

    <h2>Registrar Venta</h2>
    <h3>Productos del pedido</h3>

    <table border="1"> 
        <tr> 
            <th>Producto</th> 
            <th>Stock disponible</th> 
            <th>Cantidad solicitada</th> 
        </tr>

    <?php 
    while ($producto = $resultadoCarrito->fetch_assoc()) { 
            $productos_id = $producto['productos_id']; 
            $cantidad = $producto['cantidad'];
    //Buscar el producto
    $sqlProducto = "SELECT nombre, stock FROM productos WHERE id = '$productos_id'";

    $resultadoProducto = $conn->query($sqlProducto); 
    $datosProducto = $resultadoProducto->fetch_assoc();
    ?>

    <tr> 
        <td> <?php echo $datosProducto['nombre']; ?> </td> 
        <td> <?php echo $datosProducto['stock']; ?> </td> 
        <td> <?php echo $cantidad; ?> </td> 
    </tr>

    <?php 
    } 
    ?> 
    </table> 
    <br>

    <form action="ventas.php" method="POST">

        <input type="hidden" name="pedidos_id" value="<?php echo $pedidos_id; ?>">

        <label>Método de Pago</label>
        <select name="metodo" required>
            <option value="">Seleccione</option>
            <option value="Efectivo">Efectivo</option>
            <option value="QR">QR</option>
            <option value="Transferencia">Transferencia</option>
        </select>

        <br><br>

        <button type="submit">Registrar Venta</button>

    </form>

</body>
</html>

<?php 
    $conn->close(); 
?>