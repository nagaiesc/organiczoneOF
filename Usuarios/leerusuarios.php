
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Usuarios</title>

<style>
/* === ESTILOS GENERALES === */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #969696;
    font-family: 'Inter', Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
}

.principal-grid {
    display: grid;
    grid-template-columns: 440px 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;
    box-shadow: 0px 6px 40px rgba(88, 88, 88, 0.16);
    border-radius: 10px;
    overflow: hidden;
}

/* PANEL IZQUIERDO */
.section-negro {
    background: #000;
    color: #fff;
    padding: 40px;
}

.nav-inner a {
    color: #e0e0e0;
    text-decoration: none;
    font-weight: 600;
}

.contrato-titulo {
    font-size: 2.6em;
    font-weight: 900;
    margin-top: 40px;
}

.desc {
    color: #bababa;
    margin-top: 20px;
    line-height: 1.6;
}

/* PANEL DERECHO */
.section-blanco {
    background: #fff;
    padding: 40px;
}

.section-clientes {
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}

/* TABLA */
table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    border-bottom: 3px solid #000;
    padding: 12px;
    text-align: left;
    font-weight: 900;
}

tbody td {
    border-bottom: 1px solid #ddd;
    padding: 12px;
}

tbody tr:hover {
    background: #f5f5f5;
}

/* BOTONES */
.acciones button {
    background: #000;
    color: #fff;
    border: none;
    padding: 6px 12px;
    margin-right: 5px;
    cursor: pointer;
    font-weight: 600;
    border-radius: 5px;
    transition: 0.3s ease;
}

.acciones button:hover {
    background: #222;
    transform: scale(1.05);
}

.acciones a {
    text-decoration: none;
}

#boton {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    gap: 8px;
    background-color: rgb(255, 255, 255);
    color: black;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
    width: fit-content;
    margin-top: 20px;
}

#boton:hover {
    background: #eaeaea;
}
</style>
</head>

<body>

<section class="principal-grid">

    <!-- PANEL IZQUIERDO -->
    <section class="section-negro">
        <nav class="nav-inner">
            <a href="../maquetadoOZ.html">INICIO</a>
        </nav>

        <h1 class="contrato-titulo">LISTA DE USUARIOS</h1>

        <a href="formulariousuarioS.php" id="boton">Registrar Usuario</a>

        <p class="desc">
            Visualiza todos los usuarios registrados en el sistema.<br>
            Administra información, estados y roles de manera rápida.
        </p>
    </section>

    <!-- PANEL DERECHO -->
    <section class="section-blanco">

        <section class="section-clientes">
            <h2>Usuarios Registrados</h2>

            <table>
                <thead>
                    <tr>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Direccion</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $nombreServidor = "localhost";
                $nombreUsuario = "root";
                $contraseñaBaseDeDatos = "";
                $nombreBaseDeDatos = "organiczoneBD";

                $conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

                if ($conexion->connect_error) {
                    echo "<tr><td colspan='7'>Hubo un error en la conexión</td></tr>";
                }

                $sql = "SELECT * FROM usuarios";
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
                    echo "<tr><td colspan='7'>Sin usuarios para mostrar.</td></tr>";
                }
                ?>
                </tbody>
            </table>

        </section>

    </section>

</section>

</body>
</html>
```
