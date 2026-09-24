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

$stmt = $conn->prepare("SELECT * FROM carrito WHERE productos_id=? AND pedidos_id=?");
$stmt->bind_param("ii",$idProducto,$idPedido);
$stmt->execute();

$resultado = $stmt->get_result();

$resultado = $conn->query($buscar);
if($resultado->num_rows > 0){
    $stmt = $conn->prepare("UPDATE carrito SET cantidad=?,costototal=? WHERE productos_id=? AND pedidos_id=?");
$stmt->bind_param("iiii",$cantidad,$total,$idProducto,$idPedido);

}else{
    $stmt = $conn->prepare("INSERT INTO carrito(productos_id,pedidos_id,cantidad,costototal) VALUES(?,?,?,?)");
$stmt->bind_param("iiii",$idProducto,$idPedido,$cantidad,$total);
}

if($stmt->execute()){
    header("Location: leercarrito.php?pedidos_id=".$idPedido);
    exit();
    
}else{

    echo "Error: ".$conn->error;
}

?>