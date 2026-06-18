<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$idProducto = $_POST["idProducto"];
$idPedido = $_POST["idPedido"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];

$total = $precio * $cantidad;

$sql = "INSERT INTO carrito
( productos_id, pedidos_id, cantidad, costototal )
VALUES
( '$idProducto', '$idPedido', '$cantidad', '$total')";

if($conn->query($sql)){

    header("Location: carrito.php?idPedido=".$idPedido);

}else{

    echo "El producto ya fue agregado al pedido.<br><br>";

    echo "<a href='carrito.php?idPedido=".$idPedido."'>
            <button>Volver</button>
          </a>";
}

?>