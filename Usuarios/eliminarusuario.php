<?php
session_start();
require_once "../seguridad.php";
verificarAdmin();

$conexion = new mysqli("localhost","root","","organiczoneBD");

if($conexion->connect_error){
    die("Hubo un error en la conexion");
}

if(!isset($_GET['CI']) || !is_numeric($_GET['CI'])){
    die("CI no válido");
}

$CI = intval($_GET['CI']);

$stmt = $conexion->prepare("DELETE FROM usuarios WHERE CI = ?");
$stmt->bind_param("i",$CI);

if($stmt->execute()){
    header("Location: leerusuarios.php");
    exit();
}

die("No se pudo eliminar el usuario.");

?>