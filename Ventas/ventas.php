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

 //Aqui debemos buscar los productos del pedido paar ver si se puede validar la venta
 $sqlCarrito = "SELECT productos_id, cantidad FROM carrito WHERE pedidos_id = '$pedidos_id'";
 $resultadoCarrito = $conn->query($sqlCarrito);

 //Luego Validamos el stock antes de registrar la venta
 $hayStock = true; 
 $productoSinStock = "";

 while ($producto = $resultadoCarrito->fetch_assoc()) { 
  $productos_id = $producto['productos_id']; 
  $cantidad = $producto['cantidad'];

  //Buscamos el stock actual
  $sqlProducto = "SELECT nombre, stock FROM productos WHERE id = '$productos_id'";
   
   $resultadoProducto = $conn->query($sqlProducto); 
   $datosProducto = $resultadoProducto->fetch_assoc(); 
   $stock = $datosProducto['stock']; 
   $nombreProducto = $datosProducto['nombre'];

   //Comprobamos si hay stock suficiente
   if ($stock < $cantidad) { 
         $hayStock = false; 
         $productoSinStock = $nombreProducto; 
         break; 
    } 
  }

  //Si hay stock registramos la venta

  if ($hayStock == true) {

  $sql = "INSERT INTO ventas (estado, metodo, costototal, pedidos_id)
  VALUES ('$estado', '$metodo', '$costototal', '$pedidos_id')";
  
  if($conn->query($sql) === TRUE) {

    //Aqui actualizamos el stock de los productos una ves que la venta este registrada
    $sqlCarrito = "SELECT productos_id, cantidad FROM carrito WHERE pedidos_id = '$pedidos_id'";

    $resultadoCarrito = $conn->query($sqlCarrito);
    while ($producto = $resultadoCarrito->fetch_assoc()) { 
      $productos_id = $producto['productos_id'];
      $cantidad = $producto['cantidad'];

    //Descontamos la cantidad de stock

    $sqlStock = "UPDATE productos SET stock = stock - '$cantidad' WHERE id = '$productos_id'";
    $conn->query($sqlStock); 
    }
    header("Location: leerventas.php?");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  } else { 
    // NO HAY SUFICIENTE STOCK 
    echo "No hay suficiente stock del producto: " . $productoSinStock; 
    } 
    $conn->close(); 
    ?>