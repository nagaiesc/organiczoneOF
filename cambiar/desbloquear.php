<?php
session_start();
require_once "../seguridad.php";
verificarAdmin();

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}

$CI = intval($_GET['CI'] ?? 0);

$stmt = $conexion->prepare("UPDATE usuarios SET estado='activo' WHERE CI=?");
$stmt->bind_param("i",$CI);

if($stmt->execute()){
    header("Location: ../Usuarios/leerusuarios.php");
    exit();
} 

if ($conexion->query($sql) === TRUE) {
    echo "Usuario editado correctamente";
    header("location: ../Usuarios/leerusuarios.php");
}
?>