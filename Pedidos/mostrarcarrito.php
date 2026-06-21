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


?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrito Pedido</title>
<style>
body{
    background:#EAF7EC;
    margin:0;
    font-family:'Inter',Arial,Helvetica,sans-serif;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.caja{
    background:white
    width:90%;
    max-width:1100px;
    padding:45px;
    border-radius:60px;
    box-shadow:0 10px 35px rgba(43,20,13,.25);
}

.marca{
    text-align:center;
    font-weight:800;
    letter-spacing:2px;
    color:#12A33C;
}

.titulo{
    text-align:center;
    font-size:45px;
    font-weight:900;
    color:#2B140D;
    margin-bottom:35px;
}

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
}

th{
    background:#2B140D;
    color:white;
    padding:15px;
}

td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

a{
    text-decoration:none;
    color:white;
    background:#12A33C;
    padding:9px 18px;
    border-radius:20px;
    font-weight:700;
}

a:hover{
    background:#2B140D;
}

.volver{
    display:block;
    width:150px;
    margin:30px auto 0;
    text-align:center;
    background:#2B140D;
}

.volver:hover{
    background:#12A33C;
}

</style>
</head>
<body>
    <div class="caja">

    <div class="marca">
    ORGANIC ZONE
    </div>
    <div class="titulo">
    Carrito del Pedido Nº <?= $idPedido ?>
    </div>

    <table>

    <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Costo Total</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
<?php

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