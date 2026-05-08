<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "productosOZ";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE id = $id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $sql = "DELETE FROM clientes WHERE id = $id";
        if ($conexion->query($sql) === TRUE) {
            echo "Cliente eliminado correctamente";
        }
    }    
}

?>