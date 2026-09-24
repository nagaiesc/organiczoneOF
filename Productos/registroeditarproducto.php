<?php 

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
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

$stmt = $conexion->prepare("UPDATE productos SET nombre=?,descripcion=?,precio=?,costo=?,stock=? WHERE id=?");

$stmt->bind_param("ssiiii",$nombre,$descripcion,$precio,$costo,$stock,$id);

if(!$stmt->execute()){
    die("Error al actualizar el producto.");
}

if($conexion->query($sql)){

    if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"]==0){
        $extensiones=["jpg","jpeg","png","gif","webp"];
        foreach($extensiones as $ext){
            $vieja="../Imagenes/P-".$id.".".$ext;
            if(file_exists($vieja)){
                unlink($vieja);
            }
        }
        $extension=strtolower(pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION));
        if(in_array($extension,$extensiones)){
            move_uploaded_file(
                $_FILES["imagen"]["tmp_name"],
                "../Imagenes/P-".$id.".".$extension
            );
        }
    }
    header("Location: leerproductos.php");

}
?>