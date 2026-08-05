<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";
 $conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);
  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }
  $id = $_POST['id'];
  $estado = $_POST['estado'];
  $metodo = $_POST['metodo'];
  $costototal = $_POST['costototal'];
  $pedidos_id = $_POST['pedidosid'];
  
  $sql = "INSERT INTO ventas (id, estado, metodo, costototal, pedidos_id)
  VALUES ('$id', '$estado', '$metodo', '$costototal', '$pedidos_id')";
  if($conn->query($sql) === TRUE) {
    echo "Nuevo venta creado correctamente";
    header("Location: leerventas.php?");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>