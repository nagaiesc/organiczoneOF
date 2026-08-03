<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id = $id";

$resultado = $conexion->query($sql);


if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $sql = "DELETE FROM productos WHERE id = $id";
        if ($conexion->query($sql) === TRUE) {
            /*Funcionalidad para redireccionar a la página y se detiene el script*/
            header("Location: leerproductos.php");
            exit();
        }
    }    
}

?>