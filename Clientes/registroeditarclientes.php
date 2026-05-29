<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conn = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conn->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido= $_POST['apellido'];
$nombreusuario = $_POST['nombreusuario'];
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];
$fechanacimiento = $_POST['fechanacimiento'];
$sql = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', nombreusuario='$nombreusuario', correo='$correo', contraseña='$contraseña', fechanacimiento='$fechanacimiento' WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Cliente editado correctamente";
}
?>