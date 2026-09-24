<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

if ($conexion->connect_error) {
    die("Hubo un error en la conexion");
}

$id = intval($_GET['id'] ?? 0);

$stmt = $conexion->prepare("DELETE FROM carrito WHERE pedidos_id=?");
$stmt->bind_param("i",$id);

if($stmt->execute()){

    $stmt = $conexion->prepare("DELETE FROM pedidos WHERE id=?");
    $stmt->bind_param("i",$id);

    if($stmt->execute()){
        header("Location: leerpedidos.php");
        exit();
    }
}

die("No se pudo eliminar el pedido.");
$conexion->close();
?>