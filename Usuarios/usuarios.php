<?php 
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "productosOZ";

$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    die("conexion fallida: " . $conexion->connect_error);
}

$CI=$_POST['CI'];
$nombre=$_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$SQL="INSERT INTO usuarios (CI, nombre, direccion, celular, rol, estado)
        VALUES ('$CI', '$nombre', '$direccion', '$celular', '$rol', '$estado')";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
    if($conexion->query($SQL) ==TRUE){
       echo "
       <script>
        Swal.fire({
            title: 'Registro exitoso',
            text: 'El cliente ha sido registrado correctamente',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = '/OrganicZone/maquetadoOZ.html';
        });
        </script>
        ";
    } else {
    echo "
    <script>
        Swal.fire({
            title: 'Error',
            text: '". $conexion->error ."',
            icon: 'error'
        });
    </script>
    ";
     }

     $conexion->close();

?>
</body>
</html>