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

$CI = intval($_POST['CI'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$celular = trim($_POST['celular'] ?? '');
$rol = trim($_POST['rol'] ?? '');
$estado = trim($_POST['estado'] ?? '');

if(!in_array($rol,['admin','vendedor','cliente'])){
    die("Rol no válido.");
}

if(!in_array($estado,['activo','inactivo'])){
    die("Estado no válido.");
}

$stmt = $conexion->prepare("UPDATE usuarios SET nombre=?,direccion=?,celular=?,rol=?,estado=? WHERE CI=?");

$stmt->bind_param("sssssi",$nombre,$direccion,$celular,$rol,$estado,$CI);

if($stmt->execute()){
    header("Location: leerusuarios.php");
    exit();
}

die("No se pudo actualizar el usuario.");