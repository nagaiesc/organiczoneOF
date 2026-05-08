<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #969696;
    font-family: 'Inter', Arial, sans-serif;
    box-sizing: border-box;
}
body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}
.principal-grid {
    display: grid;
    grid-template-columns: 440px 1fr;
    grid-template-rows: 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;
    box-shadow: 0px 6px 40px rgba(88, 88, 88, 0.16);
    border-radius: 10px;
    overflow: hidden;
    margin-top: 32px;
    background: none;
}
@media (max-width: 1100px) {
    .principal-grid {
        grid-template-columns: 330px 1fr;
    }
}
@media (max-width: 700px) {
    .principal-grid {
        grid-template-columns: 1fr;
        grid-template-rows: auto auto;
        width: 99vw;
        min-height: 0;
    }
    .section-negro, .section-blanco {width: 100%;}
}
.section-negro {
    background: #000;
    color: #fff;
    padding: 0 44px 0 42px;
    border-right: 2px solid #ececec;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.nav-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 58px;
    border-bottom: 0.7px solid #222;
    margin-bottom: 38px;
    margin-top: 0;
    padding-top: 18px;
}
.nav-inner a {
    color: #e0e0e0;
    text-decoration: none;
    font-size: 1.13em;
    font-weight: 600;
    letter-spacing: 1.6px;
    transition: color 0.16s;
}
.nav-inner a:hover {
    color: #ffffff;
    text-decoration: underline;
}
.contrato-titulo {
    font-size: 2.6em;
    font-weight: 900;
    margin-bottom: 32px;
    margin-top: 46px;
    letter-spacing: -2px;
    line-height: 1.1;
}
.desc {
    font-size: 1.11em;
    font-weight: 400;
    margin-bottom: 0;
    color: #bababa;
    line-height: 1.4;
    margin-top: 18px;
}
.section-blanco {
    background: #fff;
    padding: 44px 32px 38px 32px;
    min-width: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.section-clientes {
    margin-bottom: 28px;
    border-bottom: 1.4px solid #ededed;
    padding-bottom: 18px;
}
.section-blanco h2 {
    font-size: 2.0em;
    font-weight: 700;
    margin: 18px 0 18px 0;
    color: #000;
    letter-spacing: -1px;
}
.table-responsive {
    width: 100%;
    overflow-x: auto;
}
.section-blanco table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    min-width: 980px;
    font-size: 1.08em;
    margin-top: 12px;
    background: #fff;
}
.section-blanco th, .section-blanco td {
    padding: 14px 9px;
    text-align: left;
    word-break: break-word;
    overflow-wrap: anywhere;
    font-size: 1em;
}
.section-blanco thead th {
    border-bottom: 3px solid #000;
    color: #181818;
    font-weight: 900;
    background: #fcfcfc;
    font-size: 1em;
    letter-spacing: 0.8px;
    white-space: nowrap;
}
.section-blanco tbody td {
    border-bottom: 1.2px solid #ededed;
    color: #232323;
    font-size: 1em;
}
.section-blanco tr:last-child td {
    border-bottom: 0;
}
.acciones {
    white-space: nowrap;
}
.acciones button {
    background: #000;
    color: #fff;
    border-radius: 4px;
    padding: 6px 14px;
    margin-right: 5px;
    font-weight: 600;
    font-size: 0.98em;
    border: none;
    transition: background 0.13s;
    letter-spacing: 1.1px;
}
.acciones button:hover {
    background: #222;
}
.acciones a { text-decoration: none;}
</style>
</head>
<body>
    <section class="principal-grid">
        <section class="section-negro">
            <nav class="nav-inner">
                <a href="http://localhost/OrganicZone/maquetadoOZ.html">INICIO</a>
            </nav>
            <header>
                <h1 class="contrato-titulo">LISTA DE CLIENTES</h1>
            </header>
            <p class="desc">
               Se puede ver a los clientes registrados en nuestra página web<br>
                Administra clientes, consulta y modifica datos rápidamente.
            </p>
        </section>
        <section class="section-blanco">
            <section class="section-clientes">
                <h2>Clientes Registrados</h2>
                <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Nombre de usuario</th>
                            <th>Correo</th>
                            <th>Contraseña</th>
                            <th>Fecha de nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nombreServidor = "localhost";
                        $nombreUsuario = "root";
                        $contraseñaBaseDeDatos = "";
                        $nombreBaseDeDatos = "productosOZ";
                        $conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);
                        if ($conexion->connect_error) {
                            echo "<tr><td colspan='8'>Hubo un error en la conexión</td></tr>";
                        }
                        $sql ="SELECT * FROM clientes";
                        $resultado = $conexion->query($sql);
                        if ($resultado->num_rows > 0) {
                            while($fila = $resultado->fetch_assoc()){
                                $id = $fila['id'];
                                echo "<tr>";
                                echo "<td>" . $fila['id'] . "</td>";
                                echo "<td>" . $fila['nombre'] . "</td>";
                                echo "<td>" . $fila['apellido'] . "</td>";
                                echo "<td>" . $fila['nombreusuario'] . "</td>";
                                echo "<td>" . $fila['correo'] . "</td>";
                                echo "<td>" . $fila['fechanacimiento'] . "</td>";
                                echo "<td class='acciones'>";
                                echo "<a href='editarcliente.php?id=$id'><button>Editar</button></a>";
                                echo "<a href='eliminarcliente.php?id=$id'><button>Eliminar</button></a>";
                                echo "<a href='leercliente.php?id=$id'><button>Mostrar</button></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Sin clientes para mostrar.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>
            </section>
        </section>
    </section>
</body>
</html>
