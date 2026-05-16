<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conexion->connect_error) {
    echo "Hubo un error en la conexion";
}
$CI = $_GET['CI'];
$sql = "SELECT * FROM usuarios WHERE CI = $CI";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $sql = "DELETE FROM usuarios WHERE CI = $CI";
        if ($conexion->query($sql) === TRUE) {
            header("Location: leerusuarios.php");
            exit();
        }
    }    
}

?>