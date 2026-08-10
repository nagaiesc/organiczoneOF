<?php

$conexion = new mysqli("localhost","root", "","organiczoneBD");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$id = intval($_POST['id']);

if (
    !isset($_FILES["imagen"]) ||
    $_FILES["imagen"]["error"] !== UPLOAD_ERR_OK
) {
    die("No se seleccionó ninguna imagen.");
}

$extension = strtolower(
    pathinfo(
        $_FILES["imagen"]["name"],
        PATHINFO_EXTENSION
    )
);

$permitidas = ["jpg","jpeg","png","gif","webp"];

if (!in_array($extension, $permitidas)) {
    die("Formato de imagen no permitido.");
}
$carpeta = "../Imagenes/";

foreach ($permitidas as $ext) {
    $archivoAnterior = $carpeta . "P-" . $id . "." . $ext;
    if (file_exists($archivoAnterior)) {
        unlink($archivoAnterior);
    }

}
$destino = $carpeta . "P-" . $id . "." . $extension;
if (
    move_uploaded_file(
        $_FILES["imagen"]["tmp_name"],
        $destino
    )
) {
    header("Location: leerproducto.php?id=" . $id);
    exit();
} else {
    die("No se pudo guardar la imagen.");
}

?>