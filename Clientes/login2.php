<?php
 $nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "productosOZ";
$conn = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conn->connect_error) {
    echo "Hubo un error en la conexion";
}
 
 $usuario=$_POST['usuario'];
 $contrasena=$_POST['contrasena'];
 $sql="SELECT *FROM clientes WHERE nombreusuario='$usuario' AND contrasena='$contrasena'";
echo $sql;
$resultado = $conn->query($sql);
echo "holi";
if ($resultado->num_rows > 0) {
    header("location: ../Productos/leerproductos.php");
}
?>