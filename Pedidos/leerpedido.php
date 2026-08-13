<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


/* ==========================================
   VALIDAR ID
========================================== */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de pedido no válido.");
}

$idPedido = (int) $_GET['id'];


/* ==========================================
   OBTENER PEDIDO
========================================== */

$sqlPedido = "
    SELECT *
    FROM pedidos
    WHERE id = ?
";

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


/* ==========================================
   OBTENER PRODUCTOS
========================================== */

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


/* ==========================================
   FUNCIÓN LIMPIAR
========================================== */

function limpiar($dato)
{
    return htmlspecialchars(
        $dato ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}


/* ==========================================
   ESTADO
========================================== */

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


<!-- ==========================================
     FREDOKA
========================================== -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

/* ==========================================
   GENERAL
========================================== */

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body {

    background: #ffffff;

    color: #2B140D;

    font-family:
        'Fredoka',
        Arial,
        sans-serif;

    min-height: 100vh;

}


/* ==========================================
   BARRA SUPERIOR
   ESTILO PARECIDO A TU NAV
========================================== */

.topbar {

    position: relative;

    width: 92%;

    max-width: 1350px;

    min-height: 68px;

    margin: 20px auto 0;

    background:
        rgba(43, 20, 13, 0.96);

    border-radius: 50px;

    padding:
        0 25px;

    display: flex;

    justify-content:
        space-between;

    align-items:
        center;

    box-shadow:
        0 8px 25px
        rgba(0, 0, 0, 0.18);

    font-family:
        'Fredoka',
        sans-serif;

}


/* ==========================================
   LOGO
========================================== */

.logo {

    text-decoration: none;

    color: white;

    font-size: 27px;

    font-weight: 700;

    letter-spacing:
        0.5px;

}


.logo span {

    color: #0ba84a;

}


/* ==========================================
   BOTONES DEL NAV
========================================== */

.topbar-buttons {

    display: flex;

    align-items: center;

    gap: 10px;

}


.top-btn {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    text-decoration: none;

    color: white;

    padding:
        11px 18px;

    border-radius: 30px;

    border: none;

    background:
        rgba(255,255,255,0.13);

    font-family:
        'Fredoka',
        sans-serif;

    font-size: 16px;

    font-weight: 500;

    cursor: pointer;

    transition:
        0.3s ease;

}


.top-btn:hover {

    background:
        rgba(252, 208, 159, 0.90);

    color: #2B140D;

    transform:
        translateY(-2px);

}


/* BOTÓN IMPRIMIR */

.top-btn.green {

    background: #0ba84a;

    color: white;

}


.top-btn.green:hover {

    background: #098f40;

    color: white;

    transform:
        translateY(-2px);

    box-shadow:
        0 5px 15px
        rgba(11,168,74,0.30);

}


/* ==========================================
   CONTENEDOR
========================================== */

.contenedor {

    width: 92%;

    max-width: 1100px;

    margin:
        35px auto 50px;

}


/* ==========================================
   FACTURA
========================================== */

.factura {

    background: white;

    border-radius: 20px;

    overflow: hidden;

    border:
        1px solid #eeeeee;

    box-shadow:
        0 10px 35px
        rgba(43,20,13,0.09);

}


/* ==========================================
   CABECERA
========================================== */

.factura-header {

    padding: 40px;

    display: flex;

    justify-content:
        space-between;

    align-items:
        flex-start;

    border-bottom:
        1px solid #eeeeee;

}


.empresa h1 {

    margin: 0;

    font-size: 34px;

    font-weight: 700;

}


.empresa h1 span {

    color: #0ba84a;

}


.empresa p {

    margin:
        8px 0 0;

    color: #888;

    font-size: 14px;

}


.factura-titulo {

    text-align: right;

}


.factura-titulo h2 {

    margin: 0;

    font-size: 32px;

    font-weight: 700;

    color: #2B140D;

}


.numero {

    margin-top: 7px;

    color: #888;

    font-size: 14px;

}


/* ==========================================
   INFORMACIÓN
========================================== */

.info {

    padding:
        30px 40px;

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 40px;

    border-bottom:
        1px solid #eeeeee;

}


.info-box h3 {

    margin:
        0 0 15px;

    font-size: 12px;

    color: #888;

    text-transform:
        uppercase;

    letter-spacing:
        1px;

}


.info-box p {

    margin:
        8px 0;

    font-size: 15px;

    color: #444;

}


.info-box strong {

    color: #2B140D;

}


/* ==========================================
   ESTADO
========================================== */

.estado-contenedor {

    padding:
        20px 40px;

    background:
        #fafafa;

    display: flex;

    justify-content:
        space-between;

    align-items:
        center;

    border-bottom:
        1px solid #eeeeee;

}


.estado-label {

    color: #777;

    font-size: 14px;

}


.estado {

    padding:
        8px 17px;

    border-radius:
        30px;

    font-size:
        12px;

    font-weight:
        700;

    text-transform:
        uppercase;

}


/* ESTADOS */

.estado-pendiente {

    background: #fff3cd;

    color: #856404;

}


.estado-proceso {

    background: #dcecff;

    color: #24527a;

}


.estado-enviado {

    background: #d8f1f2;

    color: #27666b;

}


.estado-entregado {

    background: #d9f2dc;

    color: #24652b;

}


.estado-cancelado {

    background: #f8d7da;

    color: #842029;

}


.estado-default {

    background: #eeeeee;

    color: #555;

}


/* ==========================================
   PRODUCTOS
========================================== */

.productos {

    padding:
        35px 40px 20px;

}


.productos h3 {

    margin:
        0 0 20px;

    font-size: 20px;

    color: #2B140D;

}


/* ==========================================
   TABLA
========================================== */

.tabla {

    width: 100%;

    border-collapse:
        separate;

    border-spacing: 0;

    border:
        1px solid #e9e9e9;

    border-radius:
        12px;

    overflow: hidden;

}


.tabla th {

    background: #2B140D;

    color: white;

    padding: 15px;

    text-align: left;

    font-size: 13px;

    font-weight: 600;

}


.tabla td {

    padding:
        16px 15px;

    border-bottom:
        1px solid #eeeeee;

    font-size: 14px;

    color: #444;

}


.tabla tr:last-child td {

    border-bottom:
        none;

}


.tabla tbody tr:hover {

    background:
        #fafafa;

}


.texto-derecha {

    text-align: right;

}


.texto-centro {

    text-align: center;

}


/* ==========================================
   PRODUCTO
========================================== */

.producto-nombre {

    font-weight:
        600;

    color:
        #2B140D;

}


.producto-descripcion {

    margin-top:
        4px;

    color:
        #999;

    font-size:
        12px;

}


/* ==========================================
   RESUMEN
========================================== */

.resumen {

    display: flex;

    justify-content:
        flex-end;

    padding:
        15px 40px 35px;

}


.resumen-box {

    width: 350px;

    padding:
        18px 22px;

    background:
        #fafafa;

    border:
        1px solid #eeeeee;

    border-radius:
        14px;

}


.total-linea {

    display: flex;

    justify-content:
        space-between;

    padding:
        8px 0;

    color:
        #666;

    font-size:
        14px;

}


.total-final {

    border-top:
        2px solid #2B140D;

    margin-top:
        10px;

    padding-top:
        16px;

    display: flex;

    justify-content:
        space-between;

    font-size:
        23px;

    font-weight:
        700;

    color:
        #2B140D;

}


.total-precio {

    color:
        #0ba84a;

}


/* ==========================================
   DIRECCIÓN
========================================== */

.direccion {

    margin:
        0 40px 35px;

    padding:
        20px;

    background:
        #f7f7f7;

    border-left:
        5px solid #0ba84a;

    border-radius:
        10px;

}


.direccion h3 {

    margin:
        0 0 8px;

    font-size:
        12px;

    color:
        #888;

    text-transform:
        uppercase;

    letter-spacing:
        1px;

}


.direccion p {

    margin:
        0;

    color:
        #444;

    font-size:
        14px;

}


/* ==========================================
   FOOTER
========================================== */

.factura-footer {

    padding:
        27px 40px;

    background:
        #2B140D;

    color:
        #bdb1ac;

    text-align:
        center;

    font-size:
        13px;

}


.factura-footer strong {

    color:
        white;

    font-size:
        14px;

}


/* ==========================================
   BOTONES INFERIORES
========================================== */

.acciones {

    margin-top:
        25px;

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        center;

}


.btn {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    padding:
        12px 20px;

    border-radius:
        30px;

    text-decoration:
        none;

    font-family:
        'Fredoka',
        sans-serif;

    font-size:
        15px;

    font-weight:
        600;

    cursor:
        pointer;

    border:
        none;

    transition:
        0.3s ease;

}


/* VOLVER */

.btn-volver {

    background:
        #2B140D;

    color:
        white;

}


.btn-volver:hover {

    background:
        #4a2519;

    transform:
        translateY(-2px);

}


/* IMPRIMIR */

.btn-imprimir {

    background:
        #0ba84a;

    color:
        white;

}


.btn-imprimir:hover {

    background:
        #098f40;

    transform:
        translateY(-2px);

    box-shadow:
        0 5px 15px
        rgba(11,168,74,0.25);

}


/* ==========================================
   RESPONSIVE
========================================== */

@media(max-width: 700px) {


    .topbar {

        width: 95%;

        padding:
            0 15px;

        min-height:
            60px;

    }


    .logo {

        display:
            none;

    }


    .topbar {

        justify-content:
            center;

    }


    .topbar-buttons {

        gap:
            5px;

    }


    .top-btn {

        padding:
            9px 12px;

        font-size:
            13px;

    }


    .contenedor {

        width:
            95%;

        margin-top:
            25px;

    }


    .factura-header {

        padding:
            28px;

        flex-direction:
            column;

        gap:
            20px;

    }


    .factura-titulo {

        text-align:
            left;

    }


    .info {

        grid-template-columns:
            1fr;

        padding:
            25px;

        gap:
            20px;

    }


    .estado-contenedor {

        padding:
            20px 25px;

        gap:
            15px;

        flex-direction:
            column;

        align-items:
            flex-start;

    }


    .productos {

        padding:
            25px 20px 15px;

        overflow-x:
            auto;

    }


    .tabla {

        min-width:
            650px;

    }


    .resumen {

        padding:
            15px 20px 25px;

    }


    .resumen-box {

        width:
            100%;

    }


    .direccion {

        margin:
            0 20px 25px;

    }


    .factura-footer {

        padding:
            25px 20px;

    }


    .acciones {

        flex-direction:
            column;

        gap:
            10px;

        align-items:
            stretch;

    }


    .btn {

        width:
            100%;

    }

}


/* ==========================================
   IMPRESIÓN
========================================== */

@media print {


    body {

        background:
            white;

    }


    .topbar,
    .acciones {

        display:
            none !important;

    }


    .contenedor {

        width:
            100%;

        max-width:
            none;

        margin:
            0;

    }


    .factura {

        box-shadow:
            none;

        border-radius:
            0;

        border:
            none;

    }


    .factura-footer {

        background:
            white;

        color:
            #555;

        border-top:
            1px solid #ddd;

    }


    .factura-footer strong {

        color:
            #2B140D;

    }

}

</style>

</head>


<body>


<!-- ==========================================
     BARRA SUPERIOR
========================================== -->

<header class="topbar">


    <a
        href="paginaprincipal.php"
        class="logo"
    >

        Organic<span>Zone</span>

    </a>


    <div class="topbar-buttons">


        <!-- VOLVER A PEDIDOS -->

        <a
            href="leerpedidos.php"
            class="top-btn"
        >

            ← Pedidos

        </a>


        <!-- IMPRIMIR -->

        <button
            onclick="window.print()"
            class="top-btn green"
        >

            🖨 Imprimir factura

        </button>


    </div>


</header>



<!-- ==========================================
     CONTENEDOR PRINCIPAL
========================================== -->

<main class="contenedor">


<div class="factura">


<!-- ==========================================
     CABECERA DE FACTURA
========================================== -->

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



<!-- ==========================================
     INFORMACIÓN
========================================== -->

<section class="info">


    <div class="info-box">


        <h3>

            Información del cliente

        </h3>


        <p>

            <strong>

                <?= limpiar(
                    $pedido['nombre']
                ) ?>

            </strong>

        </p>


        <p>

            <strong>
                Teléfono:
            </strong>

            <?= limpiar(
                $pedido['telefono']
            ) ?>

        </p>


        <p>

            <strong>
                Dirección:
            </strong>

            <?= limpiar(
                $pedido['direccion']
            ) ?>

        </p>


    </div>



    <div class="info-box">


        <h3>

            Información del pedido

        </h3>


        <p>

            Pedido:

            <strong>

                #<?= limpiar(
                    $pedido['id']
                ) ?>

            </strong>

        </p>


        <p>

            Fecha:

            <strong>

                <?= limpiar(
                    $pedido['fecha']
                ) ?>

            </strong>

        </p>


        <p>

            Vendedor:

            <strong>

                <?= limpiar(
                    $pedido['nombrevendedor']
                ) ?>

            </strong>

        </p>


    </div>


