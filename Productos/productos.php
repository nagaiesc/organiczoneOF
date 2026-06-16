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
  $descripcion = $_POST['descripcion'];
  $precio = $_POST['precio'];
  $costo = $_POST['costo'];
  $stock = $_POST['stock'];
  
  $sql = "INSERT INTO productos (id, nombre, descripcion, precio, costo, stock)
  VALUES ('$id', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";
  if($conn->query($sql) === TRUE) {
    echo "Nuevo producto creado correctamente";
    header("Location: leerproductos.php?");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>
