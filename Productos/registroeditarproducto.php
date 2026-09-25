<?php 
session_start();
require_once "../seguridad.php";
verificarAdminVendedor();

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli(
    $nombreServidor,
    $nombreUsuario,
    $contraseñaBaseDeDatos,
    $nombreBaseDeDatos
);

if($conexion->connect_error){
    die("Hubo un error en la conexion");
}

$id = intval($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = intval($_POST['precio'] ?? 0);
$costo = intval($_POST['costo'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);

if($id <= 0 || $nombre === '' || $descripcion === ''){
    die("Datos no válidos.");
}

$stmt = $conexion->prepare(
    "UPDATE productos SET nombre=?,descripcion=?,precio=?,costo=?,stock=? WHERE id=?"
);

$stmt->bind_param(
    "ssiiii",
    $nombre,
    $descripcion,
    $precio,
    $costo,
    $stock,
    $id
);

if(!$stmt->execute()){
    die("Error al actualizar el producto.");
}

if(
    isset($_FILES["imagen"]) &&
    $_FILES["imagen"]["error"] === UPLOAD_ERR_OK
){

    $nombreOriginal = $_FILES["imagen"]["name"];
    $temporal = $_FILES["imagen"]["tmp_name"];
    $tamaño = $_FILES["imagen"]["size"];

    if($tamaño > 2 * 1024 * 1024){
        die("La imagen no puede pesar más de 2 MB.");
    }

    $extension = strtolower(
        pathinfo($nombreOriginal,PATHINFO_EXTENSION)
    );

    $extensiones = [
        "jpg",
        "jpeg",
        "png",
        "gif",
        "webp"
    ];

    $tiposPermitidos = [
        "image/jpeg",
        "image/png",
        "image/gif",
        "image/webp"
    ];

    $tipo = mime_content_type($temporal);

    if(!in_array($tipo,$tiposPermitidos)){
        die("El archivo no es una imagen válida.");
    }

    if(getimagesize($temporal) === false){
        die("El archivo no es una imagen.");
    }

    if(!in_array($extension,$extensiones)){
        die("Formato de imagen no permitido.");
    }

    $carpeta = "../Imagenes/";

    if(!is_dir($carpeta)){
        mkdir($carpeta,0755,true);
    }

    foreach($extensiones as $ext){
        $vieja = $carpeta . "P-" . $id . "." . $ext;

        if(file_exists($vieja)){
            unlink($vieja);
        }
    }

    $destino = $carpeta . "P-" . $id . "." . $extension;

    if(!move_uploaded_file($temporal,$destino)){
        die("El producto se actualizó, pero la imagen no pudo guardarse.");
    }
}

$stmt->close();
$conexion->close();

header("Location: leerproductos.php");
exit();

?>