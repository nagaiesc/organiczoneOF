<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";

 $conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }

  $nombre = $_POST['nombre'];
  $fecha = $_POST['fecha'];
  $estado = $_POST['estado'];
  $nombrevendedor = $_POST['nombrevendedor'];

 
  
  $sql = "INSERT INTO pedidos( nombre , fecha , estado, nombrevendedor)
  VALUES ('$nombre' , '$fecha' , '$estado' , '$nombrevendedor') ";

  if($conn->query($sql) === TRUE) {

    $idPedido = $conn->insert_id;

    header("Location: leerpedidos.php?");
    exit();
    
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>
