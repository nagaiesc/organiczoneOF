<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "organiczoneBD";
$conexion = new mysqli("localhost","root","","organiczoneBD");

$id = $_GET['id'];

$sql = "UPDATE pedidos SET estado='En proceso' WHERE id='$id'";
$conexion->query($sql);
header("Location: leerpedidos.php");

?>