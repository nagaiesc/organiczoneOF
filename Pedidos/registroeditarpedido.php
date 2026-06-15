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
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$nombrevendedor = $_POST['nombrevendedor'];
$sql = "UPDATE pedidos SET nombre='$nombre', fecha='$fecha' , estado='$estado' , nombrevendedor='$nombrevendedor' ;
if ($conexion->query($sql) === TRUE) {
    echo "Pedido editado correctamente";
    header("location: leerpedidos.php");
}
?>