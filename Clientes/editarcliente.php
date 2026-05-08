<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "productosOZ";
$conn = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
if ($conn->connect_error) {
    echo "Hubo un error en la conexion";
}
$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE id = $id";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $nombre= $fila['nombre'];
        $apellido = $fila['apellido'];
        $nombreusuario= $fila['nombreusuario'];
        $correo = $fila['correo'];
        $contrasena = $fila['contrasena'];
        $fechanacimiento = $fila['fechanacimiento'];
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

    <form action="registroeditarcliente.php" method="post">
       
        <table>
        <tr>
        <td><input type="number" name ="id"required></td>
        </tr>
        <tr>
        <th><label for="nombre">Nombre del cliente:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="nombre"required></td>
        </tr>
        <tr>
        <th><label for="apellido">Apellido del cliente:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="apellido"required></td>
        </tr>
        <tr>
        <th><label for="nombreusuario">Nombre de usuario:</label></th>
        </tr>
        <tr>
        <td><input type="text" name ="nombreusuario"required></td>
        </tr>
        <tr>
        <th><label for="correo">Correo-gmail:</label></th>
        </tr>
        <tr>
        <td><input type="email" name ="correo"required></td>
        </tr>
        <tr>
        <th><label for="contrasena">Contraseña:</label></th>
        </tr>
        <tr>
        <td><input type="password" name ="contrasena"required></td>
        </tr>
         <tr>
        <th><label for="fechanacimiento">Fecha de nacimiento:</label></th>
        </tr>
        <tr>
        <td><input type="date" name ="fechanacimiento"required></td>
        </tr>
        </table>
        <input type="submit" value="Editar">       
    </form>
</div></center>
</body>

</body>
</html>