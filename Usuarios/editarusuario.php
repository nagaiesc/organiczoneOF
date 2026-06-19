<?php
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conn = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

if ($conn->connect_error) {
    die("Hubo un error en la conexion");
}

$CI = $_GET['CI'];

$sql = "SELECT * FROM usuarios WHERE CI = $CI";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $nombre = $fila['nombre'];
    $direccion = $fila['direccion'];
    $celular = $fila['celular'];
    $rol = $fila['rol'];
    $estado = $fila['estado'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Usuario</title>

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

.forma input,
.forma select {
    width: 100%;
    border: none;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 8px 0;
    font-size: 16px;
    background: none;
    outline: none;
}

.forma input:focus,
.forma select:focus {
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
            <a href="leerusuarios.php">VOLVER</a>
        </nav>

        <h1 class="contrato-titulo">EDITAR USUARIO</h1>

        <p class="desc">
            Modifica los datos del usuario seleccionado.<br>
            Mantén actualizada la información del sistema.
        </p>

    </section>

    <!-- PANEL DERECHO -->
    <section class="section-blanco">

        <h2>Formulario de Edición</h2>

        <form class="forma" action="registroeditarusuario.php" method="post">

            <input type="hidden" name="CI" value="<?= $CI ?>">

           

            <label>Nombre del usuario</label>
            <input type="text" name="nombre" value="<?= $nombre ?>" required>

            <div class="fil">

                <div>
                    <label>Dirección</label>
                    <input type="text" name="direccion" value="<?= $direccion ?>" required>
                </div>

                <div>
                    <label>Celular</label>
                    <input type="text" name="celular" value="<?= $celular ?>" required>
                </div>

            </div>

            <div class="fil">

                <div>
                    <label>Rol</label>

                    <select name="rol" required>
                        <option value="admin" <?= $rol == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="usuario" <?= $rol == 'usuario' ? 'selected' : '' ?>>Usuario</option>
                    </select>
                </div>

                <div>
                    <label>Estado</label>

                    <select name="estado" required>
                        <option value="activo" <?= $estado == 'activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="inactivo" <?= $estado == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

            </div>

            <button type="submit">Guardar Cambios</button>

        </form>

    </section>

</section>

</body>
</html>