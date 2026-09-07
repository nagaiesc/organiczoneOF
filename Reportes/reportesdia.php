<?php 
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

  if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
  }
  $id= $_SESSION["id"];
 //Paso 1 Consulta SQL
  $sql= "SELECT count(*) AS pedidos FROM pedidos GROUP BY fecha";
  
  $resultado = $conn->query($sql);
  //Paso 2 Mover Datos al array
  while ($fila = $resultado->fetch_assoc()){
    $fecha[] = $fila["fecha"];
    $ventas[] = $fila["ventas"];
  }
  $resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>