<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$BDnombre = "organiczoneBD";

$conexion = new mysqli($servidor,$usuario,$password,$BDnombre);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, costo, stock)
VALUES ('$nombre', '$descripcion', '$precio', '$costo', '$stock')";

if (!$conexion->query($sql)) {

    die("Error al guardar el producto: " . $conexion->error);

}

$id = $conexion->insert_id;
if (
    isset($_FILES["imagen"]) &&
    $_FILES["imagen"]["error"] === UPLOAD_ERR_OK
) {
    $nombreOriginal = $_FILES["imagen"]["name"];
    $temporal = $_FILES["imagen"]["tmp_name"];

    $extension = strtolower(
        pathinfo($nombreOriginal, PATHINFO_EXTENSION)
    );
    $permitidas = ["jpg","jpeg","png","gif","webp"];
    if (in_array($extension, $permitidas)) {
        $carpeta = "../Imagenes/";
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $nombreImagen = "P-" . $id . "." . $extension;
        $destino = $carpeta . $nombreImagen;
        if (!move_uploaded_file($temporal, $destino)) {
            echo "El producto se guardó, pero la imagen no pudo guardarse.";

        }

    } else {
        echo "Formato de imagen no permitido.";
    }
}

header("Location: leerproductos.php");
exit();

?>