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
  $descripcion = $_POST['descripcion'];
  $precio = $_POST['precio'];
  $costo = $_POST['costo'];
  $stock = $_POST['stock'];
  $cantidad= $_POST ['cantidad'];
  $costototal = $_POST ['costototal'];

  $costototal=$precio*$cantidad;
  
  $sql = "INSERT INTO productos ( nombre , descripcion , precio , costo , stock)
  VALUES ('$nombre' , '$descripcion' , '$precio' , '$costo' , '$stock') ";
  if($conn->query($sql) === TRUE) {
    echo "Nuevo producto creado correctamente";
    header("Location: leerproductos.php?");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>
