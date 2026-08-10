<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "organiczoneBD"
);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

/* Comprobar ID */

if (!isset($_GET['id'])) {
    die("No se recibió el ID del producto.");
}

$id = intval($_GET['id']);

if ($id <= 0) {
    die("ID de producto no válido.");
}


/* ==========================================
   1. ELIMINAR EL PRODUCTO DEL CARRITO
   ========================================== */

$sqlCarrito = "DELETE FROM carrito WHERE productos_id = $id";

if (!$conexion->query($sqlCarrito)) {
    die("Error al eliminar el producto del carrito: " . $conexion->error);
}


/* ==========================================
   2. ELIMINAR LA IMAGEN
   ========================================== */

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


/* ==========================================
   3. ELIMINAR EL PRODUCTO
   ========================================== */

$sqlProducto = "DELETE FROM productos WHERE id = $id";

if (!$conexion->query($sqlProducto)) {

    die("Error al eliminar el producto: " . $conexion->error);

}


/* ==========================================
   4. VOLVER A LA LISTA
   ========================================== */

header("Location: leerproductos.php");
exit();

?>