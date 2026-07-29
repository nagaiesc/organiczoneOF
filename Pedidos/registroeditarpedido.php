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
$direccion = $_POST['direccion'];
$telefono= $_POST['telefono'];
$nombrevendedor = $_POST['nombrevendedor'];
$sql = "UPDATE pedidos SET nombre='$nombre', fecha='$fecha' , estado='$estado' , nombrevendedor='$nombrevendedor' , direccion='$direccion' , telefono='$telefono' WHERE id='$id' ";
if ($conexion->query($sql) === TRUE) {
    header("location: leerpedidos.php");
}
?>