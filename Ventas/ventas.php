<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";
 $conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);
  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }
  $metodo = $_POST['metodo'];
  $pedidos_id = $_POST['pedidos_id'];
  
  $estado= "Pendiente";

 $sqlTotal = "SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id = '$pedidos_id'";
 $resultado = $conn->query($sqlTotal);
 $fila = $resultado->fetch_assoc();
 $costototal = $fila['total'];

  $sql = "INSERT INTO ventas (estado, metodo, costototal, pedidos_id)
  VALUES ('$estado', '$metodo', '$costototal', '$pedidos_id')";
  
  if($conn->query($sql) === TRUE) {
    echo "Nuevo venta creado correctamente";
    header("Location: leerventas.php?");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>