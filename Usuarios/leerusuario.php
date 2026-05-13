<?php

$nombreServidor = "localhost";
$nombreUsuario = "root";
$contraseñaBaseDeDatos = "";
$nombreBaseDeDatos = "organiczoneBD";

$conexion = new mysqli(
    $nombreServidor,
    $nombreUsuario,
    $contraseñaBaseDeDatos,
    $nombreBaseDeDatos
);

if ($conexion->connect_error) {
    die("Hubo un error en la conexion");
}

if (!isset($_GET['CI'])) {
    die("CI no recibido");
}

$CI = intval($_GET['CI']);

$sql = "SELECT * FROM clientes WHERE CI = $CI";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

} else {

    die("Cliente no encontrado");

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle Cliente</title>

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

/* CONTENEDOR */
.principal-grid {
    display: grid;
    grid-template-columns: 440px 1fr;
    width: 96vw;
    max-width: 1200px;
    min-height: 600px;
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
    font-size: 2.3em;
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

/* CARD */
.card {
    max-width: 100%;
}

/* CAMPOS */
.campo {
    margin-bottom: 25px;
}

.campo span {
    display: block;
    font-size: 13px;
    color: #777;
    margin-bottom: 5px;
}

.campo strong {
    font-size: 19px;
    color: #111;
}

/* BOTÓN */
.btn {
    display: inline-block;
    margin-top: 20px;
    background: #000;
    color: #fff;
    padding: 10px 18px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: #222;
}

</style>
</head>

<body>

<section class="principal-grid">
    <section class="section-negro">

        <nav class="nav-inner">
            <a href="leerclientes.php">VOLVER</a>
        </nav>

        <h1 class="contrato-titulo">
            DETALLE CLIENTE
        </h1>

        <p class="desc">
            Visualiza la información completa del cliente seleccionado.
        </p>

    </section>

    <!-- PANEL DERECHO -->
    <section class="section-blanco">

        <div class="card">

            <div class="campo">
                <span>CI</span>
                <strong><?= $fila['CI'] ?></strong>
            </div>

            <div class="campo">
                <span>Nombre</span>
                <strong><?= $fila['nombre'] ?></strong>
            </div>

            <div class="campo">
                <span>Direccion</span>
                <strong><?= $fila['direccion'] ?></strong>
            </div>

            <div class="campo">
                <span>Celular</span>
                <strong><?= $fila['celular'] ?></strong>
            </div>

            <div class="campo">
                <span>Rol</span>
                <strong><?= $fila['rol'] ?></strong>
            </div>

            <div class="campo">
                <span>Estado</span>
                <strong><?= $fila['estado'] ?></strong>
            </div>

            <a class="btn" href="leerclientes.php">
                Volver
            </a>

        </div>

    </section>

</section>

</body>
</html>