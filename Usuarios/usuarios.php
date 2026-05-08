<?php 
$servidor="host local";
$nombre="usuarios";
$contraseña="";
$nombreBD="productosOZ";

$conexión = new mysqli($servidor, $nombre, $contraseña, $nombreBD);
if ($conexión->connect_error) {
    die("conexion fallida: " . $conexión->connect_error);
}

$CI=$_POST['CI'];
$nombre=$_POST['apellido'];
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
    if($conexión->query($SQL) ==TRUE){
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
            text: '". $conexión->error ."',
            icon: 'error'
        });
    </script>
    ";
     }

     $conexión->close();

?>
</body>
</html>