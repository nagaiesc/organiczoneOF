<?php
session_start();

if (($_SESSION['rol'] ?? '') !== 'vendedor') {
    header('Location: ../Usuarios/formulariosesion.php');
    exit();
}

$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = (int) ($_GET['id'] ?? 0);
$nombreVendedor = $_SESSION['nombre'];

if ($id <= 0) {
    die("Pedido no válido.");
}

$stmt = $conexion->prepare(
    "UPDATE pedidos
     SET estado = 'En proceso',
         nombrevendedor = ?
     WHERE id = ?
     AND estado = 'Pendiente'"
);

$stmt->bind_param('si', $nombreVendedor, $id);
$stmt->execute();

$stmt->close();
$conexion->close();

header("Location: leerpedidos.php");
exit();
?>