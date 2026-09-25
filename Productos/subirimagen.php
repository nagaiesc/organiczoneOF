<?php
session_start();
require_once "../seguridad.php";
verificarAdminVendedor();

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

$tamaño = $_FILES["imagen"]["size"];

if($tamaño > 2 * 1024 * 1024){
    die("La imagen no puede pesar más de 2 MB.");
}

$extension = strtolower(
    pathinfo(
        $_FILES["imagen"]["name"],
        PATHINFO_EXTENSION
    )
);

$permitidas = ["jpg","jpeg","png","gif","webp"];
//seguridad para solo permitir imagenes
$tipo = mime_content_type($_FILES["imagen"]["tmp_name"]);

$tiposPermitidos = ["image/jpeg","image/png","image/gif","image/webp"];

if(!in_array($tipo,$tiposPermitidos)){
    die("El archivo no es una imagen válida.");
}

if(getimagesize($_FILES["imagen"]["tmp_name"]) === false){
    die("El archivo no es una imagen.");
}


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