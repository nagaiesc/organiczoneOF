<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = intval($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$fecha = trim($_POST['fecha'] ?? '');
$estado = trim($_POST['estado'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$nombrevendedor = trim($_POST['nombrevendedor'] ?? '');

$stmt = $conexion->prepare("UPDATE pedidos SET nombre=?,fecha=?,estado=?,nombrevendedor=?,direccion=?,telefono=? WHERE id=?");

$stmt->bind_param("ssssssi",$nombre,$fecha,$estado,$nombrevendedor,$direccion,$telefono,$id);

if($stmt->execute()){
    header("Location: leerpedidos.php");
    exit();
}
?>