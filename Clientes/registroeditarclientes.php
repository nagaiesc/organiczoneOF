<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "productosOZ";
$conn = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conn->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido= $_POST['apellido'];
$nombreusuario = $_POST['nombreusuario'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$fechanacimiento = $_POST['fechanacimiento'];
$sql = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', nombreusuario='$nombreusuario', correo='$correo', contrasena='$contrasena', fechanacimiento='$fechanacimiento' WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Cliente editado correctamente";
}
?>