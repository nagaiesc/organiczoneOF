<?php
session_start();
require_once "../seguridad.php";
verificarAdminVendedor();

header('Content-Type: application/json; charset=utf-8');

function responder($ok, $mensaje, $ruta = null) {
    echo json_encode(["ok" => $ok, "mensaje" => $mensaje, "ruta" => $ruta]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, "Método no permitido.");
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    responder(false, "ID de producto inválido.");
}

if (!isset($_FILES['imagen'])) {
    responder(false, "No se recibió ninguna imagen. Revisa post_max_size en php.ini.");
}

$archivo = $_FILES['imagen'];

if ($archivo['error'] !== UPLOAD_ERR_OK) {
    $errores = [
        UPLOAD_ERR_INI_SIZE   => "La imagen supera el límite de PHP (upload_max_filesize).",
        UPLOAD_ERR_FORM_SIZE  => "La imagen es demasiado grande.",
        UPLOAD_ERR_PARTIAL    => "La imagen se subió de forma incompleta.",
        UPLOAD_ERR_NO_FILE    => "No seleccionaste ninguna imagen.",
        UPLOAD_ERR_NO_TMP_DIR => "Falta la carpeta temporal del servidor.",
        UPLOAD_ERR_CANT_WRITE => "No se pudo escribir el archivo en el disco."
    ];
    responder(false, $errores[$archivo['error']] ?? "Error al subir la imagen.");
}

if ($archivo['size'] > 2 * 1024 * 1024) {
    responder(false, "La imagen supera los 2 MB permitidos.");
}

// Validar que realmente sea una imagen (por contenido, no por nombre)
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->file($archivo['tmp_name']);

$permitidos = [
    "image/jpeg" => "jpg",
    "image/png"  => "png",
    "image/gif"  => "gif",
    "image/webp" => "webp"
];

if (!isset($permitidos[$mime]) || getimagesize($archivo['tmp_name']) === false) {
    responder(false, "Formato no permitido. Usa JPG, PNG, GIF o WEBP.");
}

$ext        = $permitidos[$mime];
$directorio = __DIR__ . "/../Imagenes/";

if (!is_dir($directorio) || !is_writable($directorio)) {
    responder(false, "La carpeta Imagenes no existe o no tiene permisos de escritura.");
}

$nombre = "P-" . $id;

// Borrar imágenes anteriores del producto (cualquier extensión)
foreach (["jpg", "jpeg", "png", "gif", "webp"] as $e) {
    $vieja = $directorio . $nombre . "." . $e;
    if (file_exists($vieja)) {
        @unlink($vieja);
    }
}

$destino = $directorio . $nombre . "." . $ext;

if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
    responder(false, "No se pudo guardar la imagen en el servidor.");
}

responder(true, "Imagen actualizada correctamente.", "../Imagenes/" . $nombre . "." . $ext);