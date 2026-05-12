<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";
$conn = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conn->connect_error) {
    echo "Hubo un error en la conexion";
}
$CI = $_GET['CI'];
$sql = "SELECT * FROM usuarios WHERE CI = $CI";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $nombre= $fila['nombre'];
        $direccion = $fila['direccion'];
        $celular= $fila['celular'];
        $rol = $fila['rol'];
        $estado = $fila['estado'];
    }    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="registroeditarusuario.php" method="post">
       
        <table>
        <tr>
        <th><label for="CI">CI del usuario:</label></th>
        </tr>
        <tr>
        <td><input type="number" name ="CI"required></td>
        </tr>
        <tr>
        <th><label for="nombre">Nombre del usuario:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="nombre"required></td>
        </tr>
        <tr>
        <th><label for="direccion">Dirección del usuario:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="direccion"required></td>
        </tr>
        <tr>
        <th><label for="celular">Celular del usuario:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="celular"required></td>
        </tr>
        <tr>
        <th><label for="rol">Rol del Usuario:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="rol"required></td>
        </tr>
        <tr>
        <th><label for="estado">Estado:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="estado"required></td>
        </tr>
        </table>
        <input type="submit" value="Editar">       
    </form>
</div></center>
</body>

</body>
</html>