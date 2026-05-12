<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];
$sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion' , precio='$precio' , costo='$costo' , stock='$stock' ";
if ($conexion->query($sql) === TRUE) {
    echo "Producto editado correctamente";
    header("location: leerproductos.php");
}
?>