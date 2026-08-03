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
  
  if($conexion->query($sql)){

    $id=$conexion->insert_id;

    if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"]==0){

        $extension=strtolower(pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION));

        $permitidas=["jpg","jpeg","png","gif","webp"];

        if(in_array($extension,$permitidas)){

            $destino="../Imagenes/P-".$id.".".$extension;

            move_uploaded_file($_FILES["imagen"]["tmp_name"],$destino);

        }

    }

    header("Location: leerproductos.php");

}else{

    echo $conexion->error;

}
?>