<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];
$sql = "UPDATE usuarios SET nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol',estado='$estado' WHERE CI=$CI";
if ($conexion->query($sql) === TRUE) {
    echo "Usuario editado correctamente";
    header("location: leerusuarios.php");
}
?>