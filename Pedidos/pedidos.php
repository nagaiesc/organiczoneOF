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
  $nombre = $_POST['nombre'];
  $fecha = $_POST['fecha'];
  $estado = $_POST['estado'];
  $nombrevendedor = $_POST['nombrevendedor'];

 
  
  $sql = "INSERT INTO pedidos( id, nombre , fecha , estado, nombrevendedor)
  VALUES ('$id' , '$nombre' , '$fecha' , '$estado' , '$nombrevendedor') ";
  if($conn->query($sql) === TRUE) {
    echo "Nuevo pedido creado correctamente";
    header("Location: leerpedidos.php?");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>
