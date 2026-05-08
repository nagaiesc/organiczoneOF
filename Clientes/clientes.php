<?php
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "productosOZ";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

if ($conn->connect_error) {
    die("conexion fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$nombreusuario = $_POST['nombreusuario'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$fechanacimiento = $_POST['fechanacimiento'];

$sql = "INSERT INTO clientes (nombre, apellido, nombreusuario, correo, contrasena, fechanacimiento) 
        VALUES ('$nombre', '$apellido', '$nombreusuario', '$correo', '$contrasena', '$fechanacimiento')";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
if ($conn->query($sql) === TRUE) {
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
            text: '". $conn->error ."',
            icon: 'error'
        });
    </script>
    ";
}

$conn->close();
?>

</body>
</html>