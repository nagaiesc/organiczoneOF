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
$estado = $_POST['estado'];
$metodo = $_POST['metodo'];

$sql = "UPDATE ventas SET estado='$estado' , metodo='$metodo' WHERE id='$id' ";
if ($conexion->query($sql) === TRUE) {
    header("location: leerventas.php");
}
?>