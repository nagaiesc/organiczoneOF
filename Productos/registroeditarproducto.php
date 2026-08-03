<?php 

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

$sql = "UPDATE productos SET nombre='$nombre',descripcion='$descripcion',precio='$precio',costo='$costo',stock='$stock' WHERE id='$id'";

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