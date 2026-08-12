<?php

session_start();

if (!isset($_SESSION['CI'])) {

    header("Location: Usuarios/formulariosesion.php");
    exit();

}

if ($_SESSION['rol'] != "cliente") {

    die("Esta página es solamente para clientes.");

}


$conexion = new mysqli("localhost", "root", "", "organiczoneBD");

if ($conexion->connect_error) {

    die("Error de conexión: " . $conexion->connect_error);

}


$sql = "SELECT * FROM productos";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>OrganicZone | Productos</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap"
rel="stylesheet">


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


body{

    background:#F4F1EE;

    font-family:'Nunito',sans-serif;

    color:#2B140D;

    min-height:100vh;

}


/* ENCABEZADO */

.encabezado{

    padding:50px 8% 30px;

}


.logo{

    font-family:'Fredoka',sans-serif;

    font-size:28px;

    color:#0BA84A;

    font-weight:700;

}


.titulo{

    font-family:'Fredoka',sans-serif;

    font-size:65px;

    line-height:1;

    margin-top:15px;

}


.titulo span{

    color:#0BA84A;

}


.subtitulo{

    margin-top:15px;

    color:#777;

    font-size:18px;

}


/* PRODUCTOS */

.contenedor-productos{

    width:85%;

    margin:auto;

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));

    gap:30px;

    padding-bottom:80px;

}


.card-producto{

    background:white;

    border-radius:40px;

    padding:20px;

    box-shadow:
    0 10px 30px rgba(43,20,13,.12);

    transition:.3s;

}


.card-producto:hover{

    transform:translateY(-7px);

}


.imagen-producto{

    width:100%;

    height:220px;

    object-fit:cover;

    border-radius:30px;

    background:#F4FFEF;

}


.nombre-producto{

    font-family:'Fredoka',sans-serif;

    font-size:27px;

    margin-top:18px;

}


.descripcion{

    color:#777;

    margin-top:8px;

    min-height:45px;

}


.precio{

    color:#0BA84A;

    font-size:25px;

    font-weight:800;

    margin-top:15px;

}


.boton-agregar{

    width:100%;

    border:none;

    margin-top:15px;

    padding:14px;

    border-radius:30px;

    background:#2B140D;

    color:white;

    font-family:'Fredoka',sans-serif;

    font-size:18px;

    font-weight:600;

    cursor:pointer;

    transition:.3s;

}


.boton-agregar:hover{

    background:#0BA84A;

    transform:scale(1.02);

}


/* CARRITO */

.carrito{

    position:fixed;

    right:30px;

    bottom:30px;

    width:360px;

    max-height:80vh;

    overflow:auto;

    background:white;

    border-radius:35px;

    padding:25px;

    box-shadow:
    0 15px 50px rgba(43,20,13,.25);

    z-index:2000;

}


.carrito-titulo{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}


.carrito-titulo h2{

    font-family:'Fredoka',sans-serif;

    font-size:28px;

}


.contador{

    background:#0BA84A;

    color:white;

    width:35px;

    height:35px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:800;

}


.producto-carrito{

    display:flex;

    justify-content:space-between;

    gap:15px;

    padding:15px 0;

    border-bottom:1px solid #eee;

}


.producto-carrito p{

    color:#777;

    margin-top:5px;

}


.total{

    display:flex;

    justify-content:space-between;

    font-size:22px;

    font-weight:800;

    margin-top:20px;

}


.carrito-vacio{

    text-align:center;

    color:#888;

    padding:20px 0;

}


/* RESPONSIVE */

@media(max-width:700px){

    .titulo{

        font-size:45px;

    }

    .carrito{

        width:calc(100% - 40px);

        right:20px;

        bottom:20px;

    }

}

</style>

</head>


<body>


<header class="encabezado">

    <div class="logo">
        OrganicZone
    </div>

    <h1 class="titulo">
        Productos <span>para ti</span>
    </h1>

    <p class="subtitulo">
        Elige tus productos favoritos y agrégalos a tu carrito.
    </p>

</header>


<section class="contenedor-productos">

<?php

if ($resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $id = $fila['id'];

        $imagen = "Imagenes/sinimagen.png";


        $extensiones = [
            "jpg",
            "jpeg",
            "png",
            "gif",
            "webp"
        ];


        foreach ($extensiones as $ext) {

            $rutaArchivo =
            "Imagenes/P-" . $id . "." . $ext;


            if (file_exists($rutaArchivo)) {

                $imagen = $rutaArchivo;

                break;

            }

        }

?>

<div class="card-producto">


    <img
        src="<?= $imagen ?>"
        class="imagen-producto"
        alt="<?= htmlspecialchars($fila['nombre']) ?>"
    >


    <h2 class="nombre-producto">

        <?= htmlspecialchars($fila['nombre']) ?>

    </h2>


    <p class="descripcion">

        <?= htmlspecialchars($fila['descripcion']) ?>

    </p>


    <p class="precio">

        Bs. <?= $fila['precio'] ?>

    </p>


    <button
        class="boton-agregar"
        onclick="agregarProducto(<?= $id ?>)"
    >

        Agregar al carrito

    </button>


</div>

<?php

    }

} else {

    echo "<p>No hay productos registrados.</p>";

}

?>

</section>


<!-- CARRITO -->

<section class="carrito">

    <div class="carrito-titulo">

        <h2>Mi carrito</h2>

        <span
            class="contador"
            id="contador-carrito"
        >
            0
        </span>

    </div>


    <div id="lista-carrito">

        <p class="carrito-vacio">
            Tu carrito está vacío
        </p>

    </div>


    <div class="total">

        <span>Total</span>

        <span id="total-carrito">
            Bs. 0
        </span>

    </div>

</section>


<script src="Cliente/pedido.js"></script>


<script>

document.addEventListener(
    "DOMContentLoaded",
    function(){

        mostrarCarrito();

    }
);

</script>


</body>

</html>