<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conn = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

if ($conn->connect_error) {
    die("Hubo un error en la conexion");
}

$id = $_GET['id'];

$sql = "SELECT * FROM clientes WHERE id = $id";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
    $nombreusuario = $fila['nombreusuario'];
    $correo = $fila['correo'];
    $contraseña = $fila['contraseña'];
    $fechanacimiento = $fila['fechanacimiento'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Cliente</title>

<style>

html, body {
    height: 100%;
    margin: 0;
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
    max-width: 1400px;
    min-height: 700px;
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
    font-size: 2.4em;
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
    padding: 50px;
}

.section-blanco h2 {
    margin-bottom: 30px;
}

/* FORMULARIO */
.forma label {
    font-weight: 500;
    font-size: 14px;
}

.forma input {
    width: 100%;
    border: none;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 8px 0;
    font-size: 16px;
    background: none;
    outline: none;
}

.forma input:focus {
    border-bottom: 1.5px solid #000;
}

.forma .fil {
    display: flex;
    gap: 20px;
}

.forma .fil div {
    width: 100%;
}

.forma button {
    width: 100%;
    background: #000;
    color: #fff;
    border: none;
    padding: 12px;
    font-weight: 600;
    cursor: pointer;
    border-radius: 8px;
    transition: 0.3s;
}

.forma button:hover {
    background: #222;
    transform: scale(1.01);
}

</style>
</head>

<body>

<section class="principal-grid">

    <!-- PANEL IZQUIERDO -->
    <section class="section-negro">

        <nav class="nav-inner">
            <a href="leerclientes.php">VOLVER</a>
        </nav>

        <h1 class="contrato-titulo">EDITAR CLIENTE</h1>

        <p class="desc">
            Modifica los datos del cliente seleccionado.<br>
            Mantén actualizada la información del sistema.
        </p>

    </section>

    <!-- PANEL DERECHO -->
    <section class="section-blanco">

        <h2>Formulario de Edición</h2>

        <form class="forma" action="registroeditarcliente.php" method="post">

            <input type="hidden" name="idoriginal" value="<?= $id ?>">

            <div class="fil">

                <div>
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="<?= $nombre ?>" required>
                </div>

                <div>
                    <label>Apellido</label>
                    <input type="text" name="apellido" value="<?= $apellido ?>" required>
                </div>

            </div>

            <label>Nombre de usuario</label>
            <input type="text" name="nombreusuario" value="<?= $nombreusuario ?>" required>

            <label>Correo electrónico</label>
            <input type="email" name="correo" value="<?= $correo ?>" required>

            <div class="fil">

                <div>
                    <label>Contraseña</label>
                    <input type="password" name="contraseña" value="<?= $contraseña ?>" required>
                </div>

                <div>
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="fechanacimiento" value="<?= $fechanacimiento ?>" required>
                </div>

            </div>

            <button type="submit">Guardar Cambios</button>

        </form>

    </section>

</section>

</body>
</html>