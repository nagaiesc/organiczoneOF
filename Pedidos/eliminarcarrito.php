<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$pedidos_id = $_GET['pedidos_id'];
$productos_id = $_GET['productos_id'];

$sql = "SELECT * FROM carrito WHERE pedidos_id = $pedidos_id AND productos_id=$productos_id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $sql = "DELETE FROM carrito WHERE pedidos_id = $pedidos_id AND productos_id=$productos_id";
        if ($conexion->query($sql) === TRUE) {
            /*Funcionalidad para redireccionar a la página y se detiene el script*/ 
            header("Location: leercarrito.php?pedidos_id=".$pedidos_id);
            exit();
        }
    }    
}

?>