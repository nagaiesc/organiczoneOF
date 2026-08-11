<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$CI = $_GET['CI'];

$sql = "UPDATE usuarios SET estado='usuario' WHERE CI=$CI";
if ($conexion->query($sql) === TRUE) {
    echo "Usuario editado correctamente";
    header("location: ../Usuarios/leerusuarios.php");
}
?>