</section>



<!-- ==========================================
     ESTADO
========================================== -->

<section class="estado-contenedor">


    <span class="estado-label">

        Estado actual del pedido

    </span>


    <span
        class="estado <?= $claseEstado ?>"
    >

        <?= limpiar(
            $pedido['estado']
        ) ?>

    </span>


</section>



<!-- ==========================================
     PRODUCTOS
========================================== -->

<section class="productos">


    <h3>

        Detalle del pedido

    </h3>


    <?php if (
        $resultadoCarrito->num_rows > 0
    ): ?>


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


        <?php while (
            $producto =
            $resultadoCarrito->fetch_assoc()
        ): ?>


            <?php

            $cantidad =
                (int)
                $producto['cantidad'];


            $precio =
                (float)
                $producto['precio'];


            $subtotal =
                (float)
                $producto['costototal'];


            $totalFactura +=
                $subtotal;

            ?>


            <tr>


                <td>


                    <div class="producto-nombre">

                        <?= limpiar(
                            $producto['nombre']
                        ) ?>

                    </div>


                    <?php if (
                        !empty(
                            $producto['descripcion']
                        )
                    ): ?>

                        <div class="producto-descripcion">

                            <?= limpiar(
                                $producto['descripcion']
                            ) ?>

                        </div>

                    <?php endif; ?>


                </td>


                <td class="texto-centro">

                    <?= $cantidad ?>

                </td>


                <td class="texto-derecha">

                    Bs.
                    <?= number_format(
                        $precio,
                        2
                    ) ?>

                </td>


                <td class="texto-derecha">


                    <strong class="total-precio">

                        Bs.
                        <?= number_format(
                            $subtotal,
                            2
                        ) ?>

                    </strong>


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



<!-- ==========================================
     RESUMEN
========================================== -->

<section class="resumen">


    <div class="resumen-box">


        <div class="total-linea">


            <span>

                Pedido

            </span>


            <span>

                #<?= limpiar(
                    $pedido['id']
                ) ?>

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
                <?= number_format(
                    $totalFactura,
                    2
                ) ?>

            </span>


        </div>


    </div>


</section>



<!-- ==========================================
     DIRECCIÓN
========================================== -->

<section class="direccion">


    <h3>

        Dirección de entrega

    </h3>


    <p>

        <?= limpiar(
            $pedido['direccion']
        ) ?>

    </p>


</section>



<!-- ==========================================
     FOOTER
========================================== -->

<footer class="factura-footer">


    <strong>

        Gracias por comprar en OrganicZone

    </strong>


    <br>


    Productos naturales, orgánicos
    y preparados con dedicación.


    <br><br>


    Cochabamba, Bolivia · 2026


</footer>


</div>



<!-- ==========================================
     BOTONES INFERIORES
========================================== -->

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