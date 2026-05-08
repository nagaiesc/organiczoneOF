<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "productosOZ";
 $conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);
  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }
  $nombreproducto = $_POST['nombreproducto'];
  $precioventa = $_POST['precioventa'];
  $cantidad = $_POST['cantidad'];
  $costo = $_POST['costo'];
  $sql = "INSERT INTO productos ( nombreproducto, precioventa, cantidad, costo) VALUES ( '$nombreproducto', '$precioventa', '$cantidad', '$costo')";
  if($conn->query($sql) === TRUE) {
    echo "Nuevo producto creado correctamente";
    header("Location: leerproductos.php?");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>
