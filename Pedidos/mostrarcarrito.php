<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$idPedido = isset($_GET['pedidos_id']) ? $_GET['pedidos_id'] : 0;

$sql = "SELECT * FROM carrito WHERE pedidos_id='$idPedido'";
$resultado = $conn->query($sql);

echo "<h2> Carrito del Pedido Nº ".$idPedido."</h2>";
echo "<table border='1'>";

echo "<tr>
        <th>ID Producto</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Costo Total</th>
        <th>Editar</th>
        <th>Eliminar</th>
      </tr>";

while($fila = $resultado->fetch_assoc()){
    $idProducto = $fila['productos_id'];
    $sqlProducto = "SELECT * FROM productos WHERE id='$idProducto'";
    $resultadoProducto = $conn->query($sqlProducto);

    $producto = $resultadoProducto->fetch_assoc();

    echo "<tr>";
          echo "<td>".$producto['id']."</td>";
          echo "<td>".$producto['nombre']."</td>";
          echo "<td>".$producto['precio']."</td>";
          echo "<td>".$fila['cantidad']."</td>";
          echo "<td>".$fila['costototal']."</td>";

          echo "<td><a href='editarcarrito.php?pedidos_id=".$fila['pedidos_id']."&productos_id=".$fila['productos_id']."'>Editar</a></td>";
          echo "<td><a href='eliminarcarrito.php?pedidos_id=".$fila['pedidos_id']."&productos_id=".$fila['productos_id']."'>Eliminar</a></td>";
    echo "</tr>";
}

echo "</table>";
echo "<br>";
echo "<a href='leercarrito.php?pedidos_id=".$idPedido."'>Volver</a>";

$conn->close();

?>