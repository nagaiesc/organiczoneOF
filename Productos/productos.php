<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$BDnombre = "organiczoneBD";

$conexion = new mysqli($servidor,$usuario,$password,$BDnombre);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = intval($_POST['precio'] ?? 0);
$costo = intval($_POST['costo'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);

if($nombre === '' || $descripcion === ''){
    die("Completa todos los campos.");
}

$stmt = $conexion->prepare("INSERT INTO productos(nombre,descripcion,precio,costo,stock) VALUES(?,?,?,?,?)");

$stmt->bind_param("ssiii",$nombre,$descripcion,$precio,$costo,$stock);

if(!$stmt->execute()){
    die("Error al guardar el producto.");
}

$id = $conexion->insert_id;

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