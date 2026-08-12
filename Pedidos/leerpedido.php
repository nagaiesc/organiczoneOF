<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


/* =========================================================
   VALIDAR ID DEL PEDIDO
========================================================= */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de pedido no válido.");
}

$idPedido = (int) $_GET['id'];

$sql = "SELECT * FROM pedidos WHERE id = ?";
$stmt = $conexion->prepare($sql);

/* =========================================================
   BUSCAR PEDIDO
========================================================= */

$sqlPedido = "SELECT * FROM pedidos WHERE id = ?";

$stmtPedido = $conn->prepare($sqlPedido);

if (!$stmtPedido) {
    die("Error al preparar la consulta del pedido.");
}

$stmtPedido->bind_param("i", $idPedido);
$stmtPedido->execute();

$resultadoPedido = $stmtPedido->get_result();

if ($resultadoPedido->num_rows === 0) {
    die("Pedido no encontrado.");
}

$pedido = $resultadoPedido->fetch_assoc();

$stmtPedido->close();


/* =========================================================
   BUSCAR PRODUCTOS DEL CARRITO
========================================================= */

$sqlCarrito = "
    SELECT
        c.pedidos_id,
        c.productos_id,
        c.cantidad,
        c.costototal,
        p.nombre,
        p.precio,
        p.descripcion
    FROM carrito c
    INNER JOIN productos p
        ON c.productos_id = p.id
    WHERE c.pedidos_id = ?
";

$stmtCarrito = $conn->prepare($sqlCarrito);

if (!$stmtCarrito) {
    die("Error al preparar la consulta del carrito.");
}

$stmtCarrito->bind_param("i", $idPedido);
$stmtCarrito->execute();

$resultadoCarrito = $stmtCarrito->get_result();


/* =========================================================
   FUNCIÓN PARA LIMPIAR DATOS
========================================================= */

