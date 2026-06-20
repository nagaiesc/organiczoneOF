<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if(!isset($_POST["pedidos_id"])){

    die("No existe un pedido seleccionado");

}

$idProducto = $_POST["productos_id"];
$idPedido = $_POST["pedidos_id"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];

$total = $precio * $cantidad;

$buscar = "SELECT * FROM carrito 
WHERE productos_id='$idProducto'
AND pedidos_id='$idPedido'";

$resultado = $conn->query($buscar);
if($resultado->num_rows > 0){
    $sql = "UPDATE carrito SET 
    cantidad='$cantidad',
    costototal='$total'
    WHERE productos_id='$idProducto'
    AND pedidos_id='$idPedido'";


}else{
    $sql = "INSERT INTO carrito
    (productos_id, pedidos_id, cantidad, costototal)
    VALUES
    ('$idProducto','$idPedido','$cantidad','$total')";

}

if($conn->query($sql)){

    header("Location: leercarrito.php?pedidos_id=".$idPedido);

}else{

    echo "Error: ".$conn->error;
}

?>