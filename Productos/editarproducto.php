<?php
$conexion = new mysqli("localhost", "root", "", "productosOZ");

if ($conexion->connect_error) {
    die("Error en la conexión");
}

$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id = $id";
$resultado = $conexion->query($sql);

$fila = $resultado->fetch_assoc();

$nombreproducto = $fila['nombreproducto'];
$precioventa = $fila['precioventa'];
$cantidad = $fila['cantidad'];
$costo = $fila['costo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Producto</title>

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

.forma button {
    width: 100%;
    background: #000;
    color: #fff;
    border: none;
    padding: 10px;
    font-weight: 600;
    cursor: pointer;
}

.forma button:hover {
    background: #222;
}
</style>
</head>

<body>

<section class="principal-grid">

    <!-- PANEL NEGRO -->
    <section class="section-negro">
        <nav class="nav-inner">
            <a href="leerproductos.php">VOLVER</a>
        </nav>

        <h1 class="contrato-titulo">EDITAR PRODUCTO</h1>

        <p class="desc">
            Modifica los datos del producto seleccionado.<br>
            Mantén actualizado el stock y los precios.
        </p>
    </section>

    <!-- PANEL BLANCO -->
    <section class="section-blanco">

        <h2>Formulario de Edición</h2>

        <form class="forma" action="registroeditarproducto.php" method="post">

            <input type="hidden" name="id" value="<?= $id ?>" readonly>

            <label>Nombre del producto</label>
            <input type="text" name="nombreproducto" value="<?= $nombreproducto ?>" required>

            <div class="fil">
                <div>
                    <label>Precio venta</label>
                    <input type="number" name="precioventa" value="<?= $precioventa ?>" required>
                </div>

                <div>
                    <label>Costo</label>
                    <input type="number" name="costo" value="<?= $costo ?>" required>
                </div>
            </div>

            <div class="fil">
                <div>
                    <label>Cantidad</label>
                    <input type="number" name="cantidad" value="<?= $cantidad ?>" required>
                </div>

            </div>

            <button type="submit">Guardar Cambios</button>

        </form>

    </section>

</section>

</body>
</html>