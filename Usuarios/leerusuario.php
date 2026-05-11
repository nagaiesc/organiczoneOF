<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "productosOZ";

$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$CI = $_GET['CI'];
$sql = "SELECT * FROM clientes WHERE id = $CI";

$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo $fila['CI']. " " .$fila['nombre']. " " . $fila['direccion']. " " . $fila['celular']. " " . $fila['rol']. " " . $fila['estado'];
        $CI=$fila['CI'];
    }    
}
?>