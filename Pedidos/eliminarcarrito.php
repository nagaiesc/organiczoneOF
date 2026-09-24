<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$pedidos_id = intval($_GET['pedidos_id'] ?? 0);
$productos_id = intval($_GET['productos_id'] ?? 0);

$stmt = $conexion->prepare("DELETE FROM carrito WHERE pedidos_id=? AND productos_id=?");
$stmt->bind_param("ii",$pedidos_id,$productos_id);

if($stmt->execute()){
    header("Location: leercarrito.php?pedidos_id=".$pedidos_id);
    exit();
}

?>