<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$idPedido = $_GET['idPedido'];

$sql = "SELECT * FROM productos";

$resultado = $conn->query($sql);

$sqlTotal = "SELECT SUM(costototal) FROM carrito
WHERE pedidos_id='$idPedido' ";

$resultadoTotal=$conn->query($sqlTotal);

$res=$resultadoTotal >fetch_assoc();
$total = $res['SUM(costototal)'];

if($total == NULL){
    $total = 0;
}

echo "<h2>Pedido Nº ".$idPedido."</h2>";

echo "<h3>Total: Bs ".$total."</h3>";

echo "<table border='1'>";

echo "<tr>

    <th>ID</th>
    <th>Nombre</th>
    <th>Precio</th>
    <th>Descripcion</th>
    <th>Cantidad</th>
    <th>Agregar</th>

    </tr>";
while($fila = $resultado->fetch_assoc()){

    echo "<form action='agregarCarrito.php' method='POST'>";

    echo "<tr>";

    echo "<td>".$fila['id']."</td>";
    echo "<td>".$fila['nombre']."</td>";
    echo "<td>".$fila['precio']."</td>";
    echo "<td>".$fila['descripcion']."</td>";

    
echo "<input type='hidden'
    name='idProducto'
    value='".$fila['id']."'>";
echo "<input type='hidden'
        name='idPedido'
        value='".$idPedido."'>";

echo "<input type='hidden'
        name='precio'
        value='".$fila['precio']."'>";
echo "<td>
            <input
                type='number'
                name='cantidad'
                value='1'
                min='1'>
          </td>";
echo "<td>
            <input
                type='submit'
                value='Agregar'>
          </td>";
echo "</tr>";
echo "</form>";
}

echo "</table>";

echo "<br>";
