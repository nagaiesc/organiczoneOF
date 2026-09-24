<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$CI = intval($_GET['CI'] ?? 0);

$stmt = $conexion->prepare("UPDATE usuarios SET rol='vendedor' WHERE CI=?");
$stmt->bind_param("i",$CI);

if($stmt->execute()){
    header("Location: ../Usuarios/leerusuarios.php");
    exit();
}
?>