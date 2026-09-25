<?php
session_start();
require_once "../seguridad.php";
verificarAdminVendedor();

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "organiczoneBD"
);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if (!isset($_GET['id'])) {
    die("No se recibió el ID del producto.");
}

$id = intval($_GET['id']);

if ($id <= 0) {
    die("ID de producto no válido.");
}

$stmt = $conexion->prepare("DELETE FROM carrito WHERE productos_id = ?");
$stmt->bind_param("i",$id);

if(!$stmt->execute()){
    die("Error al eliminar el producto del carrito: " . $conexion->error);
}

$carpeta = "../Imagenes/";

$extensiones = [
    "jpg",
    "jpeg",
    "png",
    "gif",
    "webp"
];

foreach ($extensiones as $extension) {

    $imagen = $carpeta . "P-" . $id . "." . $extension;

    if (file_exists($imagen)) {
        unlink($imagen);
    }

}

$stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i",$id);

if(!$stmt->execute()){

    die("Error al eliminar el producto: " . $conexion->error);

}

header("Location: leerproductos.php");
exit();

?>