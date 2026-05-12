<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "porganiczoneBD";
$conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
    if ($conexion->connect_error) {
    echo "<tr><td colspan='8'>Hubo un error en la conexión</td></tr>";
    }
    $sql ="SELECT * FROM usuarios";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()){
        $CI = $fila['CI'];
        echo "<tr>";
        echo "<td>" . $fila['CI'] . "</td>";
        echo "<td>" . $fila['nombre'] . "</td>";
        echo "<td>" . $fila['celular'] . "</td>";
        echo "<td>" . $fila['direccion'] . "</td>";
        echo "<td>" . $fila['rol'] . "</td>";
        echo "<td>" . $fila['estado'] . "</td>";
        echo "<td class='acciones'>";
        echo "<a href='editarusuario.php?CI=$CI'><button>Editar</button></a>";
        echo "<a href='eliminarusuario.php?CI=$CI'><button>Eliminar</button></a>";
        echo "<a href='leerusuario.php?CI=$CI'><button>Mostrar</button></a>";
        echo "</td>";
        echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Sin usuarios para mostrar.</td></tr>";
    }
    ?>