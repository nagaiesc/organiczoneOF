<?php
$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {
    die("Error en la conexión");
}

$pedidos_id = $_GET['pedidos_id'];
$productos_id = $_GET['productos_id'];

$sql = "SELECT * FROM carrito WHERE pedidos_id = $pedidos_id AND productos_id = $productos_id";
$resultado = $conexion->query($sql);

$fila = $resultado->fetch_assoc();

$cantidad = $fila['cantidad'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Carrito</title>

<style>
body {
    background:#EAF7EC;
    margin:0;
    font-family:'Inter', Arial, Helvetica, sans-serif;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.principal-grid{
    background:white;
    width:90%;
    max-width:1000px;
    display:grid;
    grid-template-columns:320px 1fr;
    border-radius:60px;
    overflow:hidden;
    box-shadow:0 10px 35px rgba(43,20,13,.25);
}

.section-negro{
    background:#2B140D;
    color:white;
    padding:45px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}



.nav-inner a{
    color:#FCD09F;
    text-decoration:none;
    font-weight:700;
}



.contrato-titulo{
    font-size:45px;
    line-height:1;
    margin-top:50px;
    font-weight:900;
}

.desc{
    color:#EAF7EC;
    line-height:1.5;
}

.section-blanco{
    background:white;
    padding:55px;
}

.section-blanco h2{
    font-size:38px;
    font-weight:900;
    color:#2B140D;
    margin-bottom:35px;
}

.forma label{
    font-weight:600;
    color:#2B140D;
}

.forma input{
    width:100%;
    border:none;
    border-bottom:2px solid #ccc;
    padding:12px 5px;
    font-size:18px;
    outline:none;
    margin-bottom:25px;
    background:none;
}

.forma input:focus{
    border-bottom:2px solid #12A33C;
}

.forma .fil{
    display:flex;
}

.forma button{
    width:100%;
    background:#2B140D;
    color:white;
    border:none;
    border-radius:20px;
    padding:14px;
    font-size:17px;
    font-weight:700;
    cursor:pointer;
    transition:.2s;
}

.forma button:hover{
    background:#12A33C;
}

@media(max-width:800px){
.principal-grid{
    grid-template-columns:1fr;
    border-radius:40px;
}
.section-negro{
    padding:30px;
}
.contrato-titulo{
    font-size:35px;
}
}
</style>
</head>

<body>

<section class="principal-grid">

    <!-- PANEL NEGRO -->
    <section class="section-negro">
        <nav class="nav-inner">
            <a href="leercarrito.php">VOLVER</a>
        </nav>

        <h1 class="contrato-titulo">EDITAR<br>CARRITO</h1>

        <p class="desc">
            Modifica los datos del carrito seleccionado.<br>
            Mantén actualizado el stock y los precios.
        </p>
    </section>

    <!-- PANEL BLANCO -->
    <section class="section-blanco">

        <h2>Formulario de Edición</h2>

        <form class="forma" action="registroeditarcarrito.php" method="post">

            <input type="hidden" name="pedidos_id" value="<?= $pedidos_id ?>" readonly>
            <input type="hidden" name="productos_id" value="<?= $productos_id ?>" readonly>


            <div class="fil">
                <div>
                    <label>Cantidad</label>
                    <input type="number" name="cantidad" value="<?= $cantidad ?>" min="1" required>
                </div>
            </div>

            <button type="submit">Guardar Cambios</button>

        </form>

    </section>

</section>

</body>
</html>