function limpiar($dato)
{
    return htmlspecialchars(
        $dato ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}


/* =========================================================
   ESTADO DEL PEDIDO
========================================================= */

$estado = strtolower(
    trim($pedido['estado'] ?? '')
);

$claseEstado = "estado-default";

if ($estado === "pendiente") {

    $claseEstado = "estado-pendiente";

} elseif (
    $estado === "procesando" ||
    $estado === "en proceso"
) {

    $claseEstado = "estado-proceso";

} elseif ($estado === "enviado") {

    $claseEstado = "estado-enviado";

} elseif ($estado === "entregado") {

    $claseEstado = "estado-entregado";

} elseif ($estado === "cancelado") {

    $claseEstado = "estado-cancelado";

}


/* =========================================================
   TOTAL
========================================================= */

$totalFactura = 0;

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Factura #<?= limpiar($pedido['id']) ?>
</title>


<style>

/* =========================================================
   GENERAL
========================================================= */

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body {

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background: #eef1f3;

    color: #222;
}


/* =========================================================
   BARRA SUPERIOR
========================================================= */

.topbar {

    width: 100%;

    background: #111;

    color: white;

    padding: 18px 5%;

    display: flex;

    justify-content: space-between;

    align-items: center;
}

.logo {

    font-size: 22px;

    font-weight: 800;

    letter-spacing: 1px;
}

.logo span {

    color: #8bc34a;
}

.topbar-buttons {

    display: flex;

    gap: 10px;
}

.top-btn {

    text-decoration: none;

    color: white;

    border: 1px solid #555;

    padding: 9px 16px;

    border-radius: 6px;

    font-size: 14px;

    cursor: pointer;

    background: transparent;

    transition: .2s;
}

.top-btn:hover {

    background: #333;
}

.top-btn.green {

    background: #7cb342;

    border-color: #7cb342;
}

.top-btn.green:hover {

    background: #689f38;
}


/* =========================================================
   CONTENEDOR
========================================================= */

.contenedor {

    width: 92%;

    max-width: 1100px;

    margin: 40px auto;
}


/* =========================================================
   FACTURA
========================================================= */

.factura {

    background: white;

    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 10px 35px
        rgba(0,0,0,.10);
}


/* =========================================================
   CABECERA
========================================================= */

.factura-header {

    padding: 40px;

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    border-bottom: 1px solid #e8e8e8;
}

.empresa h1 {

    margin: 0;

    font-size: 30px;
}

.empresa h1 span {

    color: #7cb342;
}

.empresa p {

    margin-top: 8px;

    color: #777;

    font-size: 14px;
}

.factura-titulo {

    text-align: right;
}

.factura-titulo h2 {

    margin: 0;

    font-size: 30px;
}

.numero {

    margin-top: 8px;

    color: #777;

    font-size: 14px;
}


/* =========================================================
   INFORMACIÓN
========================================================= */

.info {

    padding: 30px 40px;

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 40px;

    border-bottom:
        1px solid #eee;
}

.info-box h3 {

    margin:
        0 0 15px;

    font-size: 13px;

    color: #888;

    text-transform:
        uppercase;

    letter-spacing: 1px;
}

.info-box p {

    margin: 7px 0;

    font-size: 15px;

    color: #333;
}

.info-box strong {

    color: #111;
}


/* =========================================================
   ESTADO
========================================================= */

.estado-contenedor {

    padding: 22px 40px;

    background: #fafafa;

    display: flex;

    justify-content:
        space-between;

    align-items: center;
}

.estado-label {

    color: #777;

    font-size: 14px;
}

.estado {

    padding:
        8px 16px;

    border-radius: 30px;

    font-size: 13px;

    font-weight: bold;

    text-transform:
        uppercase;
}

.estado-pendiente {

    background: #fff3cd;

    color: #856404;
}

.estado-proceso {

    background: #cfe2ff;

    color: #084298;
}

.estado-enviado {

    background: #d1ecf1;

    color: #0c5460;
}

.estado-entregado {

    background: #d1e7dd;

    color: #0f5132;
}

.estado-cancelado {

    background: #f8d7da;

    color: #842029;
}

.estado-default {

    background: #e9ecef;

    color: #495057;
}


/* =========================================================
   PRODUCTOS
========================================================= */

.productos {

    padding: 35px 40px;
}

.productos h3 {

    margin-top: 0;

    margin-bottom: 20px;

    font-size: 18px;
}

.tabla {

    width: 100%;

    border-collapse:
        collapse;
}

.tabla th {

    background: #111;

    color: white;

    padding: 14px;

    text-align: left;

    font-size: 13px;
}

.tabla td {

    padding: 16px 14px;

    border-bottom:
        1px solid #eee;

    font-size: 14px;
}

.tabla tr:hover {

    background: #fafafa;
}

.texto-derecha {

    text-align: right;
}

.texto-centro {

    text-align: center;
}

.producto-nombre {

    font-weight: 700;

    color: #222;
}

.producto-descripcion {

    margin-top: 4px;

    color: #888;

    font-size: 12px;
}


/* =========================================================
   SIN PRODUCTOS
========================================================= */

.sin-productos {

    padding: 30px;

    text-align: center;

    color: #888;

    background: #fafafa;

    border-radius: 8px;
}


/* =========================================================
   RESUMEN
========================================================= */

.resumen {

    display: flex;

    justify-content:
        flex-end;

    padding:
        10px 40px 35px;
}

.resumen-box {

    width: 350px;
}

.total-linea {

    display: flex;

    justify-content:
        space-between;

    padding: 10px 0;

    color: #555;
}

.total-final {

    border-top:
        2px solid #111;

    margin-top: 10px;

    padding-top: 18px;

    display: flex;

    justify-content:
        space-between;

    font-size: 24px;

    font-weight: bold;

    color: #111;
}

.total-precio {

    color: #4c8c2b;
}


/* =========================================================
   DIRECCIÓN
========================================================= */

.direccion {

    margin:
        0 40px 35px;

    padding: 20px;

    background: #f6f7f8;

    border-left:
        4px solid #7cb342;

    border-radius: 5px;
}

.direccion h3 {

    margin:
        0 0 8px;

    font-size: 13px;

    color: #777;

    text-transform:
        uppercase;
}

.direccion p {

    margin: 0;

    color: #333;
}


/* =========================================================
   FOOTER
========================================================= */

.factura-footer {

    padding: 25px 40px;

    background: #111;

    color: #aaa;

    text-align: center;

    font-size: 13px;
}

.factura-footer strong {

    color: white;
}


/* =========================================================
   BOTONES
========================================================= */

.acciones {

    margin-top: 25px;

    display: flex;

    justify-content:
        space-between;

    align-items: center;
}

.btn {

    display: inline-block;

    padding:
        12px 20px;

    border-radius: 6px;

    text-decoration: none;

    font-size: 14px;

    font-weight: bold;

    cursor: pointer;

    border: none;

    transition: .2s;
}

.btn-volver {

    background: #555;

    color: white;
}

.btn-volver:hover {

    background: #333;
}

.btn-imprimir {

    background: #111;

    color: white;
}

.btn-imprimir:hover {

    background: #333;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:700px) {

    .topbar {

        flex-direction:
            column;

        gap: 15px;
    }

    .contenedor {

        width: 95%;

        margin:
            20px auto;
    }

    .factura-header {

        padding: 25px;

        flex-direction:
            column;

        gap: 20px;
    }

    .factura-titulo {

        text-align: left;
    }

    .info {

        grid-template-columns:
            1fr;

        padding: 25px;
    }

    .estado-contenedor {

        padding: 20px;

        gap: 15px;

        flex-direction:
            column;

        align-items:
            flex-start;
    }

    .productos {

        padding: 20px;

        overflow-x:
            auto;
    }

    .resumen {

        padding:
            10px 20px 25px;
    }

    .direccion {

        margin:
            0 20px 25px;
    }

    .acciones {

        flex-direction:
            column;

        gap: 10px;

        align-items:
            stretch;
    }

    .btn {

        text-align: center;
    }

}

@media print {

    body {

        background: white;
    }

    .topbar,
    .acciones {

        display: none;
    }

    .contenedor {

        width: 100%;

        max-width: none;

        margin: 0;
    }

    .factura {

        box-shadow: none;

        border-radius: 0;
    }

    .factura-footer {

        background: white;

        color: #555;

        border-top:
            1px solid #ddd;
    }

    .factura-footer strong {

        color: #111;
    }

}

</style>

</head>


<body>


<header class="topbar">
    <div class="logo">

        ORGANIC<span>ZONE</span>

    </div>


    <div class="topbar-buttons">

        <a
            href="leerpedidos.php"
            class="top-btn"
        >
            ← Pedidos
        </a>


        <button
            onclick="window.print()"
            class="top-btn green"
        >
            🖨 Imprimir factura
        </button>

    </div>

</header>


<main class="contenedor">


<div class="factura">

<section class="factura-header">

    <div class="empresa">

        <h1>
            ORGANIC<span>ZONE</span>
        </h1>

        <p>
            Productos naturales y orgánicos
        </p>

    </div>


    <div class="factura-titulo">

        <h2>
            FACTURA
        </h2>

        <div class="numero">

            Nº<?= limpiar($pedido['id']) ?>

        </div>

    </div>

</section>

<section class="info">


    <div class="info-box">

        <h3>
            Información del cliente
        </h3>

        <p>

            <strong>
                <?= limpiar($pedido['nombre']) ?>
            </strong>

        </p>

        <p>

            TELEFONO
            <?= limpiar($pedido['telefono']) ?>

        </p>

        <p>

            DIRECCION
            <?= limpiar($pedido['direccion']) ?>

        </p>

    </div>


    <div class="info-box">

        <h3>
            Información del pedido
        </h3>

        <p>

            Pedido:
            <strong>
                #<?= limpiar($pedido['id']) ?>
            </strong>

        </p>

        <p>

            📅
            <?= limpiar($pedido['fecha']) ?>

        </p>

        <p>

            Vendedor:
            <strong>
                <?= limpiar($pedido['nombrevendedor']) ?>
            </strong>

        </p>

    </div>


</section>

<section class="estado-contenedor">

    <span class="estado-label">

        Estado actual del pedido

    </span>


    <span
        class="estado <?= $claseEstado ?>"
    >

        <?= limpiar($pedido['estado']) ?>

    </span>

</section>
<section class="productos">

    <h3>
        Detalle del pedido
    </h3>


    <?php if ($resultadoCarrito->num_rows > 0): ?>


    <table class="tabla">

        <thead>

            <tr>

                <th>
                    Producto
                </th>

                <th class="texto-centro">
                    Cantidad
                </th>

                <th class="texto-derecha">
                    Precio
                </th>

                <th class="texto-derecha">
                    Subtotal
                </th>

            </tr>

        </thead>


        <tbody>


        <?php while ($producto = $resultadoCarrito->fetch_assoc()): ?>


            <?php

            $cantidad = (int) $producto['cantidad'];

            $precio = (float) $producto['precio'];

            $subtotal = (float) $producto['costototal'];

            $totalFactura += $subtotal;

            ?>


            <tr>


                <td>

                    <div class="producto-nombre">

                        <?= limpiar($producto['nombre']) ?>

                    </div>


                    <?php if (!empty($producto['descripcion'])): ?>

                        <div class="producto-descripcion">

                            <?= limpiar($producto['descripcion']) ?>

                        </div>

                    <?php endif; ?>

                </td>


                <td class="texto-centro">

                    <?= $cantidad ?>

                </td>


                <td class="texto-derecha">
<span class="total-precio">

    Bs. <?= $totalFactura ?>

</span>

                </td>


                <td class="texto-derecha">
<span class="total-precio">

    Bs. <?= $totalFactura ?>

</span>


                </td>


            </tr>


        <?php endwhile; ?>


        </tbody>

    </table>


    <?php else: ?>


        <div class="sin-productos">

            Este pedido todavía no tiene productos.

        </div>


    <?php endif; ?>


</section>
<section class="resumen">

    <div class="resumen-box">


        <div class="total-linea">

            <span>
                Pedido
            </span>

            <span>
                #<?= limpiar($pedido['id']) ?>
            </span>

        </div>


        <div class="total-linea">

            <span>
                Productos
            </span>

            <span>
                <?= $resultadoCarrito->num_rows ?>
            </span>

        </div>


        <div class="total-final">

            <span>
                TOTAL
            </span>

            <span class="total-precio">

                Bs.
<span class="total-precio">

    Bs. <?= $totalFactura ?>

</span>


            </span>

        </div>


    </div>

</section>


<section class="direccion">

    <h3>
        Dirección de entrega
    </h3>

    <p>

        <?= limpiar($pedido['direccion']) ?>

    </p>

</section>
<footer class="factura-footer">

    <strong>
        Gracias por comprar en OrganicZone
    </strong>

    <br>

    Esta factura corresponde al pedido
    #<?= limpiar($pedido['id']) ?>.

</footer>


</div>
<div class="acciones">

    <a
        href="leerpedidos.php"
        class="btn btn-volver"
    >
        ← Volver a pedidos
    </a>


    <button
        onclick="window.print()"
        class="btn btn-imprimir"
    >
        🖨 Imprimir factura
    </button>

</div>


</main>


</body>

</html>

<?php

$stmtCarrito->close();

$conn->close();

?>

